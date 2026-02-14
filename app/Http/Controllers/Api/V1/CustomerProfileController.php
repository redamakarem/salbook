<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
{
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        $customer = Customer::where('email', $user->email)
            ->where('tenant_id', $user->tenant_id)
            ->first();

        if (! $customer) {
            $customer = Customer::create([
                'tenant_id' => $user->tenant_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        return response()->json([
            'customer' => new CustomerResource($customer),
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:20'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'preferences' => ['sometimes', 'nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $customer = Customer::where('email', $user->email)
            ->where('tenant_id', $user->tenant_id)
            ->first();

        if (! $customer) {
            $customer = Customer::create([
                'tenant_id' => $user->tenant_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        $customer->update($validator->validated());

        return response()->json([
            'message' => 'Profile updated successfully',
            'customer' => new CustomerResource($customer),
        ]);
    }

    public function bookings(Request $request): JsonResponse
    {
        // TODO: Implement when Appointment model is created in Phase 3
        return response()->json([
            'bookings' => [],
            'meta' => [
                'current_page' => 1,
                'last_page' => 1,
                'per_page' => 15,
                'total' => 0,
            ],
        ]);
    }
}
