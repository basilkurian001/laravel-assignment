<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\SubscriptionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    protected SubscriptionRepositoryInterface $subscriptionRepository;
    protected PaymentRepositoryInterface $paymentRepository;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        PaymentRepositoryInterface $paymentRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
    }

    /*
      GET /api/subscriptions
      Get all subscription plans.
    */
    public function index(): JsonResponse
    {
        $subscriptions = $this->subscriptionRepository->getAllSubscriptions();

        return response()->json([
            'success' => true,
            'data' => $subscriptions,
        ]);
    }

    /*
      GET /api/users/{id}/subscriptions
      Get user subscription history.
    */
    public function userSubscriptionHistory(int $id): JsonResponse
    {
        try {
            // Verify user exists
            $this->userRepository->getUserById($id);

            $history = $this->subscriptionRepository->getUserSubscriptionHistory($id);

            return response()->json([
                'success' => true,
                'data' => $history,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }

    /*
      POST /api/subscriptions/purchase
      Purchase a subscription.
    */
    public function purchase(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'subscription_id' => 'required|integer|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $subscription = Subscription::findOrFail($request->subscription_id);

            if ((float) $request->amount !== (float) $subscription->plan_price) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid amount. Amount must match the subscription plan price.',
                    'expected_amount' => $subscription->plan_price,
                ], 422);
            }

            $payment = $this->paymentRepository->createPayment([
                'user_id' => $request->user_id,
                'subscription_id' => $request->subscription_id,
                'amount' => $request->amount,
                'payment_date' => now()->toDateString(),
                'payment_status' => 'completed',
            ]);

            $payment->load('subscription', 'user');

            return response()->json([
                'success' => true,
                'message' => 'Subscription purchased successfully.',
                'data' => $payment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to purchase subscription.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
