<?php

namespace App\Http\Controllers;

use App\Models\Shirt;
use Illuminate\Http\Request;

class ShirtController extends Controller
{
    public function createDummy(Request $request)
    {
        Shirt::factory()->count($request->input('count', 1))->create();

        return redirect()->back()->with('success', 'Dummy shirts created successfully!');
    }
}
