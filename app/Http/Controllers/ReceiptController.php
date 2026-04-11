<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    // Single receipt print
    public function print(Receipt $receipt)
    {
        return view('receipts.receipt', compact('receipt'));
    }
    
    // Bulk print - GET method (using session)
    public function bulkPrint(Request $request)
    {
        // Get receipt IDs from session or request
        $receiptIds = session('receipt_ids', $request->receipt_ids);
        
        if (!$receiptIds) {
            return redirect()->back()->with('error', 'No receipts selected for printing.');
        }
        
        $receipts = Receipt::whereIn('id', $receiptIds)->get();
        
        if ($receipts->isEmpty()) {
            return redirect()->back()->with('error', 'Receipts not found.');
        }
        
        // Clear the session after retrieving
        session()->forget('receipt_ids');
        
        return view('receipts.bulk-receipts', compact('receipts'));
    }
    
    // Bulk print - POST method (direct data)
    public function bulkPrintPost(Request $request)
    {
        $validated = $request->validate([
            'receipt_ids' => 'required|array',
            'receipt_ids.*' => 'exists:receipts,id'
        ]);
        
        $receipts = Receipt::whereIn('id', $validated['receipt_ids'])->get();
        
        return view('receipts.bulk-receipts', compact('receipts'));
    }
}