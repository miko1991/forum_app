<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            return response()->json(Auth::user(), 200);
        }
        else
        {
            return response()->json(['error' => 401], 200);
        }
    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (isset($user->id))
        {
            return response()->json(['error' => 'email_taken'], 200);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();


        Auth::login($user);

        return response()->json($user, 200);
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(true, 200);
    }

    public function init()
    {
        $user = Auth::user();

        $threadsCount = Thread::all()->count();

        $activeThreads = Thread::latest('updated_at')->take(10)->get();

        foreach ($activeThreads as $activeThread)
        {
            $activeThread['latestPost'] = Post::with('user')->where('thread_id', $activeThread->id)->latest()->first();
        }

        return response()->json([
            'threadCount' => $threadsCount,
            'activeThreads' => $activeThreads,
            'user' => $user
        ], 200);
    }
}
