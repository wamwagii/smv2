<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulk Receipts</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f0f0;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto 30px;
            border: 1px solid #ddd;
            padding: 20px;
            background: white;
            page-break-after: always;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .receipt-title {
            font-size: 18px;
            margin-top: 10px;
            color: #555;
        }
        .receipt-number {
            font-size: 14px;
            margin-top: 5px;
            color: #666;
        }
        .details {
            margin: 20px 0;
        }
        .row {
            margin: 10px 0;
            display: flex;
        }
        .label {
            font-weight: bold;
            width: 150px;
        }
        .value {
            flex: 1;
        }
        .payment-info {
            background: #f5f5f5;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .amount {
            font-size: 20px;
            font-weight: bold;
            color: #27ae60;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            width: 200px;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .receipt {
                border: none;
                padding: 0;
                box-shadow: none;
                margin: 0;
                page-break-after: always;
            }
            .no-print {
                display: none;
            }
        }
        .button {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .button:hover {
            background: #2980b9;
        }
        .controls {
            text-align: center;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            background: white;
            padding: 10px;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="controls no-print">
        <button onclick="window.print()" class="button">🖨️ Print All Receipts</button>
        <button onclick="window.close()" class="button">❌ Close Window</button>
        <span style="margin-left: 20px; color: #666;">Total Receipts: {{ $receipts->count() }}</span>
    </div>
    
    @foreach($receipts as $receipt)
    <div class="receipt">
        <div class="header">
            <div class="school-name">{{ $receipt->feePayment->studentFee->student->school->name ?? 'School Name' }}</div>
            <div class="receipt-title">OFFICIAL PAYMENT RECEIPT</div>
            <div class="receipt-number">Receipt No: {{ $receipt->receipt_number }}</div>
        </div>

        <div class="details">
            <div class="row">
                <div class="label">Student Name:</div>
                <div class="value">{{ $receipt->feePayment->studentFee->student->full_name }}</div>
            </div>
            <div class="row">
                <div class="label">Admission No:</div>
                <div class="value">{{ $receipt->feePayment->studentFee->student->admission_number }}</div>
            </div>
            <div class="row">
                <div class="label">Class:</div>
                <div class="value">{{ $receipt->feePayment->studentFee->student->classRoom->name ?? 'Not Assigned' }}</div>
            </div>
            <div class="row">
                <div class="label">Payment Date:</div>
                <div class="value">{{ \Carbon\Carbon::parse($receipt->payment_date)->format('d/m/Y') }}</div>
            </div>
            <div class="row">
                <div class="label">Payment Method:</div>
                <div class="value">
                    @if($receipt->payment_method == 'mpesa')
                        M-PESA
                    @elseif($receipt->payment_method == 'bank_equity')
                        Equity Bank
                    @elseif($receipt->payment_method == 'bank_coop')
                        Co-operative Bank
                    @else
                        Cash
                    @endif
                </div>
            </div>
            @if($receipt->transaction_reference)
            <div class="row">
                <div class="label">Transaction Ref:</div>
                <div class="value">{{ $receipt->transaction_reference }}</div>
            </div>
            @endif
        </div>

        <div class="payment-info">
            <div class="row">
                <div class="label">Fee Type:</div>
                <div class="value">{{ $receipt->feePayment->studentFee->classFee->feeType->name ?? 'School Fees' }}</div>
            </div>
            <div class="row">
                <div class="label">Amount Paid:</div>
                <div class="value amount">KES {{ number_format($receipt->amount, 2) }}</div>
            </div>
            <div class="row">
                <div class="label">Outstanding Balance:</div>
                <div class="value">KES {{ number_format($receipt->feePayment->studentFee->balance, 2) }}</div>
            </div>
        </div>

        <div class="signature">
            <div class="signature-line">Student's Signature</div>
            <div class="signature-line">Parent's Signature</div>
            <div class="signature-line">Cashier's Signature</div>
        </div>

        <div class="footer">
            <p>This is a computer generated receipt and does not require a stamp.</p>
            <p>Printed on: {{ $receipt->printed_at->format('d/m/Y H:i:s') }} | Print #{{ $receipt->print_count }}</p>
        </div>
    </div>
    @endforeach
</body>
</html>