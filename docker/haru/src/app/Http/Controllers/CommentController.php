<?php

namespace App\Http\Controllers;

use App\DDD\Comment\UseCase\CreateCommentUseCase;
use App\DDD\Comment\UseCase\DeleteCommentUseCase;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    private $createCommentUseCase;
    private $deleteCommentUseCase;

    public function __construct(createCommentUseCase $createCommentUseCase, DeleteCommentUseCase $deleteCommentUseCase)
    {
        $this->createCommentUseCase = $createCommentUseCase;
        $this->deleteCommentUseCase = $deleteCommentUseCase;
    }

    public function store(StoreCommentRequest $request, $blogId)
    {
        try {
            $this->createCommentUseCase->execute($request->validated(),  $blogId);
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
