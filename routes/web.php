<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReceiptController;

Route::middleware(['auth'])->group(function () {
    // Single receipt print - GET request
    Route::get('/receipt/{receipt}/print', [ReceiptController::class, 'print'])->name('receipt.print');
    
    // Bulk receipt print - GET request (using session data)
    Route::get('/receipts/bulk-print', [ReceiptController::class, 'bulkPrint'])->name('receipts.bulk-print');
    
    // Alternative: POST route for bulk print if you prefer
    Route::post('/receipts/bulk-print', [ReceiptController::class, 'bulkPrintPost'])->name('receipts.bulk-print-post');
});

Route::get('/', function () {
    if (Auth::check()) {
        // If user is already logged in, go to dashboard
        return redirect('/admin');
    }
    
    // If not logged in, show a custom landing page for your school
    return view('welcome'); // Or create a school landing page
});