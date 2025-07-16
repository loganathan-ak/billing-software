<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;

use App\Models\Invoices;
use App\Models\BusinesstoBusiness;
use Excel;
use Alert;
use App\Imports\CustomersImport;

class CustomersController extends Controller
{
    public function store(Request $request){
    // Validate form input
    $validated = $request->validate([
        'customer_name'   => 'required|string|max:255',
        'address'         => 'required|string|max:255',
        'contact_number'  => 'required|string|max:20',
        'email'           => 'required|email|max:255|unique:customers,email',
        'gst_number'      => 'nullable|string|max:255',
        'description'     => 'nullable|string|max:500',
    ]);

    // Determine if 'is_gst' checkbox is checked
    $isGst = $request->has('is_gst');

    $data = [
        "customer_name" => $validated["customer_name"],
        "contact_number" => $validated["contact_number"],
        "address" => $validated["address"],
        "email" => $validated["email"],
        "is_gst" => $isGst,
        "gst_number" => $request->input('gst_number'),
        "description" => $request->input('description'),
    ];

    // Create new customer
    Customers::create($data);

    return redirect('/customers')->with('added', 'Customer created successfully.');
  }


  public function deleteCustomer(Request $request)
  {
      $customerid = $request->customer_id;
  
      // Check if the customer is linked to any invoices, sales, or B2B records
      $invoiceCount = Invoices::where('customer_id', $customerid)->count();
      $b2bCount = BusinesstoBusiness::where('customer_id', $customerid)->count(); // B2B check
  
      // If there are any related invoices, sales, or B2B records, prevent deletion
      if ($invoiceCount > 0 || $b2bCount > 0) {
          Alert::error('Cannot Delete', "This customer has $invoiceCount sales invoice(s),  and $b2bCount B2B record(s). Delete them first.");
          return redirect()->back();
      }
  
      // Proceed with deletion
      $deleteCustomer = Customers::findOrFail($customerid)->delete();
      
      if ($deleteCustomer) {
          return redirect('/customers')->with('deleted', 'Customer deleted successfully');
      }
  }
  

   public function updateCustomer(Request $request) {

    $id = $request->input('customer_id');

    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:customers,email,' . $id,
        'description' => 'nullable|string',
    ]);

    $isGst = $request->has('is_gst');

    $data = [
        'customer_name' => $validated['customer_name'],
        'contact_number' => $validated['contact_number'],
        'address' => $validated['address'],
        'email' => $validated['email'],
        'is_gst' => $isGst,
        'gst_number' => $request->input('gst_number'),
        'description' => $request->input('description'),
    ];

    $customer = Customers::findOrFail($id);
    $customer->update($data);

    return redirect('/customers')->with('updated', 'Customer updated successfully');
 }


 public function importCustomers(Request $request){
    if ($request->hasFile('customer_import')) {
        Excel::import(new CustomersImport, $request->file('customer_import'));

        return redirect('/customers')->with('success', 'Customers imported successfully!');
    } 

  return redirect('/customers')->with('error', 'No file uploaded or file is invalid.');
  }

  public function storePopupCustomer(Request $request)
{
    $validated = $request->validate([
        'customer_name'   => 'required|string|max:255',
        'contact_number'  => 'required|string|max:20',
        'address'         => 'required|string|max:255',
        'email'           => 'required|email|max:255|unique:customers,email',
        'gst_number'      => 'nullable|string|max:255',
        'description'     => 'nullable|string|max:500',
    ]);

    $isGst = $request->has('is_gst');

    $customer = Customers::create([
        'customer_name' => $validated["customer_name"],
        'contact_number' => $validated["contact_number"],
        'address' => $validated["address"],
        'email' => $validated["email"],
        'is_gst' => $isGst,
        'gst_number' => $validated["gst_number"] ?? null,
        'description' => $validated["description"] ?? null,
    ]);

    return response()->json($customer);
}


public function autocomplete(Request $request)
{
    $term = $request->get('term');

$customers = Customers::where('contact_number', 'LIKE', '%' . $term . '%')
    ->with(['chits' => function ($query) {
        $query->where('chit_type', 'new')
              ->where('chit_status', 'completed')
              ->select('id', 'customer_id', 'chit_number', 'wallet_balance'); // customer_id is required here
    }])
    ->get();

    // Map the response
    return response()->json($customers->map(function ($customer) {
        return [
            'id'       => $customer->id,
            'name'     => $customer->customer_name,
            'phone'    => $customer->contact_number,
            'chits'    => $customer->chits->map(function ($chit) {
                return [
                    'id'          => $chit->id,
                    'chit_number' => $chit->chit_number,
                    'wallet_balance' => $chit->wallet_balance,
                ];
            }),
        ];
    }));
}



public function searchQuery(Request $request)
{
    $query = $request->input('query');

    $customers = Customers::where('customer_name', 'like', "%{$query}%")
                ->orWhere('contact_number', 'like', "%{$query}%")
                ->limit(20)
                ->get();

    return response()->json(['customers' => $customers]);
}


}
