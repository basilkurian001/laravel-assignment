<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Models\Subscription;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    /**
     * Get all subscription plans.
     */
    public function getAllSubscriptions()
    {
        return Subscription::all();
    }

    /**
     * Get subscription by ID.
     */
    public function getSubscriptionById(int $id)
    {
        return Subscription::findOrFail($id);
    }

    /**
     * Get user subscription history.
     */
    public function getUserSubscriptionHistory(int $userId)
    {
        return Payment::where('user_id', $userId)
            ->with('subscription')
            ->orderBy('payment_date', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'plan_name' => $payment->subscription->plan_name,
                    'plan_price' => $payment->subscription->plan_price,
                    'payment_amount' => $payment->amount,
                    'payment_date' => $payment->payment_date,
                    'payment_status' => $payment->payment_status,
                ];
            });
    }
}
