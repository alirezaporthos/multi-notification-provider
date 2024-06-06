<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreUserPrefrenceRequest;
use App\Http\Requests\Api\User\UpdateUserPrefrenceRequest;
use App\Http\Resources\UserPrefrenceResource;
use App\Models\User;
use App\Models\UserPrefrence;
use Illuminate\Http\JsonResponse;

class UserPrefrenceController extends Controller
{
    public function store(User $user, StoreUserPrefrenceRequest $request): JsonResponse
    {
        $userPrefrence = $user->prefrence()->create([
            'notification_prefrences' => $request->notification_prefrences
        ]);

        return response()->json(
            new UserPrefrenceResource($userPrefrence),
            201
        );
    }

    public function update(User $user, UserPrefrence $userPrefrence, UpdateUserPrefrenceRequest $request)
    {
        $userPrefrence->update([
            'notification_prefrences' => $request->notification_prefrences
        ]);

        return response()->json(
            new UserPrefrenceResource($userPrefrence),
            200
        );
    }
}
