<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function createPayment(array $data)
    {
        return Payment::create($data);
    }

    public function getLatestPaymentByUserId(int $userId)
    {
        return Payment::where('user_id', $userId)
            ->with('subscription')
            ->latest('payment_date')
            ->first();
    }

    public function getPaymentsByUserId(int $userId)
    {
        return Payment::where('user_id', $userId)
            ->with('subscription')
            ->orderBy('payment_date', 'desc')
            ->get();
    }
}
