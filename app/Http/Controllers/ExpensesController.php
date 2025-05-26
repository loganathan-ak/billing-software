<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;

class ExpensesController extends Controller
{
    public function store(Request $request){
    $validated = $request->validate([
        'expense_name'      => 'required|string|max:255',
        'expense_type'      => 'required|string',
        'amount'            => 'required|numeric|min:0',
        'beneficiary_name'  => 'required|string|max:255',
        'description'       => 'nullable|string|max:1000',
    ]);

    Expenses::create($validated);

    return redirect('/expenses')->with('added', 'Expense added successfully.');
   }
   

   public function deleteExpense(Request $request){
    // Find the item by its ID
    $item = Expenses::findOrFail($request->expense_id);
    // Update the item with the validated data
    $item->delete();

    // Redirect back to the item list or detail page with a success message
    return redirect('/expenses')->with('deleted', 'Expense deleted successfully');
   }


   public function updateExpense(Request $request){
    $item = Expenses::findOrFail($request->expense_id);
    $validated = $request->validate([
        'expense_name'      => 'required|string|max:255',
        'expense_type'      => 'required|string',
        'amount'            => 'required|numeric|min:0',
        'beneficiary_name'  => 'required|string|max:255',
        'description'       => 'nullable|string|max:1000',
    ]);

    $item->update($validated);

    return redirect('/expenses')->with('updated', 'Expense added successfully.');
   }


   public function searchQuery(Request $request)
   {
       $query = $request->input('query');
   
       $expenses = Expenses::where('expense_type', 'like', "%{$query}%")
                   ->limit(20)
                   ->get();
   
       return response()->json(['expenses' => $expenses]);
   }
}
