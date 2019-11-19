<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function create()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'name' => 'required|unique:roles',
        ]);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        Role::create(['name' => Request::input('name')])
        ->givePermissionTo(Request::input('permissions'));

        return [
            'status' => 200,
            'statusText' => 'Successfully created new role'
        ];
    }

    public function get()
    {
//        return Request::all();
        return Role::with('permissions')->where('id', Request::input('id'))->first();
    }

    public function edit()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'name' => 'required',
            'id'   => 'required'
        ]);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        $role = Role::find(Request::input('id'));

        if($role->name != Request::input('name'))
        {
            if(Role::where('name', Request::input('name'))->exists())
            {
                return [
                    'status'     => 500,
                    'statusText' => 'An error occurred',
                    'errors'     => [
                        'name' => 'That name has already been taken.'
                    ]
                ];
            }
        }

        // All authentication passed, update the role.
        $role->name = Request::input('name');
        $role->save();

        $role->syncPermissions(Request::input('permissions'));

        return [
            'status' => 200,
            'statusText' => 'Successfully edited role'
        ];
    }
}
