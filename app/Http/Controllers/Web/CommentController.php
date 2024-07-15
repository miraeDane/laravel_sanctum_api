<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;

class CommentController
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->post_id = $validated['post_id'];
        $comment->user_id = auth()->id();
        $comment->body = $validated['body'];
        $comment->save();

        return redirect()->route('posts.show', $validated['post_id'])->with('success', 'Comment added!');
    }

    public function destroy(Comment $comment)
    {
        if (!Gate::allows('delete-comment', $comment)) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
