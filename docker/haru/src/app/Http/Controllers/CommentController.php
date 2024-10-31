<?php

namespace App\Http\Controllers;

use App\DDD\Comment\UseCase\CreateCommentUseCase;
use App\DDD\Comment\UseCase\DeleteCommentUseCase;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $createCommentUseCase;
    private $deleteCommentUseCase;

    public function __construct(createCommentUseCase $createCommentUseCase, DeleteCommentUseCase $deleteCommentUseCase)
    {
        $this->createCommentUseCase = $createCommentUseCase;
        $this->deleteCommentUseCase = $deleteCommentUseCase;
    }

    public function store(Request $request, $blogId)
    {
        $validatedData = $request->validate([
            'author' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ], [
            'author.required' => 'Please enter your name',
            'content.required' => 'Please enter your content',
        ]);

        try {
            $this->createCommentUseCase->execute($validatedData,  $blogId);
            return redirect()->back()->with('comment_success','Comment added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('comment-error', 'An error occurred while adding the comment');
        }
    }

    public function destroy($id)
    {
        try {
            $this->deleteCommentUseCase->execute($id);
            return redirect()->back()->with('comment_success', 'コメントを削除しました。');
        } catch (\Exception $e) {
            return redirect()->back()->with('コメントの削除に失敗しました');
        }
    }
}
