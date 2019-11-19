<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BackendPageController extends Controller
{
    public function login()
    {
        return Auth::check() ? redirect('/admin/dashboard') : view('backend.login.index');
    }

    public function dashboard()
    {
        return Auth::user()->can('View Dashboard Page') ? view('backend.dashboard.index') : abort(404);
    }

    public function users()
    {
        return Auth::user()->can('View All Users Page') ? view('backend.users.all.index') : abort(404);
    }

    public function createUser()
    {
        return view('backend.users.create.index');
    }

    public function editUser()
    {
        return view('backend.users.edit.index');
    }

    public function roles()
    {
        return view('backend.roles.all.index');
    }

    public function createRole()
    {
        return view('backend.roles.create.index');
    }

    public function editRole()
    {
        return view('backend.roles.edit.index');
    }

    public function posts()
    {
        return view('backend.posts.all.index');
    }

    public function createPost()
    {
        return view('backend.posts.create.index');
    }

    public function mediaManager()
    {
        return view('backend.media.manager.index');
    }
}