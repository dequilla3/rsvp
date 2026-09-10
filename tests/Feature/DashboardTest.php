<?php

use App\Models\Guest;
use App\Models\User;

it('shows the guest count and names on the dashboard', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);
    Guest::create(['name' => 'KIM DELA CRUZ']);

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
    $response->assertSee('1');
    $response->assertSee('KIM DELA CRUZ');
});