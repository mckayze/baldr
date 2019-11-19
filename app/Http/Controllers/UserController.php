<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getAll()
    {
        return User::with('roles')->get();
    }

    public function getById()
    {
        return User::with('roles')->where('id', Request::input('id'))->first();
    }

    public function create()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required',
        ]);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        // If not create the user
        try {
            $user = User::create([
                'username' => Request::input('username'),
                'name' => Request::input('name'),
                'email' => Request::input('email'),
                'password' => bcrypt(Request::input('password')),
            ]);
            $user->assignRole(Request::input('role'));
        } catch(\Exception $e)
        {
            return $e->getMessage();
        }

        return [
            'status'     => 200,
            'statusText' => 'User has been created.',
        ];
    }

    public function edit()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);


        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        $user = User::find(Request::input('id'));
        $user->username = Request::input('username');
        $user->name = Request::input('name');
        $user->email = Request::input('email');

        // Check for passwords
        if(Request::input('password') !== '')
        {
            if(Request::input('password') !== Request::input('password_confirmation'))
            {
                return [
                    'status'     => 500,
                    'statusText' => 'An error occurred',
                    'errors'     => [
                        'password' => 'Those passwords do not match!'
                    ]
                ];
            }

            $user->password = bcrypt(Request::input('password'));
        }
        $user->save();

        // Important role check, user 1 can never be anything other than a Super Administrator else the security of he app
        // will be compromised.
        if($user->id === 1 && Request::input('role') !== 'Super Administrator')
        {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => [
                    'auth' => 'Cannot change the role this user!'
                ]
            ];
        }

        $user->syncRoles([Request::input('role')]);
        return $user;
    }

    public function bulkEditRoles()
    {
        if(!Auth::user()->can('Edit Users'))
        {
            return abort('405');
        }


        foreach(Request::input('users') as $current)
        {
            $user = User::find($current['id']);
            $user->syncRoles([Request::input('role')]);
        }

        return [
            'status' => 200,
            'statusText' => 'Successfully altered all users'
        ];
    }
}