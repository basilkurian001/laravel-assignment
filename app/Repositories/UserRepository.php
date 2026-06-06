<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get all users with pagination.
     */
    public function getAllUsers(int $perPage = 10)
    {
        return User::paginate($perPage);
    }

    /**
     * Get user details by ID.
     */
    public function getUserById(int $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Get user with latest subscription and payment details.
     */
    public function getUserWithDetails(int $id)
    {
        $user = User::findOrFail($id);

        $latestPayment = $user->payments()
            ->with('subscription')
            ->latest('payment_date')
            ->first();

        return [
            'user' => $user,
            'latest_subscription' => $latestPayment ? $latestPayment->subscription : null,
            'latest_payment' => $latestPayment,
        ];
    }

    /**
     * Get user dashboard data.
     */
    public function getUserDashboard(int $userId)
    {
        $user = User::findOrFail($userId);

        $latestPayment = $user->payments()
            ->with('subscription')
            ->where('payment_status', 'completed')
            ->latest('payment_date')
            ->first();

        $activePlan = null;
        if ($latestPayment && $latestPayment->subscription) {
            $subscriptionEndDate = \Carbon\Carbon::parse($latestPayment->payment_date)
                ->addDays($latestPayment->subscription->duration_days);

            if ($subscriptionEndDate->isFuture()) {
                $activePlan = $latestPayment->subscription;
            }
        }

        $totalSubscriptions = $user->payments()
            ->distinct('subscription_id')
            ->count('subscription_id');

        $totalPayments = $user->payments()->count();

        $lastPaymentDate = $user->payments()
            ->latest('payment_date')
            ->value('payment_date');

        return [
            'user_details' => $user,
            'active_plan' => $activePlan,
            'total_subscriptions' => $totalSubscriptions,
            'total_payments' => $totalPayments,
            'last_payment_date' => $lastPaymentDate ?? '',
        ];
    }
}
