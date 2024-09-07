<?php

use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AutoCheckPermission;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::group(['middleware' => ['auth', AutoCheckPermission::class]], function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('invoice-details', InvoiceDetailController::class);
    Route::resource('InvoiceAttachments', InvoiceAttachmentController::class);

    Route::get('/item/{id}', [InvoiceController::class, 'getProducts']);
    Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'get_file']);
    Route::get('View_file/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'open_file']);
    Route::post('delete-file', [InvoiceDetailController::class, 'destroy'])->name('delete-file');

    Route::post('/update-status/{id}', [InvoiceController::class, 'updateStatus']);
    Route::get('invoices-paid', [InvoiceController::class, 'paidInvoices'])->name('invoices-paid');
    Route::get('invoices-unpaid', [InvoiceController::class, 'unPaidInvoices'])->name('invoices-unpaid');
    Route::get('invoices-partial', [InvoiceController::class, 'partialInvoices'])->name('invoices-partial');
    Route::get('invoices/print/{id}', [InvoiceController::class, 'printInvoice'])->name('print-invoice');
    Route::get('invoices-export', [InvoiceController::class, 'exportInvoice']);
    Route::get('/mark-as-read', [InvoiceController::class,'markAsRead'])->name('mark-as-read');
    Route::resource('invoice-archive', InvoiceArchiveController::class);

    Route::get('invoices-reports', [InvoicesReportController::class, 'index']);
    Route::post('invoices-reports/search', [InvoicesReportController::class, 'search']);

    Route::get('customers-reports', [CustomersReportController::class, 'index']);
    Route::post('customers-reports/search', [CustomersReportController::class, 'search']);

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
}
);

Route::get('/{page}','App\Http\Controllers\AdminController@index');
