<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $blogId)
    {
        $validatedData = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ], [
            'author.required' => 'Please enter your name',
            'content.required' => 'Please enter your content',
        ]);

        Comment::create([
            'blog_id' => $blogId,
            'author' => $validatedData['author'],
            'content' => $validatedData['content'],
        ]);

        return redirect()->back()->with('comment_success', 'Comment added successfully.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('comment_success', 'コメントを削除しました。');
    }
}
