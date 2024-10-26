<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
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

        $contact = Contact::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'message' => $validatedData['message'],'status' => 'unresolved',
        ]);

        Mail::send('emails.contact_notification', ['contact' => $contact], function ($message) {
            $message->to('tukaburu13@gmail.com')
                ->subject('新しいお問い合わせがありました');
        });

        return redirect()->back()->with('contact_success', 'Your enquiry was successfully submitted.');
    }

    // 管理者のお問い合わせ管理ページ
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }


        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        if ($request->filled('message')) {
            $query->where('message', 'like', '%' . $request->message . '%');
        }

        $contact = $query->paginate(10);

        return view('admin.contact', compact('contact'));
    }

    // ステータスの更新管理
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unresolved,in_progress,resolved'
        ]);

        $contact = Contact::where('id', $id)->findOrFail($id);
        $contact->status = $request->status;
        $contact->save();

        return redirect()->route('admin.contactDetail', ['id' => $id])->with('success', 'ステータスが更新されました');
    }

    // 管理者のdashboardでstatusが「未対応」と「対応中」のものだけ表示
    public function dashboard(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('(status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['unresolved', 'in_progress']);
        }

        return $query->get();
    }

    // お問い合わせ詳細ページ
    public function showDetail($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contact_detail', compact('contact'));
    }
}
