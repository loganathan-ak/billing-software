<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Customers;
use App\Models\Items;
use App\Models\User;
use App\Models\Expenses;
use App\Models\Purchases;
use App\Models\Invoices;
use App\Models\BusinessToBusiness;
use App\Models\Chits;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function index() {
        $startDate = Carbon::today()->subDays(6); // includes today

        // Purchases count per day
        $purchaseCounts = Purchases::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');
    
        // B2B count per day
        $b2bCounts = BusinessToBusiness::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');
    
        // Sales count per day
        $salesCounts = Invoices::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'date');
    
        // Prepare consistent data for 7 days
        $dates = collect(range(0, 6))->map(function ($i) {
            return Carbon::today()->subDays(6 - $i)->toDateString();
        });
    
        $dailyData = $dates->map(function ($date) use ($purchaseCounts, $b2bCounts, $salesCounts) {
            return [
                'date' => $date,
                'purchases' => $purchaseCounts[$date] ?? 0,
                'b2b' => $b2bCounts[$date] ?? 0,
                'sales' => $salesCounts[$date] ?? 0,
            ];
        });

        $customers = Customers::get()->count();
        $vendors = Vendor::get()->count();
        $items = Items::get()->count();
        $expenses = Expenses::latest()->take(10)->get();
        return view('welcome', compact('customers', 'vendors', 'items', 'expenses', 'dailyData'));
    }
    
    
    public function items(){
        $items = Items::paginate(10);
        $counts = Items::get()->count();
        $purchases = Purchases::all();
        $salesorders = Invoices::all();
        return view('items', compact('items', 'counts', 'purchases', 'salesorders'));
    }
    
    public function vendors() {
        $vendors = Vendor::paginate(10);
        $counts = Vendor::get()->count();
        return view('vendors', compact('vendors', 'counts'));
    }
    
    
    public function customers(){
        $customers = Customers::paginate(10);
        $counts = Customers::get()->count();
        return view('customers', compact('customers', 'counts'));
    }
    
    public function invoice(){
        $invoices = Invoices::paginate(10);
        $counts = Invoices::get()->count();
        $customers = Customers::get();
        return view('invoice', compact('invoices', 'counts', 'customers'));
    }

    public function businessToBusiness(){
        $invoices = BusinessToBusiness::paginate(10);
        $counts = BusinessToBusiness::get()->count();
        $customers = Customers::get();
        return view('b2b', compact('invoices', 'counts', 'customers'));
    }
    
    
    public function purchases(){
        $vendors = Vendor::get();
        $items = Items::get();
        $purchases = Purchases::paginate(10);
        $counts = Purchases::get()->count();
        return view('purchases', compact('purchases', 'counts', 'vendors', 'items'));
    }
    
    public function expenses(){
        $expenses = Expenses::paginate(10);
        $counts = Expenses::get()->count();
        return view('expenses', compact('expenses', 'counts'));
    }

    public function inventory(){
        $items = Items::paginate(10);
        $counts = Items::get()->count();
        $purchases = Purchases::get();
        $salesorder = Invoices::get();
        return view('inventory', compact('items', 'counts', 'purchases', 'salesorder'));
    }

    public function reports(){
        return view('reports');
    }
    
    public function addvendor(){
        return view('vendors.addvendor');
    }

    public function vendoreditPage($id){
        $vendordata = Vendor::findOrFail($id);
        return view('vendors.editvendor', compact('vendordata'));
    }


    public function addcustomer(){
        return view('customers.add-customer');
    }

    public function editCustomer($id){
        $customerdata = Customers::findOrFail($id);
        return view('customers.edit-customer', compact('customerdata'));
    }

    public function addItems(){
        return view('items.add-items');
    }

    public function editItem($id){
        $itemdata = Items::findOrFail($id);
        return view('items.edit-items', compact('itemdata'));  
    }

    public function addExpenses(){
        return view('expenses.add-expense');  
    }

    public function editExpenses($id) {
        $expensedata = Expenses::findOrFail($id);
        return view('expenses.edit-expense', compact('expensedata'));
    }
    
    public function addPurchase() {
        $admingst = User::where('user_role', 'admin')->first()->gst_number;
        $vendors = Vendor::get();
        $items = Items::get();
        return view('purchases.add-purchase', compact('vendors', 'items', 'admingst'));
    }

    public function editPurchase($id){
        $admingst = User::where('user_role', 'admin')->first()->gst_number;
        $vendors = Vendor::get();
        $items = Items::get();

        $purchaseOrder = Purchases::findOrFail($id);

        return view('purchases.edit-purchase', compact('vendors', 'items', 'purchaseOrder', 'admingst'));
    }

    public function addInvoice(){
        $items = Items::get();
        $customers = Customers::get();
            // Get the latest invoice (assuming 'invoice_number' is numeric)
    $latestInvoice = Invoices::orderBy('id', 'desc')->first();

    if ($latestInvoice) {
        // If there are existing invoices, increment the latest invoice number
        $newInvoiceNumber = (int) $latestInvoice->invoice_number + 1;
    } else {
        // If no invoices exist, start with a default
        $newInvoiceNumber = 10001;
    }

    return view('invoice.add-invoice', compact('items', 'newInvoiceNumber', 'customers'));
    }

    public function editInvoice($id){
        $invoice = Invoices::findOrFail($id);
        $items = Items::get();
        $customers = Customers::get();
        return view('invoice.edit-invoice', compact('invoice', 'items', 'customers'));
    }

    public function viewInvoice($id){
        $invoice = Invoices::findOrFail($id);
        $getitems = Items::all();
        $customers = Customers::get();
        return view('invoice.view-invoice', compact('invoice', 'getitems', 'customers'));
    }

    public function importItems(){
        return view('items.import-items');
    }

    public function importVendors(){
        return view('vendors.import-vendors');
    }

    public function importCustomers(){
        return view('customers.import-customers');
    }

    public function viewItemDetails($id){
        $item = Items::findOrFail($id);

        $purchases = Purchases::all();
        $salesorders = Invoices::all();
        $b2borders = BusinesstoBusiness::get();

        return view('items.view-item-details', compact('item', 'purchases', 'salesorders', 'b2borders'));
    }


    public function addBusinessInvoice(){
        $customers = Customers::where('is_gst', 1)->get();
        $items = Items::get();
        $admingst = User::where('user_role', 'admin')->first()->gst_number;
                   // Get the latest invoice (assuming 'invoice_number' is numeric)
    $latestInvoice = BusinessToBusiness::orderBy('id', 'desc')->first();

    if ($latestInvoice) {
        // If there are existing invoices, increment the latest invoice number
        $newInvoiceNumber = (int) $latestInvoice->invoice_number + 1;
    } else {
        // If no invoices exist, start with a default
        $newInvoiceNumber = 1999;
    }

        return view('b2b.add-business-invoice', compact('customers', 'newInvoiceNumber', 'items', 'admingst'));

    }

    public function editBusinessInvoice($id){
        $invoice = BusinessToBusiness::findOrFail($id);
        $customers = Customers::where('is_gst', 1)->get();
        $items = Items::get();
        $admingst = User::where('user_role', 'admin')->first()->gst_number;

        return view('b2b.edit-business-invoice', compact('customers', 'invoice', 'items', 'admingst'));
    }

    public function viewBusinessInvoice($id){
        $invoice = BusinessToBusiness::findOrFail($id);
        $customers = Customers::get();
        $getitems = Items::get();
        return view('b2b.view-business-invoice', compact('customers', 'invoice', 'getitems'));
    }
    
    public function registerPage(){
        return view('auth.register');
    }

    public function loginPage(){
        return view('auth.login');
    }

    public function userProfile(){

        $user = Auth::user();
        return view('userprofile.profile', compact('user'));
    }


    public function editProfile(){
        $user = Auth::user();
        return view('userprofile.editprofile', compact('user'));
    }


     public function employees(){
        $users = User::where('user_role', 'employee')->get();
        return view('employees', compact('users'));
     }

     public function chits(){
        $chits = Chits::where('chit_type', 'new')->get();
        $customers = Customers::get();
        return view('chits', compact('chits', 'customers'));
    }

    public function addChit()
    {
        $lastChit = Chits::latest()->first();
    
        // Extract number or start from 4999 if none exists
        $lastNumber = $lastChit ? (int) str_replace('CH-', '', $lastChit->chit_number) : 4999;
    
        // Generate new chit number
        $newChitNumber = 'CH-' . ($lastNumber + 1);
    
        $customers = Customers::get();
    
        return view('chits.add-chit', compact('customers', 'newChitNumber'));
    }

    public function updateChit($id){
        $chit = Chits::findOrFail($id);
        $customer = Customers::find($chit->customer_id); // Get related customer
        return view('chits.edit-main-chit', compact('chit', 'customer'));
    }

    

}
