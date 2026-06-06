<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        $users = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul@example.com',
                'phone_number' => '9876543210',
                'dob' => '1995-05-15',
                'gender' => 'male',
                'emp_type' => 'full-time',
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'phone_number' => '9876543211',
                'dob' => '1998-08-22',
                'gender' => 'female',
                'emp_type' => 'part-time',
            ],
            [
                'name' => 'Amit Kumar',
                'email' => 'amit@example.com',
                'phone_number' => '9876543212',
                'dob' => '1992-01-10',
                'gender' => 'male',
                'emp_type' => 'freelance',
            ],
            [
                'name' => 'Sneha Reddy',
                'email' => 'sneha@example.com',
                'phone_number' => '9876543213',
                'dob' => '1997-11-30',
                'gender' => 'female',
                'emp_type' => 'full-time',
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'vikram@example.com',
                'phone_number' => '9876543214',
                'dob' => '1990-03-25',
                'gender' => 'male',
                'emp_type' => 'contract',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create Subscription Plans
        $subscriptions = [
            [
                'plan_name' => 'Basic Monthly',
                'plan_price' => 299.00,
                'duration_days' => 30,
                'description' => 'Basic monthly plan with limited features.',
            ],
            [
                'plan_name' => 'Standard Quarterly',
                'plan_price' => 799.00,
                'duration_days' => 90,
                'description' => 'Standard quarterly plan with all essential features.',
            ],
            [
                'plan_name' => 'Premium Annual',
                'plan_price' => 2499.00,
                'duration_days' => 365,
                'description' => 'Premium annual plan with all features and priority support.',
            ],
            [
                'plan_name' => 'Enterprise',
                'plan_price' => 4999.00,
                'duration_days' => 365,
                'description' => 'Enterprise plan with unlimited access and dedicated support.',
            ],
        ];

        foreach ($subscriptions as $subData) {
            Subscription::create($subData);
        }

        // Create Payments (subscription purchases)
        $payments = [
            [
                'user_id' => 1,
                'subscription_id' => 1,
                'amount' => 299.00,
                'payment_date' => '2024-01-15',
                'payment_status' => 'completed',
            ],
            [
                'user_id' => 1,
                'subscription_id' => 2,
                'amount' => 799.00,
                'payment_date' => '2024-04-15',
                'payment_status' => 'completed',
            ],
            [
                'user_id' => 2,
                'subscription_id' => 3,
                'amount' => 2499.00,
                'payment_date' => '2024-03-01',
                'payment_status' => 'completed',
            ],
            [
                'user_id' => 3,
                'subscription_id' => 1,
                'amount' => 299.00,
                'payment_date' => '2024-02-10',
                'payment_status' => 'completed',
            ],
            [
                'user_id' => 3,
                'subscription_id' => 2,
                'amount' => 799.00,
                'payment_date' => '2024-05-10',
                'payment_status' => 'pending',
            ],
            [
                'user_id' => 4,
                'subscription_id' => 4,
                'amount' => 4999.00,
                'payment_date' => '2024-06-01',
                'payment_status' => 'completed',
            ],
            [
                'user_id' => 5,
                'subscription_id' => 1,
                'amount' => 299.00,
                'payment_date' => '2024-01-20',
                'payment_status' => 'failed',
            ],
            [
                'user_id' => 5,
                'subscription_id' => 2,
                'amount' => 799.00,
                'payment_date' => '2024-02-20',
                'payment_status' => 'completed',
            ],
        ];

        foreach ($payments as $paymentData) {
            Payment::create($paymentData);
        }
    }
}
