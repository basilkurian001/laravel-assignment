<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /*
      GET /api/users
      Get all users (paginated).
    */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $users = $this->userRepository->getAllUsers((int) $perPage);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /*
      GET /api/users/{id}
      Get user details with latest subscription and payment.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $userDetails = $this->userRepository->getUserWithDetails($id);

            return response()->json([
                'success' => true,
                'data' => $userDetails,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }

    /*
      GET /api/dashboard/{user_id}
      Get user dashboard data.
    */
    public function dashboard(int $userId): JsonResponse
    {
        try {
            $dashboard = $this->userRepository->getUserDashboard($userId);

            return response()->json([
                'success' => true,
                'data' => $dashboard,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }
    }
}
