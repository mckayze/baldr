<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function all()
    {
        return Post::all();
    }

    public function create()
    {
        // Define validator rules
        $rules = [
            'url_slug' => 'unique:posts',
        ];

        $scheduled_for = null;

        // Check if it needs to be a scheduled post or not
        if (Request::input('status') == 'scheduled')
        {
            // Add scheduled checks to the validator
            $rules['scheduled_date'] = 'required';
            $rules['scheduled_time'] = 'required';
            // Create date object and check if its in the past
            $scheduled_for = Carbon::createFromFormat('d/m/Y H:i', Request::input('scheduled_date') .' '. Request::input('scheduled_time'));
        }

        // Validate the data
        $validator = Validator::make(Request::all(), $rules);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        $post = new Post();
        $post->user_id   = Auth::id();
        $post->title     = Request::input('title');
        $post->subtitle  = Request::input('subtitle');
        $post->content   = Request::input('content');
        $post->url_slug  = Request::input('url_slug');
        $post->status    = Request::input('status');
        $post->category  = Request::input('category');
        $post->seo_title = Request::input('seo_title');
        $post->scheduled_for = $scheduled_for;
        $post->featured_image = Request::input('featured_image');
        $post->meta_keywords  = Request::input('meta_keywords');
        $post->meta_description  = Request::input('meta_description');

        try {
            $post->save();
        } catch(\Exception $e)
        {
            return [
                'status'     => 500,
                'statusText' => $e->getMessage(),
            ];
        }

        return [
            'status'     => 200,
            'statusText' => 'created post'
        ];
    }
}