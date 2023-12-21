<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'website_id' => 'required',
                'email' => 'required|email|unique:subscribers'
            ]
        );
        if ($validator->fails()) {
            $status = false;
            $errors = $validator->errors();
            return response()->json(compact('status', 'errors'));
        }
        $post = Post::create([
            'title' => $request->title,
            'website_id' => $request->website_id,
            'slug' => $request->slug,
            'content' => $request->description,
        ]);
        if ($post) {
            $status = true;
            $message = 'Post saved';
            return response()->json(compact('status', 'message'));
        } else {
            $status = false;
            $error = 'Something went wrong';
            return response()->json(compact('status', 'error'));
        }
    }
}
