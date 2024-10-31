<?php

namespace App\Http\Controllers;

use App\DDD\Contact\infrastructure\EloquentContactRepository;
use Illuminate\Http\Request;
use App\DDD\Contact\UseCase\CreateContactUseCase;
use App\DDD\Contact\UseCase\deleteContactUseCase;
use App\DDD\Contact\UseCase\FilterContactUseCase;
use App\DDD\Contact\UseCase\UpdateContactStatusUseCase;
use App\Http\Requests\StoreContactRequest;

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
    public function store(StoreContactRequest $request)
    {
        try {
            $this->createContactUseCase->execute($request->validated());
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
    public function showDetail(string $id)
    {
        $contact = $this->contactRepository->findById($id);
        return view('admin.contact_detail', compact('contact'));
    }

    // お問い合わせの削除
    public function delete(string $id)
    {
        try {
            $this->deleteContactUseCase->execute($id);
            return redirect()->route('admin.contact')->with('success', 'お問い合わせが削除されました');
        } catch (\Exception $e) {
            return redirect()->route('admin.contact')->with('error','削除に失敗しました');
        }
    }
}
