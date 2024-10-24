<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $latestBlogs = Blog::latest()->take(6)->get();
        return view('/user/top', compact('latestBlogs'));
    }
}
