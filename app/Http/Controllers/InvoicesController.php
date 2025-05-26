<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\Customers;
use App\Models\Items;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_date'    => 'required|date',
        'invoice_number'  => 'required|string|unique:invoices,invoice_number',
        'customer_name'   => 'required|string|max:255',
        'customer_phone'  => 'required|string|max:20',
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
        'cgst'            => 'required|array',
        'sgst'            => 'required|array',
        'discount_percent'  => 'nullable|numeric',
        'discount_amount'   => 'nullable|numeric',
    ]);

        // Check if customer already exists by phone number
        $customer = Customers::where('contact_number', $validated['customer_phone'])->first();

        if (!$customer) {
            // Create new customer if not found
            $customer = Customers::create([
                'customer_name'   => $validated['customer_name'],
                'contact_number'  => $validated['customer_phone'],
                'address'         => '',
                'email'           => null, // Set email as null since it's now nullable
                'is_gst'          => 0,
                'gst_number'      => '',
                'description'     => '',
            ]);
        }
    

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
        ];
    }

    $current_userid = Auth::user()->id;
    // 🧾 Create invoice
    $invoice = Invoices::create([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'customer_id'    => $customer->id,
        'customer_name'  => $customer->customer_name,
        'customer_phone' => $customer->contact_number,
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

    //return redirect('/sales-invoice')->with('added', 'Invoice created successfully!');

    return redirect("/view-invoice/{$invoice->id}");
}


    

public function update(Request $request)
{
    $id = $request->invoice_id;

    $validated = $request->validate([
        'invoice_date'    => 'required|date',
        'invoice_number'  => 'required|string|unique:invoices,invoice_number,' . $id,
        'customer_name'   => 'required',
        'customer_phone'  => 'required',
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
        'cgst'           => 'required|array',
        'sgst'           => 'required|array',
        'discount_percent'  => 'nullable|numeric',
        'discount_amount'   => 'nullable|numeric',
    ]);

    $customer = Customers::find($request->customer_id);

    if ($customer) {
        $customer->update([
            'customer_name'  => $validated['customer_name'],
            'contact_number' => $validated['customer_phone'],
        ]);
    } else {
        $customer = Customers::create([
            'customer_name'   => $validated['customer_name'],
            'contact_number'  => $validated['customer_phone'],
            'address'         => '',
            'email'           => null,
            'is_gst'          => 0,
            'gst_number'      => '',
            'description'     => '',
        ]);
    }
    
    $oldPurchase = Invoices::find($request->invoice_id);
    $oldItems = json_decode($oldPurchase->item_details, true);
    
    foreach ($oldItems as $oldItem) {
        $item = Items::find($oldItem['product_id']);
        if ($item) {
            $item->current_stock += $oldItem['quantity'];
            $item->save();
        }
    }

    // Build item array
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
        ];
    }

    // Update invoice
    $invoice = Invoices::findOrFail($id);
    $invoice->update([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'customer_id'    => $customer->id,
        'customer_name'  => $customer->customer_name,
        'customer_phone' => $customer->contact_number,
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

    //return redirect('/sales-invoice')->with('updated', 'Invoice updated successfully');

    return redirect("/view-invoice/{$id}");
}


      public function deleteInvoice(Request $request){
        $id = $request->invoice_id; // Getting the invoice ID from the request
        $invoice = Invoices::findOrFail($id); // Find the invoice by ID or fail if not found


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
    

        // Delete the invoice
        $invoice->delete();

        // Redirect back to the invoices list with a success message
        return redirect('/sales-invoice')->with('deleted', 'Invoice deleted successfully');
      }



      public function searchQuery(Request $request){

        $query = $request->input('query');
        $customers = Customers::all();
       
        $invoices = Invoices::where('invoice_number', 'like', "%{$query}%")
                       ->limit(20)
                       ->get();
        
           return response()->json(['invoices' => $invoices, 'customers' => $customers]);
    
      }

    
}
