<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments')->get();
        return response()->json($posts);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load('user', 'comments');
    }

    public function update(Request $request, Post $post)
    {
        if (Gate::denies('update-post', $post)) {
            \Log::info('Update denied', [
                'user_id' => auth()->id(),
                'post_user_id' => $post->user_id
            ]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $updated = $post->update($request->only('title', 'body'));

        if (!$updated) {
            \Log::error('Post update failed', [
                'post_id' => $post->id,
                'new_title' => $request->title,
                'new_body' => $request->body
            ]);
            return response()->json(['message' => 'Update failed'], 500);
        }

        return response()->json($post);
    }

    public function comments(Post $post)
    {
        $comments = $post->comments()->get();
        return response()->json($comments);
    }

    public function destroy(Post $post)
    {
        if (Gate::denies('delete-comment', $post)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
