<?php

namespace App\Repositories\Interfaces;

interface SubscriptionRepositoryInterface
{
    /**
     * Get all subscription plans.
     */
    public function getAllSubscriptions();

    /**
     * Get subscription by ID.
     */
    public function getSubscriptionById(int $id);

    /**
     * Get user subscription history.
     */
    public function getUserSubscriptionHistory(int $userId);
}
