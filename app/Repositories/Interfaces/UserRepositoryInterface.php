<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * Get all users with pagination.
     */
    public function getAllUsers(int $perPage = 10);

    /**
     * Get user details by ID.
     */
    public function getUserById(int $id);

    /**
     * Get user with latest subscription and payment details.
     */
    public function getUserWithDetails(int $id);

    /**
     * Get user dashboard data.
     */
    public function getUserDashboard(int $userId);
}
