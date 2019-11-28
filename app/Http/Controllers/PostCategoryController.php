<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCategory;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostCategoryController extends Controller
{

    public function get()
    {
        return PostCategory::find(Request::input('id'));
    }

    public function all()
    {
        return PostCategory::with('posts')->get();
    }

    public function create()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'name' => 'required|unique:post_categories',
        ]);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        // Try create the post
        try {
            PostCategory::create(Request::all());
        } catch(\Exception $e) {
            return [
                'status' => 500,
                'statusText' => $e->getMessage()
            ];
        }

        return [
            'status' => 200,
            'statusText' => 'Created post category'
        ];
    }

    public function edit()
    {
        // Validate the data
        $validator = Validator::make(Request::all(), [
            'name' => [
                'required',
                Rule::unique('post_categories')->ignore(Request::input('id'))
            ]
        ]);

        // If error return error
        if ($validator->fails()) {
            return [
                'status'     => 500,
                'statusText' => 'An error occurred',
                'errors'     => $validator->errors()->messages()
            ];
        }

        PostCategory::find(Request::input('id'))->update([
            'name' => Request::input('name'),
            'description' => Request::input('description'),
        ]);

        return [
            'status'     => 200,
            'statusText' => 'Post Category Updated'
        ];
    }

    public function delete()
    {
        PostCategory::where('id', Request::input('id'))->delete();

        return [
            'status' => 200,
            'statusText' => 'Post Category Deleted'
        ];
    }
}