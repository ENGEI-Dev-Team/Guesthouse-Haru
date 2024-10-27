<?php

namespace App\Http\Controllers;

use App\DDD\Contact\infrastructure\EloquentContactRepository;
use Illuminate\Http\Request;
use App\DDD\Contact\UseCase\CreateContactUseCase;
use App\DDD\Contact\UseCase\deleteContactUseCase;
use App\DDD\Contact\UseCase\FilterContactUseCase;
use App\DDD\Contact\UseCase\UpdateContactStatusUseCase;


class ContactController extends Controller
{    
    protected $contactRepository;
    protected $createContactUseCase;
    protected $filterContactUseCase;
    protected $updateContactStatusUseCase;
    protected $deleteContactUseCase;

    public function __construct(
        EloquentContactRepository $contactRepository,
        CreateContactUseCase $createContactUseCase,
        FilterContactUseCase $filterContactUseCase,
        UpdateContactStatusUseCase $updateContactStatusUseCase,
        DeleteContactUseCase $deleteContactUseCase
    ) {
        $this->contactRepository = $contactRepository;
        $this->createContactUseCase = $createContactUseCase;
        $this->filterContactUseCase = $filterContactUseCase;
        $this->updateContactStatusUseCase = $updateContactStatusUseCase;
        $this->deleteContactUseCase = $deleteContactUseCase;
    }

    // ユーザーのお問い合わせフォーム
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|max:5000',
        ], [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'message.required' => 'Please enter message',
        ]);

        try {
            $this->createContactUseCase->execute($validatedData);
            return redirect()->back()->with('contact_success', 'Your enquiry was successfully submitted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('contact_error', 'An error occurred while submitting your enquiry: ' . $e->getMessage());
        }
    }

    // 管理者のお問い合わせ管理ページ
    public function index(Request $request)
    {
        $filters = $request->only(['name', 'email', 'message', 'status', 'date_from', 'date_to']);

        $contact = $this->filterContactUseCase->execute($filters);

        return view('admin.contact', compact('contact'));
    }

    // ステータスの更新管理
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unresolved,in_progress,resolved'
        ]);

        try {
            $this->updateContactStatusUseCase->execute($id, $request->input('status'));
            return redirect()->route('admin.contactDetail', ['id' => $id])->with('success', 'ステータスが更新されました');
        } catch (\Exception $e) {
            return redirect()->route('admin.contactDetail', ['id' => $id])->with('error', 'ステータスの更新中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    // 管理者のdashboardでstatusが「未対応」と「対応中」のものだけ表示
    public function dashboard(Request $request)
    {
        $statuses = ['unresolved', 'in_progress'];

        if ($request->filled('status')) {
            $statuses = [$request->status];
        }

        $contact = $this->contactRepository->filterByStatus($statuses);

        return $contact;
    }

    // お問い合わせ詳細ページ
    public function showDetail($id)
    {
        $contact = $this->contactRepository->findById($id);
        return view('admin.contact_detail', compact('contact'));
    }

    // お問い合わせの削除
    public function delete($id)
    {
        try {
            $this->deleteContactUseCase->execute($id);
            return redirect()->route('admin.contact')->with('delete-success', 'お問い合わせが削除されました');
        } catch (\Exception $e) {
            return redirect()->route('admin.contact')->with('delete-error','削除に失敗しました');
        }
    }
}
