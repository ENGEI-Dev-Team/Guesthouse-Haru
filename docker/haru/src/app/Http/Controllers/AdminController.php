<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Controllers\AdminCalendarController;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 最新のブログを表示
        $latestBlogs = Blog::latest()->take(6)->get();

        // ContactControllerのカレンダーデータを取得
        $contactController = new ContactController();
        $contact = $contactController->dashboard($request);

       // AdminCalendarControllerのカレンダーデータを取得
        $calendarController = new AdminCalendarController();
        $bookedDates = $calendarController->fetchEventData(); // イベントデータを取得

        return view('admin.dashboard', compact('latestBlogs','contact', 'bookedDates'));
    }
}

