<?php

namespace App\Http\Controllers;

use App\Models\Shirt;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function index()
    {
        $shirts = Shirt::all();
        return view('checkout', compact('shirts'));
    }
}
