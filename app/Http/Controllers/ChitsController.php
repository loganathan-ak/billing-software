<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chits;
use App\Models\Customers;


class ChitsController extends Controller
{
    
    public function store(Request $request)
    {
        $chitType = $request->chit_type;

        if ($chitType === 'new') {
            $validated = $request->validate([
                'chit_type' => 'required|in:new',
                'chit_number' => 'required|string|unique:chits,chit_number',
                'customer_id' => 'required|exists:customers,id',
                'start_date' => 'required|date',
                'monthly_amount' => 'required|numeric|min:0',
                'total_months' => 'required|integer|min:1',
                'description' => 'nullable|string|max:255',
                'discount-percent' => 'nullable|numeric|min:0|max:100',
            ]);

            Chits::create([
                'chit_type' => $validated['chit_type'],
                'chit_number' => $validated['chit_number'],
                'customer_id' => $validated['customer_id'],
                'start_date' => $validated['start_date'],
                'monthly_amount' => $validated['monthly_amount'],
                'total_months' => $validated['total_months'],
                'description' => $validated['description'],
                'discount-percent' => $validated['discount-percent'],
                'pay_chit_number' => $validated['customer_id'],
                'pay_customer_id' => $validated['customer_id'],
                'payment_date' => $validated['start_date'],
                'amount_paid' => $validated['monthly_amount'],
                'month_number' => '1',
                'due_status' => 'paid',
            ]);
            return redirect()->route('chits')->with('added', 'New chit started!');
        } elseif ($chitType === 'payment') {
            $validated = $request->validate([
                'chit_type' => 'required|in:payment',
                'pay_chit_number' => 'required|string|exists:chits,chit_number',
                'pay_customer_id' => 'required|exists:customers,id',
                'payment_date' => 'required|date',
                'amount_paid' => 'required|numeric|min:0',
                'month_number' => 'required|integer|min:1',
                'due_status' => 'required|in:paid,pending',
            ]);

            $chit = Chits::where('chit_number', $validated['pay_chit_number'])->first();

            if ($chit) {
                Chits::create([
                    'chit_type' => 'payment',
                    'customer_id' => $validated['pay_customer_id'],
                    'chit_number' => $validated['pay_chit_number'],
                    'payment_date' => $validated['payment_date'],
                    'amount_paid' => $validated['amount_paid'],
                    'month_number' => $validated['month_number'],
                    'due_status' => $validated['due_status'],
                ]);
                return redirect()->route('chits')->with('added', 'Payment recorded!');
            } else {
                return back()->withErrors(['pay_chit_number' => 'Chit not found.'])->withInput();
            }
        }

        return back()->with('error', 'Invalid action.')->withInput();
    }


    public function getChitDetails($chitNumber){
    $chit = Chits::where('chit_number', $chitNumber)->first();

    if (!$chit) {
        return response()->json(['success' => false, 'message' => 'Chit not found']);
    }

    $customer = Customers::find($chit->customer_id);

    // If you expect multiple chit entries and want the one with the latest month_number
    $latestChit = Chits::where('chit_number', $chitNumber)->orderByDesc('month_number')->first();
    $totalmonths = $latestChit ? $latestChit->month_number : 0;

    return response()->json([
        'success' => true,
        'chit' => $chit,
        'customer' => $customer,
        'totalmonths' => $totalmonths,
        'next_month_number' => $totalmonths + 1,
    ]);
}

    


}
