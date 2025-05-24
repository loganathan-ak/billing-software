<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BusinesstoBusiness;
use App\Models\Customers;
use App\Models\Items;

class BusinesstoBusinessController extends Controller
{
    //
    public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_date'    => 'required|date',
        'invoice_number'  => 'required|string|unique:businessto_businesses,invoice_number',
        'customer_id'   => 'required',
        'payment_status'  => 'required',
        'payment_method'  => 'required',
        'paid_amount'     => 'nullable|numeric',
        'balance'         => 'nullable|numeric',
        'description'     => 'nullable|string',
        'subtotal'        => 'nullable|numeric',
        'total_tax'       => 'nullable|numeric',
        'grand_total'     => 'nullable|numeric',
        'product'         => 'required|array',
        'barcode'         => 'required|array',
        'quantity'        => 'required|array',
        'price'           => 'required|array',
        'tax'             => 'required|array',
        'total'           => 'required|array',
        'cgst'           => 'array',
        'sgst'           => 'array',
        'igst'           => 'array',
        'tax_type'       => 'array',
        'discount_percent'  => 'nullable|numeric',
        'discount_amount'   => 'nullable|numeric',
    ]);
    
    // 🧾 Process items
    $items = [];
    foreach ($validated['product'] as $index => $productId) {

                  // Update stock for the current product
    $upitem = Items::findOrFail($productId);
    $upitem->update([
        'current_stock' => $upitem->current_stock - $validated['quantity'][$index]
    ]);

        $items[] = [
            'product_id' => $productId,
            'barcode'   => $validated['barcode'][$index],
            'quantity'   => $validated['quantity'][$index],
            'price'      => $validated['price'][$index],
            'tax'        => $validated['tax'][$index],
            'total'      => $validated['total'][$index],
            'cgst'      => $validated['cgst'][$index],
            'sgst'      => $validated['sgst'][$index],
            'igst'      => $validated['igst'][$index],
            'tax_type'      => $validated['tax_type'][$index],
        ];
    }

    $current_userid = Auth::user()->id;

    // 🧾 Create invoice
    $invocieid = BusinesstoBusiness::create([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'customer_id'    => $validated['customer_id'],
        'payment_status' => $validated['payment_status'],
        'payment_method' => $validated['payment_method'],
        'paid_amount'    => $validated['paid_amount'] ?? 0,
        'balance'        => $validated['balance'] ?? 0,
        'description'    => $validated['description'] ?? '',
        'subtotal'       => $validated['subtotal'] ?? 0,
        'total_tax'      => $validated['total_tax'] ?? 0,
        'grand_total'    => $validated['grand_total'] ?? 0,
        'item_details'   => json_encode($items),
        'discount_percent' =>  $validated['discount_percent'] ?? 0,
        'discount_amount' =>  $validated['discount_amount'] ?? 0,
        'created_by'    => $current_userid,
    ]);

    //return redirect('/b2b-invoice')->with('added', 'Invoice created successfully!');

    return redirect("/view-business-invoice/{$invocieid->id}");
}



public function updateBusinessInvoice(Request $request)
{
    $id = $request->invoice_id;

    $validated = $request->validate([
        'invoice_date'    => 'required|date',
        'invoice_number' => 'required|string|unique:businessto_businesses,invoice_number,' . $id . ',id',
        'customer_id'     => 'required',
        'payment_status'  => 'required',
        'payment_method'  => 'required',
        'paid_amount'     => 'nullable|numeric',
        'balance'         => 'nullable|numeric',
        'description'     => 'nullable|string',
        'subtotal'        => 'nullable|numeric',
        'total_tax'       => 'nullable|numeric',
        'grand_total'     => 'nullable|numeric',
        'product'         => 'required|array',
        'barcode'         => 'required|array',
        'quantity'        => 'required|array',
        'price'           => 'required|array',
        'tax'             => 'required|array',
        'total'           => 'required|array',
        'cgst'           => 'array',
        'sgst'           => 'array',
        'igst'           => 'array',
        'tax_type'       => 'array',
        'discount_percent'  => 'nullable|numeric',
        'discount_amount'   => 'nullable|numeric',
    ]);

    $invoice = BusinesstoBusiness::findOrFail($id);

    $oldPurchase = BusinesstoBusiness::find($request->invoice_id);
    $oldItems = json_decode($oldPurchase->item_details, true);
    
    foreach ($oldItems as $oldItem) {
        $item = Items::find($oldItem['product_id']);
        if ($item) {
            $item->current_stock += $oldItem['quantity'];
            $item->save();
        }
    }

    $items = [];
    foreach ($validated['product'] as $index => $productId) {

                 // Update stock for the current product
    $upitem = Items::findOrFail($productId);
    $upitem->update([
        'current_stock' => $upitem->current_stock - $validated['quantity'][$index]
    ]);

        $items[] = [
            'product_id' => $productId,
            'barcode'   => $validated['barcode'][$index],
            'quantity'   => $validated['quantity'][$index],
            'price'      => $validated['price'][$index],
            'tax'        => $validated['tax'][$index],
            'total'      => $validated['total'][$index],
            'cgst'      => $validated['cgst'][$index],
            'sgst'      => $validated['sgst'][$index],
            'igst'      => $validated['igst'][$index],
            'tax_type'  => $validated['tax_type'][$index],
        ];
    }

    $invoice->update([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'customer_id'    => $validated['customer_id'],
        'payment_status' => $validated['payment_status'],
        'payment_method' => $validated['payment_method'],
        'paid_amount'    => $validated['paid_amount'] ?? 0,
        'balance'        => $validated['balance'] ?? 0,
        'description'    => $validated['description'] ?? '',
        'subtotal'       => $validated['subtotal'] ?? 0,
        'total_tax'      => $validated['total_tax'] ?? 0,
        'grand_total'    => $validated['grand_total'] ?? 0,
        'item_details'   => json_encode($items),
        'discount_percent'  => $validated['discount_percent'] ?? 0,
        'discount_amount'   => $validated['discount_amount'] ?? 0,
    ]);

    //return redirect('/b2b-invoice')->with('updated', 'Invoice updated successfully!');
    return redirect("/view-business-invoice/{$invoice->id}");
}


public function destroyBusinessInvoice(Request $request)
{    
    $id = $request->invoice_id;
    $invoice = BusinesstoBusiness::findOrFail($id);

     // Decode item details
    $items = json_decode($invoice->item_details, true);

    // Rollback stock for each item
    foreach ($items as $item) {
        $product = Items::find($item['product_id']);
        if ($product) {
            $product->current_stock += $item['quantity'];
            $product->save();
        }
    }



    $invoice->delete();

    return redirect('/b2b-invoice')->with('deleted', 'Invoice deleted successfully!');
}


public function getCustomerOnselect($id)
{
    // Find customer by ID or fail if not found
    $customer = Customers::findOrFail($id);
    $admigst = Auth::user()->gst_number;
    // Return the GST number and contact number as a JSON response
    return response()->json([
        'gst_number' => $customer->gst_number,
        'admin_gst' => $admigst,
    ]);
}


public function searchQuery(Request $request){
    $query = $request->input('query');
    $customers = Customers::all();
   
       $invoice = BusinesstoBusiness::where('invoice_number', 'like', "%{$query}%")
                   ->limit(20)
                   ->get();
   
       return response()->json(['invoice' => $invoice, 'customers' => $customers]);
}


}
