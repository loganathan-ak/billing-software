<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Purchases;
use App\Models\Invoices;
use App\Models\BusinesstoBusiness;
use Excel;
use App\Imports\ItemsImport;
use RealRashid\SweetAlert\Facades\Alert;


class ItemsController extends Controller
{
    public function store(Request $request)
    {
        // Validation for the form fields
        $validated = $request->validate([
            'bar_code'   => 'required|unique:items,barcode',
            'hsn_code'   => 'required|string',
            'product_name'   => 'required|unique:items,product_name',
            'unit_id'        => 'required|string|in:Piece,Dozen,Set,Bundle',
            'price_per_unit' => 'required|string',
            'selling_price_per_unit' => 'required|string',
            'tax_type_id'    => 'required|string|in:GST,IGST,Exempt',
            'tax_percentage' => 'required|numeric|min:0',
            'description'    => 'nullable|string|max:500',
        ]);

        // Create a new item using the validated data
        Items::create([
            'barcode'   => $validated['bar_code'],
            'hsn_code'   => $validated['hsn_code'],
            'product_name'   => $validated['product_name'],
            'unit_id'        => $validated['unit_id'],
            'price_per_unit' => $validated['price_per_unit'],
            'selling_price_per_unit' => $validated['selling_price_per_unit'],
            'tax_type_id'    => $validated['tax_type_id'],
            'tax_percentage' => $validated['tax_percentage'],
            'description'    => $validated['description'],
        ]);

        // Redirect or return response
        return redirect('/items')->with('added', 'Item created successfully!');
    }
   



    public function updateItem(Request $request){
        // Find the item by its ID
        $item = Items::findOrFail($request->product_id);

        // Validate the form data
        $request->validate([
            'bar_code'   => 'required|unique:items,bar_code,'.$item->id,
            'product_name' => 'required|string|max:255',
            'hsn_code'   => 'required|unique:items,hsn_code,',
            'unit_id' => 'required|string|in:Piece,Dozen,Set,Bundle',
            'price_per_unit' => 'required|string',
            'selling_price_per_unit' => 'required|string',
            'tax_type_id' => 'required|string|in:GST,IGST,Exempt',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        // Update the item with the validated data
        $item->update([
            'barcode'   => $validated->bar_code,
            'hsn_code'   => $validated->hsn_code,
            'product_name'   => $validated->product_name,
            'unit_id'        => $validated->unit_id,
            'price_per_unit' => $validated->price_per_unit,
            'selling_price_per_unit' => $validated->selling_price_per_unit,
            'tax_type_id'    => $validated->tax_type_id,
            'tax_percentage' => $validated->tax_percentage,
            'description'    => $validated->description,
        ]);

        // Redirect back to the item list or detail page with a success message
        return redirect('/items')->with('updated', 'Item updated successfully');
    }

    public function deleteItem(Request $request)
    {
        // Find the item by its ID
        $item = Items::findOrFail($request->product_id);
    
        // Check if the item has related purchase orders
        $purchaseCount = Purchases::whereJsonContains('item_details', [['product_id' => (string) $item->id]])->count();
    
        // Check normal sales
        $saleCount = Invoices::whereJsonContains('item_details', [['product_id' => (string) $item->id]])->count();
    
        // Check B2B sales
        $b2bSaleCount = BusinesstoBusiness::whereJsonContains('item_details', [['product_id' => (string) $item->id]])->count();
    
        // If the item has related purchases or sales, don't allow deletion
        if ($purchaseCount > 0 || $saleCount > 0 || $b2bSaleCount > 0) {
            Alert::error('Cannot Delete', "This item has $purchaseCount purchase(s), $saleCount sale(s), and $b2bSaleCount B2B sale(s). Delete them first.");
            return redirect()->back();
        }
    
        // Delete the item
        $item->delete();
    
        // Redirect back to the item list or detail page with a success message
        return redirect('/items')->with('deleted', 'Item deleted successfully');
    }
    
    


    public function importItems(Request $request)
    {  
        if ($request->hasFile('items_import')) {
            Excel::import(new ItemsImport, $request->file('items_import'));
    
            return redirect('/items')->with('success', 'Items imported successfully!');
        } 

      return redirect('/items')->with('error', 'No file uploaded or file is invalid.');
        
    }


    public function addItemPopup(Request $request)
    {    

        // Validation for the form fields
        $validated = $request->validate([
            'bar_code'   => 'required|unique:items,barcode',
            'hsn_code'   => 'required|string',
            'product_name'   => 'required|unique:items,product_name',
            'unit_id'        => 'required|string|in:Piece,Dozen,Set,Bundle',
            'price_per_unit' => 'required|string',
            'selling_price_per_unit' => 'required|string',
            'tax_type_id'    => 'required|string|in:GST,IGST,Exempt',
            'tax_percentage' => 'required|numeric|min:0',
            'description'    => 'nullable|string|max:500',
        ]);

        // Create a new item using the validated data
        $item = Items::create([
            'barcode'   => $validated['bar_code'],
            'hsn_code'   => $validated['hsn_code'],
            'product_name'   => $validated['product_name'],
            'unit_id'        => $validated['unit_id'],
            'price_per_unit' => $validated['price_per_unit'],
            'selling_price_per_unit' => $validated['selling_price_per_unit'],
            'tax_type_id'    => $validated['tax_type_id'],
            'tax_percentage' => $validated['tax_percentage'],
            'description'    => $validated['description'],
        ]);


        return response()->json([
            'id' => $item->id,
            'item_name' => $item->product_name,
            'tax' => $item->tax_percentage,
            'price' => $item->price_per_unit,
            'message' => 'Item added successfully'
        ]);
    }
    

    public function getProduct($id){
    $item = Items::findOrFail($id);

    return response()->json([
        'barcode'=>$item->barcode,
        'price' => $item->selling_price_per_unit,
        'buying_price' => $item->price_per_unit,
        'tax' => $item->tax_percentage,
        'current_stock' => $item->current_stock,
    ]);
   }



   public function searchQuery(Request $request)
{
    $query = $request->input('query');

    $items = Items::where('product_name', 'like', "%{$query}%")
                ->orWhere('barcode', 'like', "%{$query}%")
                ->limit(20)
                ->get();

    return response()->json(['items' => $items]);
}


}
