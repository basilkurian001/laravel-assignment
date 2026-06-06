<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    //create new payment
    public function createPayment(array $data);

    /**
     * Get latest payment for a user.
     */
    public function getLatestPaymentByUserId(int $userId);

    /**
     * Get all payments for a user.
     */
    public function getPaymentsByUserId(int $userId);
}
