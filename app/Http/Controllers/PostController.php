<?php

namespace App\Http\Controllers;

use App\Post;

class PostController extends Controller
{
    public function all()
    {
        return Post::all();
    }
}