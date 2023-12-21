<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailToSubscriber;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'website_id' => 'required',
                'slug' => 'required|unique:posts',
                'description' => 'required',
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
            $emailData = [
                'website_id' => $post->website_id,
                'title' => $post->title,
                'description' => $post->content,
            ];
            dispatch(new SendEmailToSubscriber($emailData));
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
