<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Purchases;
use App\Models\BusinesstoBusiness;
use Excel;
use App\Imports\VendorsImport;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "vendor_name" => "required|string|max:255",
            "contact_person" => "required|string|max:255",
            "address" => "required|string|max:255",
            "phone" => "required|string|max:20|unique:vendors",
            "gst_number" => "nullable|string|max:255",
            "description" => "nullable|string",
        ]);
    
        $isGst = $request->has('is_gst');
    
        $data = [
            "vendor_name" => $validated["vendor_name"],
            "contact_person" => $validated["contact_person"],
            "address" => $validated["address"],
            "phone" => $validated["phone"],
            "is_gst" => $isGst,
            "gst_number" => $request->input('gst_number'),
            "description" => $request->input('description'),
        ];
    
        Vendor::create($data);
        return redirect('/vendors')->with('added', 'Vendor added successfully');
    }
    
     

    public function deleteVendor(Request $request)
{
    // Find the vendor by ID
    $vendor = Vendor::findOrFail($request->vendor_id);

    // Check if the vendor is linked to any purchases
    $purchaseCount = Purchases::where('vendor_id', $vendor->id)->count();

    // Check if the vendor is linked to any B2B entries (if applicable)
    $b2bCount = BusinesstoBusiness::where('customer_id', $vendor->id)->count();

    // Prevent deletion if vendor is used
    if ($purchaseCount > 0 || $b2bCount > 0) {
        Alert::error('Cannot Delete', "This vendor has $purchaseCount purchase(s) and $b2bCount B2B entry(ies). Delete them first.");
        return redirect()->back();
    }

    // Delete the vendor
    $vendor->delete();

    return redirect('/vendors')->with('deleted', 'Vendor deleted successfully');
}

    
   

    public function updatevendor(Request $request)
{
    $id = $request->vendor_id;
    $validated = $request->validate([
        "vendor_name" => "required|string|max:255",
        "contact_person" => "required|string|max:255",
        "address" => "required|string|max:255",
        "phone" => "required|string|max:20|unique:vendors,phone," . $id,
        "gst_number" => "nullable|string|max:255",
        "description" => "nullable|string",
    ]);

    $isGst = $request->has('is_gst');

    $data = [
        "vendor_name" => $validated["vendor_name"],
        "contact_person" => $validated["contact_person"],
        "address" => $validated["address"],
        "phone" => $validated["phone"],
        "is_gst" => $isGst,
        "gst_number" => $request->input('gst_number'),
        "description" => $request->input('description'),
    ];
     
    $vendor = Vendor::findOrFail($id);
    $vendor->update($data);

    return redirect('/vendors')->with('updated', 'Vendor updated successfully');
  }
 

  public function importVendors(Request $request){
    if ($request->hasFile('vendor_import')) {
        Excel::import(new VendorsImport, $request->file('vendor_import'));

        return redirect('/vendors')->with('success', 'Vendors imported successfully!');
    } 

  return redirect('/vendors')->with('error', 'No file uploaded or file is invalid.');
  }
 
  public function addVendorPopup(Request $request){
    $validated = $request->validate([
        "vendor_name" => "required|string|max:255",
        "contact_person" => "required|string|max:255",
        "address" => "required|string|max:255",
        "phone" => "required|string|max:20|unique:vendors",
        "gst_number" => "nullable|string|max:255",
        "description" => "nullable|string",
    ]);

    $isGst = $request->has('is_gst');

    $data = [
        "vendor_name" => $validated["vendor_name"],
        "contact_person" => $validated["contact_person"],
        "address" => $validated["address"],
        "phone" => $validated["phone"],
        "is_gst" => $isGst,
        "gst_number" => $request->input('gst_number'),
        "description" => $request->input('description'),
    ];

    $vendor = Vendor::create($data);

    return response()->json([
        'id' => $vendor->id,
        'vendor_name' => $vendor->vendor_name,
        'message' => 'Vendor added successfully'
    ]);
   }


   public function searchQuery(Request $request)
   {
       $query = $request->input('query');
   
       $vendors = Vendor::where('vendor_name', 'like', "%{$query}%")
                   ->limit(20)
                   ->get();
   
       return response()->json(['vendors' => $vendors]);
   }



}
