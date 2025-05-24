<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\BusinesstoBusinessController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChitsController;
use Illuminate\Support\Facades\Auth;


Route::get('/register', [RouteController::class, 'registerPage'])->name('register');

Route::post('/register', [AuthenticationController::class, 'register']);

Route::get('/login', [RouteController::class, 'loginPage'])->name('login');

Route::post('/login', [AuthenticationController::class, 'login']);

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::middleware(['login'])->group(function () {
    
Route::get('/', [RouteController::class, 'index'])->name('home');

Route::get('/items', [RouteController::class, 'items']);

Route::get('/vendors', [RouteController::class, 'vendors']);

Route::get('/customers', [RouteController::class, 'customers']);

Route::get('/sales-invoice', [RouteController::class, 'invoice']);

Route::get('/inventory', [RouteController::class, 'inventory']);

Route::get('/purchases', [RouteController::class, 'purchases']);

Route::get('/expenses', [RouteController::class, 'expenses']);

Route::get('/reports', [RouteController::class, 'reports']);

Route::get('/add-vendor', [RouteController::class, 'addvendor']);

Route::post('/add-vendor', [VendorController::class, 'store']);

Route::get('/edit-vendor/{id}', [RouteController::class, 'vendoreditPage']);

Route::delete('/delete-vendor', [VendorController::class, 'deletevendor']);

Route::put('/update-vendor', [VendorController::class, 'updatevendor']);

Route::get('/add-customer', [RouteController::class, 'addcustomer']);

Route::post('/add-customer', [CustomersController::class, 'store']);

Route::get('/edit-customer/{id}', [RouteController::class, 'editCustomer']);

Route::delete('/delete-customer', [CustomersController::class, 'deleteCustomer']);

Route::put('/update-customer', [CustomersController::class, 'updateCustomer']);

Route::get('/add-item', [RouteController::class, 'addItems']);

Route::post('/add-item', [ItemsController::class, 'store']);

Route::get('/edit-item/{id}', [RouteController::class, 'editItem']);

Route::delete('/delete-item', [ItemsController::class, 'deleteItem']);

Route::put('/update-item', [ItemsController::class, 'updateItem']);

Route::get('/add-expenses', [RouteController::class, 'addExpenses']);

Route::post('/add-expenses', [ExpensesController::class, 'store']);

Route::get('/edit-expense/{id}', [RouteController::class, 'editExpenses']);

Route::delete('/delete-expense', [ExpensesController::class, 'deleteExpense']);

Route::put('/update-expenses', [ExpensesController::class, 'updateExpense']);

Route::get('/add-purchase', [RouteController::class, 'addPurchase']);

Route::post('/create_purchase', [PurchasesController::class, 'store']);

Route::get('/edit-purchase/{id}', [RouteController::class, 'editPurchase']);

Route::delete('/delete-purchaseorder', [PurchasesController::class, 'deletePurchaseOrder']);

Route::put('/update-purchaseorder', [PurchasesController::class, 'updatePurchaseOrder']);

Route::get('/add-invoice', [RouteController::class, 'addInvoice']);

Route::post('/add-invoice', [InvoicesController::class, 'store']);

Route::get('/edit-invoice/{id}', [RouteController::class, 'editInvoice']);

Route::put('/update-invoice', [InvoicesController::class, 'update']);

Route::delete('/delete-invoice', [InvoicesController::class, 'deleteInvoice']);

Route::get('/view-invoice/{id}', [RouteController::class, 'viewInvoice']);

Route::get('/import-items', [RouteController::class, 'importItems']);

Route::post('/import-item', [ItemsController::class, 'importItems']);

Route::get('/import-vendor', [RouteController::class, 'importVendors']);

Route::post('/import-vendors', [VendorController::class, 'importVendors']);

Route::get('/import-customers', [RouteController::class, 'importCustomers']);

Route::post('/import-customers', [CustomersController::class, 'importCustomers']);

Route::post('/add-vendor-pop', [VendorController::class, 'addVendorPopup']);

Route::post('/add-item-pop', [ItemsController::class, 'addItemPopup']);

Route::get('/view-item/{id}', [RouteController::class, 'viewInventoryItem']);

Route::get('/item/{id}', [ItemsController::class, 'getProduct']); //ajax request for item

Route::get('/view-purchase/{id}', [PurchasesController::class, 'viewPurchase']); 

Route::post('/add-customer-pop', [CustomersController::class, 'storePopupCustomer']); 

Route::get('/view-item/{id}', [RouteController::class, 'viewItemDetails']); 

Route::get('/b2b-invoice', [RouteController::class, 'businessToBusiness']); 

Route::get('/add-business-invoice', [RouteController::class, 'addBusinessInvoice']); 

Route::post('/add-business-invoice', [BusinesstoBusinessController::class, 'store']); 

Route::get('/edit-business-invoice/{id}', [RouteController::class, 'editBusinessInvoice']); 

Route::put('/update-business-invoice', [BusinesstoBusinessController::class, 'updateBusinessInvoice']); 

Route::get('/view-business-invoice/{id}', [RouteController::class, 'viewBusinessInvoice']); 

Route::delete('/delete-business-invoice', [BusinesstoBusinessController::class, 'destroyBusinessInvoice']); 

Route::get('/sales-report', [ReportsController::class, 'salesReport']); 

Route::get('/customer-salesreport', [ReportsController::class, 'customerSalesReport']); 

Route::get('/b2b-salesreport', [ReportsController::class, 'b2bSalesReport']); 

Route::get('/business-salesreport', [ReportsController::class, 'businessSalesReport']); 

Route::get('/purchase-report-filter', [ReportsController::class, 'purchaseReportFilter']); 

Route::get('/profit-loss-filter', [ReportsController::class, 'profitLossFilter']); 

Route::get('/customer/{id}', [BusinesstoBusinessController::class, 'getCustomerOnselect']); 

Route::get('/vendor/{id}', [PurchasesController::class, 'getVendorOnselect']); 

Route::get('/autocomplete-customers', [CustomersController::class, 'autocomplete'])->name('customers.autocomplete');

Route::get('/user-profile', [RouteController::class, 'userProfile'])->name('userprofile'); 

Route::get('/edit-profile', [RouteController::class, 'editProfile'])->name('editprofile'); 

Route::post('/update-profile', [AuthenticationController::class, 'update'])->name('profile.update');

Route::get('/item-search', [ItemsController::class, 'searchQuery']);

Route::get('/vendor-search', [VendorController::class, 'searchQuery']);

Route::get('/customer-search', [CustomersController::class, 'searchQuery']);

Route::get('/expenses-search', [ExpensesController::class, 'searchQuery']);

Route::get('/purchases-search', [PurchasesController::class, 'searchQuery']);

Route::get('/b2b-search', [BusinesstoBusinessController::class, 'searchQuery']);

Route::get('/b2c-search', [InvoicesController::class, 'searchQuery']);

Route::get('/chits', [RouteController::class, 'chits'])->name('chits'); 

Route::get('/add-chit', [RouteController::class, 'addChit'])->name('chits.addchits'); 

Route::post('/add-chit', [ChitsController::class, 'store'])->name('chits.store');

Route::get('/get-chit-details/{chitNumber}', [ChitsController::class, 'getChitDetails']);




});

//Route::get('/profit-loss-report', [ReportsController::class, 'profitAndloss'])->middleware(['userrole']); 
Route::get('/profit-loss-report', [ReportsController::class, 'showProfitLossReport'])->middleware(['userrole']);
Route::get('/purchase-report', [ReportsController::class, 'purchasesReport'])->middleware(['userrole']); 

Route::middleware('is.admin')->group(function () {
    Route::get('/employees', [RouteController::class, 'employees']);
    Route::get('/edit-user/{id}', [AuthenticationController::class, 'editUser']);
    Route::get('/add-user', [AuthenticationController::class, 'addUserForm']);
    Route::post('/add-user', [AuthenticationController::class, 'addUser']);
    Route::put('/update-user/{id}', [AuthenticationController::class, 'updateUser'])->name('user.update');
});
