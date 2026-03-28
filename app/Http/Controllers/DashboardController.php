<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * @var User
         */
        $user = Auth::user();
        $posts = Post::with('user')->latest()->get();

        $invoices = $user->invoicesIncludingPending();

        return view('dashboard', compact('user', 'posts', 'invoices'));
    }
}
