<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchases;
use App\Models\Vendor;
use App\Models\Items;
use Illuminate\Support\Facades\Auth;

class PurchasesController extends Controller{

    public function store(Request $request)
{
    $validated = $request->validate([
        'invoice_date'     => 'required|date',
        'invoice_number'   => 'required|string',
        'vendor_id'        => 'required|exists:vendors,id',
        'payment_status'   => 'required|in:Paid,Partial,Unpaid',
        'paid_amount'      => 'nullable|numeric',
        'balance'          => 'nullable|numeric',
        'description'      => 'nullable|string',
        'subtotal'         => 'nullable',
        'total_tax'        => 'nullable',
        'grand_total'      => 'nullable',
        'product'          => 'required|array',
        'barcode'         => 'required|array',
        'quantity'         => 'required|array',
        'price'            => 'required|array',
        'tax'              => 'required|array',
        'total'            => 'required|array',
        'cgst'           => 'array',
        'sgst'           => 'array',
        'igst'           => 'array',
        'tax_type'       => 'array',
    ]);

    // Combine item details into one array
    $itemDetails = [];
    foreach ($validated['product'] as $index => $productId) {
        // Update stock for the current product
    $item = Items::findOrFail($productId);
    $item->update([
        'current_stock' => $item->current_stock + $validated['quantity'][$index]
    ]);
        $itemDetails[] = [
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
     
    $current_userid = Auth::user()->id;

    $purchase = Purchases::create([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'vendor_id'      => $validated['vendor_id'],
        'payment_status' => $validated['payment_status'],
        'paid_amount'    => $request->paid_amount,
        'balance'        => $request->balance,
        'description'    => $request->description,
        'item_details'   => json_encode($itemDetails),
        'subtotal'       => $request->subtotal,
        'total_tax'      => $request->total_tax,
        'grand_total'    => $request->grand_total,
        'created_by'    => $current_userid,
    ]);

    

    //return redirect('/purchases')->with('success', 'Purchase created successfully!');

    return redirect("/view-purchase/{$purchase->id}");
    }
    

    public function deletePurchaseOrder(Request $request)
{
    $id = $request->purchaseorder_id;
    $purchase = Purchases::findOrFail($id);

    // Decode item details
    $items = json_decode($purchase->item_details, true);

    // Rollback stock for each item
    foreach ($items as $item) {
        $product = Items::find($item['product_id']);
        if ($product) {
            $product->current_stock = max(0, $product->current_stock - $item['quantity']);
            $product->save();
        }
    }

    // Now delete the purchase
    $purchase->delete();

    return redirect('/purchases')->with('deleted', 'Purchase Order deleted successfully.');
}



    public function updatePurchaseOrder(Request $request)
{
    $purchase = Purchases::findOrFail($request->purchaseorder_id);

    $validated = $request->validate([
        'invoice_date'     => 'required|date',
        'invoice_number'   => 'required|string',
        'vendor_id'        => 'required|exists:vendors,id',
        'payment_status'   => 'required|in:Paid,Partial,Unpaid',
        'paid_amount'      => 'nullable|numeric',
        'balance'          => 'nullable|numeric',
        'description'      => 'nullable|string',
        'subtotal'         => 'nullable|numeric',
        'total_tax'        => 'nullable|numeric',
        'grand_total'      => 'nullable|numeric',

        'product'          => 'required|array',
        'barcode'          => 'required|array',
        'quantity'         => 'required|array',
        'price'            => 'required|array',
        'tax'              => 'required|array',
        'total'            => 'required|array',
        'cgst'           => 'array',
        'sgst'           => 'array',
        'igst'           => 'array',
        'tax_type'       => 'array',
    ]);
     
    $oldPurchase = Purchases::find($request->purchaseorder_id);
     $oldItems = json_decode($oldPurchase->item_details, true);

        foreach ($oldItems as $oldItem) {
            $item = Items::find($oldItem['product_id']);
            if ($item) {
                $item->current_stock -= $oldItem['quantity']; // Rollback old stock
                $item->save();
            }
        }
    $items = [];
    foreach ($validated['product'] as $index => $productId) {

            // Update stock for the current product
    $upitem = Items::findOrFail($productId);
    $upitem->update([
        'current_stock' => $upitem->current_stock + $validated['quantity'][$index]
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


    $purchase->update([
        'invoice_date'   => $validated['invoice_date'],
        'invoice_number' => $validated['invoice_number'],
        'vendor_id'      => $validated['vendor_id'],
        'payment_status' => $validated['payment_status'],
        'paid_amount'    => $validated['paid_amount'] ?? 0,
        'balance'        => $validated['balance'] ?? 0,
        'description'    => $validated['description'],
        'subtotal'       => $validated['subtotal'] ?? 0,
        'total_tax'      => $validated['total_tax'] ?? 0,
        'grand_total'    => $validated['grand_total'] ?? 0,
        'item_details'   => json_encode($items),
    ]);

    //return redirect('/purchases')->with('updated', 'Purchase Order updated successfully.');

    return redirect("/view-purchase/{$purchase->id}");
  }

  public function viewPurchase($id){
    $purchase = Purchases::findOrFail($id);
    $vendor = Vendor::all();
    $products = Items::all();
    return view('purchases.view-purchase', compact('purchase', 'vendor', 'products'));
  }

  public function getVendorOnselect($id){
            // Find customer by ID or fail if not found
    $vendor = Vendor::findOrFail($id);

    // Return the GST number and contact number as a JSON response
    return response()->json([
        'gst_number' => $vendor->gst_number,
        'contact_number' => $vendor->phone,
        'contact_person' => $vendor->contact_person,
    ]);
  }


  public function searchQuery(Request $request){

    $query = $request->input('query');
    $vendors = Vendor::all();
   
    $purchases = Purchases::where('invoice_number', 'like', "%{$query}%")
                   ->limit(20)
                   ->get();
   
       return response()->json(['purchases' => $purchases, 'vendors' => $vendors]);

  }

  
}
