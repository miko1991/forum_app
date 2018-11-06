<?php

namespace App\Http\Controllers;

use App\Post;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function create(Request $request)
    {
        $post = new Post();
        $post->user_id = Auth::id();
        $post->body = $request->body;
        $post->thread_id = $request->thread_id;
        $post->save();

        $post['user'] = Auth::user();


        $thread = Thread::find($post->thread_id);
        $thread->replies++;
        $thread->save();

        $post['thread'] = $thread;

        $thread['latestPost'] = Post::with('user')->where('id', $post->id)->first();



        return response()->json($thread, 200);
    }
}
