<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function get()
    {
        $post = Post::find(Request::input('id'));

        if($post->status === 'scheduled')
        {
            $post->scheduled_date = $post->scheduled_for->format('d/m/Y');
            $post->scheduled_time = $post->scheduled_for->format('H:i');
        }

        unset($post->scheduled_for);

        return $post;
    }

    public function all()
    {
        return Post::with(['user', 'category'])->get();
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
        $post->seo_title = Request::input('seo_title');
        $post->category_id    = Request::input('category');
        $post->scheduled_for  = $scheduled_for;
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

    public function edit()
    {
//        return Request::all();

        // Define validator rules
        $rules = [
            'url_slug' => [
                Rule::unique('posts')->ignore(Request::input('id'))
            ],
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

        $data = Request::except(['id', 'scheduled_date', 'scheduled_time', 'updated_at', 'created_at']);
        $data['scheduled_for'] = $scheduled_for;

        // Update
        Post::find(Request::input('id'))->update(
            $data
        );

        return [
            'status' => 200,
            'statusText' => 'Post updated'
        ];
    }
}