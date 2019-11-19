<?php

namespace App\Http\Controllers;

use App\Theme;

class FrontendPageController extends Controller
{
    public function index()
    {
        return view(Theme::current().'home/index');
    }
}