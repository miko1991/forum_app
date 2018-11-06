<?php

namespace App\Http\Controllers;

use App\Post;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    public $table = 'threads';

    public function getThreadById($id)
    {
        $thread = Thread::with('user', 'forum')->where('id', $id)->first();

        $posts = Post::with('user')->where('thread_id', $thread->id)->paginate(10);

        $thread['posts'] = $posts;

        return response()->json($thread, 200);
    }


    public function search($searchQuery)
    {
        $threads = Thread::with('user')
            ->where('title', 'like', '%'.strtolower($searchQuery).'%')
            ->select('threads.*' )
            ->latest()
            ->paginate(10);


        foreach ($threads as $thread)
        {
            $post = Post::with('user')->where('thread_id', $thread->id)->latest()->first();
            $thread['latestPost'] = $post;
        }


        return response()->json($threads, 200);
    }

    public function create(Request $request)
    {
        $thread = new Thread();
        $thread->forum_id = $request->forum_id;
        $thread->title = $request->title;
        $thread->user_id = Auth::id();
        $thread->save();



        $post = new Post();
        $post->thread_id = $thread->id;
        $post->user_id = Auth::id();
        $post->body = $request->body;
        $post->save();

        $thread['latestPost'] = Post::with('user')->where('id', $post->id)->first();

        return response()->json($thread, 200);
    }
}
