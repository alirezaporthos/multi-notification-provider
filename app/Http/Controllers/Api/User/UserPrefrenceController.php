<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\StoreUserPrefrenceRequest;
use App\Http\Resources\UserPrefrenceResource;
use App\Models\User;
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
}
