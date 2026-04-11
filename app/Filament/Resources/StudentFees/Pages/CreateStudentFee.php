<?php

namespace App\Filament\Resources\StudentFees\Pages;

use App\Filament\Resources\StudentFees\StudentFeeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentFee extends CreateRecord
{
    protected static string $resource = StudentFeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Calculate total_payable if not set
        if (empty($data['total_payable'])) {
            $amount = $data['amount'] ?? 0;
            $discount = $data['discount'] ?? 0;
            $data['total_payable'] = $amount - $discount;
        }

        // Ensure paid_amount has a value
        if (!isset($data['paid_amount'])) {
            $data['paid_amount'] = 0;
        }

        // Calculate balance
        $data['balance'] = $data['total_payable'] - $data['paid_amount'];
        
        // Ensure balance is not negative
        if ($data['balance'] < 0) {
            $data['balance'] = 0;
        }

        // Set status based on balance
        if ($data['balance'] <= 0) {
            $data['status'] = 'paid';
        } elseif ($data['paid_amount'] > 0) {
            $data['status'] = 'partial';
        } else {
            $data['status'] = 'pending';
        }

        return $data;
    }
}