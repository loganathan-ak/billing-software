<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Customers;
use App\Models\Items;
use App\Models\Expenses;
use App\Models\Purchases;
use App\Models\Invoices;
use App\Models\BusinessToBusiness;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function salesReport(){
        $customerSales = Invoices::latest()->get();
        $customers = Customers::get();
        $customersWithoutGst = Customers::where("is_gst", 0)->get();
        return view('reports.salesreport', compact('customerSales', 'customers', 'customersWithoutGst'));
    }

    public function customerSalesReport(Request $request)
    {
        // Fetch customers without GST for the filter dropdown
        $customers = Customers::orderBy('customer_name')->get();

        $customersWithoutGst = Customers::where("is_gst", 0)->get();
    
        // Start building the query
        $query = Invoices::query();
    
        // Apply filters
        if ($request->filled('customer_start_date')) {
            $query->whereDate('invoice_date', '>=', $request->customer_start_date);
        }
    
        if ($request->filled('customer_end_date')) {
            $query->whereDate('invoice_date', '<=', $request->customer_end_date);
        }
    
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
    
        // Get the filtered sales
        $customerSales = $query->orderBy('created_at', 'desc')->get();
    
        return view('reports.salesreport', compact('customerSales', 'customers', 'customersWithoutGst'));
    }
     

    public function b2bSalesReport(){
        $b2bSales  = BusinessToBusiness::latest()->get();
        $b2bCustomers  = Customers::where('is_gst', 1)->get();
        return view('reports.b2b-salesreport', compact('b2bSales', 'b2bCustomers'));
    }

    public function businessSalesReport(Request $request)
    {
    $query = BusinessToBusiness::query();
    $b2bCustomers = Customers::where('is_gst', 1)->get();

    // Apply filters
    if ($request->filled('b2b_start_date')) {
        $query->whereDate('invoice_date', '>=', $request->b2b_start_date);
    }

    if ($request->filled('b2b_end_date')) {
        $query->whereDate('invoice_date', '<=', $request->b2b_end_date);
    }

    if ($request->filled('b2b_customer_id')) {
        $query->where('customer_id', $request->b2b_customer_id);
    }

    $b2bSales = $query->latest()->get();

    return view('reports.b2b-salesreport', compact('b2bSales', 'b2bCustomers'));
   }

  public function purchasesReport(){
    $purchases = Purchases::all();
    $vendors = Vendor::all();
    return view('reports.purchases-report', compact('purchases', 'vendors'));
  }
   
  public function purchaseReportFilter(Request $request)
  {
      $query = Purchases::query();
      $vendors = Vendor::all();
  
      // Apply filters
      if ($request->filled('purchase_start_date')) {
          $query->whereDate('created_at', '>=', $request->purchase_start_date);
      }
  
      if ($request->filled('purchase_end_date')) {
          $query->whereDate('created_at', '<=', $request->purchase_end_date);
      }
  
      if ($request->filled('vendor_id')) {
          $query->where('vendor_id', $request->vendor_id);
      }
  
      $purchases = $query->latest()->get();
  
      return view('reports.purchases-report', compact('purchases', 'vendors'));
  }
  


  public function showProfitLossReport()
  {

  
      // Sales (Customer + B2B)
      $customerSales = Invoices::query();
      $b2bSales = BusinessToBusiness::query();
  
      // Purchases and Expenses
      $purchases = Purchases::query();
      $expenses = Expenses::query();

  
      $totalIncome = $customerSales->sum('grand_total') + $b2bSales->sum('grand_total');
      $totalExpense = $purchases->sum('grand_total') + $expenses->sum('amount');
      $netProfit = $totalIncome - $totalExpense;
  
      return view('reports.profit-loss', compact(
          'customerSales',
          'b2bSales',
          'purchases',
          'expenses',
          'totalIncome',
          'totalExpense',
          'netProfit'
      ));
  }


  public function profitLossFilter(Request $request)
  {
    $start = $request->input('start_date');
    $end = $request->input('end_date');

    // Filtered Customer Invoices
    $invoiceQuery = Invoices::query();
    if ($start) $invoiceQuery->whereDate('invoice_date', '>=', $start);
    if ($end) $invoiceQuery->whereDate('invoice_date', '<=', $end);
    $customerSales = $invoiceQuery->get();
    $totalCustomerSales = $customerSales->sum('grand_total');

    // Filtered B2B Sales
    $b2bQuery = BusinessToBusiness::query();
    if ($start) $b2bQuery->whereDate('invoice_date', '>=', $start);
    if ($end) $b2bQuery->whereDate('invoice_date', '<=', $end);
    $b2bSales = $b2bQuery->get();
    $totalB2BSales = $b2bSales->sum('grand_total');

    // Filtered Purchases
    $purchaseQuery = Purchases::query();
    if ($start) $purchaseQuery->whereDate('invoice_date', '>=', $start);
    if ($end) $purchaseQuery->whereDate('invoice_date', '<=', $end);
    $purchases = $purchaseQuery->get();
    $totalPurchase = $purchases->sum('grand_total');

    // Filtered Expenses
    $expenseQuery = Expenses::query();
    if ($start) $expenseQuery->whereDate('created_at', '>=', $start);
    if ($end) $expenseQuery->whereDate('created_at', '<=', $end);
    $expenses = $expenseQuery->get();
    $totalExpenses = $expenses->sum('amount');

    // Final Totals
    $totalIncome = $totalCustomerSales + $totalB2BSales;
    $totalExpense = $totalPurchase + $totalExpenses;
    $netProfit = $totalIncome - $totalExpense;

    return view('reports.profit-loss', compact(
        'customerSales',
        'b2bSales',
        'purchases',
        'expenses',
        'totalIncome',
        'totalExpense',
        'netProfit'
    ));
}




}
