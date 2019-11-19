<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function getAll()
    {
        return Permission::all()->groupBy('for');
    }
}
