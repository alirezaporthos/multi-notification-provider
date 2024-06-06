<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPrefrenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_user_prefrences()
    {
        $user = User::factory()->create();

        $data = [
            'notification_prefrences' => ['email'],
        ];

        $response = $this->postJson("/api/users/{$user->id}/user-prefrences", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function test_store_user_prefrences_fails_when_a_not_available_notification_type_is_submited()
    {
        $user = User::factory()->create();

        $response = $this->postJson("/api/users/{$user->id}/user-prefrences", [
            'notification_prefrences' => ['broadcast'],
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'notification_prefrences.0'
        ]);
    }
}
