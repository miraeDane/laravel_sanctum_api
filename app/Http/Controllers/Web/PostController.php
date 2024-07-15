<?php

namespace App\Http\Controllers\Web;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class PostController
{
    public function index()
    {
        $posts = Post::with('user')->withCount('comments')->latest()->get();
        return view('homepage', compact('posts'));
    }

    public function allposts()
    {
        $posts = Post::all();
        return view('posts.allposts', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $user = new User();
        Auth::user()->posts()->create($validated);

        return redirect()->route('home')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load('comments.user');
        return view('posts.show', compact('post'));
    }

    public function edit(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        Gate::Authorize('update', $post);
        $post->update($request->all());
         return view('posts.edit', compact('post'));

        // return response()->json([
        //     'message' => 'Post updated successfully',
        //     'post' => $post
        // ]);
    }

    public function update(Request $request, $id)
    {
        // if (!Gate::allows('update-post', $post)) {
        //     abort(403);
        // }

        // $validated = $request->validate([
        //     'title' => 'required|max:255',
        //     'body' => 'required',
        // ]);

        // $post->update($validated);
        $post = Post::findOrFail($id);

        // Check if the user is authorized to update the post
        Gate::Authorize('update', $post);

        // Perform the update
        $post->update($request->all());


        return redirect()->route('home')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('delete-post', $post)) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}
