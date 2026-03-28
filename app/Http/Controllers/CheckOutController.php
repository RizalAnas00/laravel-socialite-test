<?php

namespace App\Http\Controllers;

use App\Models\Shirt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function index()
    {
        $shirts = Shirt::all();
        return view('checkout', compact('shirts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        try {
            /**
             * @var User
             */
            $user = Auth::user();

            $items = collect($request->items)
                ->filter(fn($item) => (int)$item['qty'] > 0)
                ->values();

            if ($items->isEmpty()) {
                return back()->with('error', 'Pilih minimal 1 item');
            }

            $totalAmount = 0;

            foreach ($items as $item) {
                $shirt = Shirt::findOrFail($item['shirt_id']);

                if ($item['qty'] > $shirt->stock) {
                    return back()->with('error', 'Stock tidak cukup untuk ' . $shirt->name);
                }

                $totalAmount += $shirt->price * $item['qty'];
            }

            $user->createOrGetStripeCustomer();
            $paymentMethod = $request->payment_method;

            $charge = $user->charge(
                $totalAmount * 100,
                $paymentMethod ,
                [
                    'payment_method_types' => ['card'],
                ]
            );

            foreach ($items as $item) {
                $shirt = Shirt::findOrFail($item['shirt_id']);
                $shirt->decrement('stock', $item['qty']);

                // $user->tabPrice($shirt->code, $item['qty']);
            }

            // $user->invoice();

            // dd($charge);

            return redirect()->route('checkout.index')
                ->with('success', 'Payment successful!');

        } catch (\Exception $e) {

            dd($e);
            return back()->with('error', $e->getMessage());
        }
    }
}
