<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Post;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    public function getForumById($id)
    {
        $forum = Forum::find($id);
        if (!isset($forum->id))
        {
            return response()->json(['error' => 401], 200);
        }

        $forum->views ++;
        $forum->save();


        $threads = Thread::where('forum_id', $forum->id)->latest()->paginate(10);
        $forum['threads'] = $threads;


        for ($i = 0; $i < count($forum['threads']); $i++)
        {
            $thread = $forum['threads'][$i];
            $thread['latestPost'] = Post::with('user', 'thread.user')
                                        ->where('thread_id', '=', $thread['id'])
                                        ->latest()
                                        ->first();
            $thread['postCount'] = Post::where('thread_id', '=', $thread['id'])->count();

            $user = User::find($thread->user_id);
            $thread['user'] = $user;
        }


        return response()->json($forum, 200);
    }

}
