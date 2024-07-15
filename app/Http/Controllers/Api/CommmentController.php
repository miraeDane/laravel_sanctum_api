<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {
        if (Gate::denies('update-comment', $comment)) {
            \Log::info('Update denied', [
                'user_id' => auth()->id(),
                'comment_user_id' => $comment->user_id
            ]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string',
        ]);

        $updated = $comment->update($request->only('body'));

        if (!$updated) {
            \Log::error('Comment update failed', [
                'comment_id' => $comment->id,
                'new_body' => $request->body
            ]);
            return response()->json(['message' => 'Update failed'], 500);
        }

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {
        if (Gate::denies('delete-comment', $comment)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
