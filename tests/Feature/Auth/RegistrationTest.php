<?php

test('registration screen is not publicly available', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('users cannot register publicly', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertNotFound();
    $this->assertGuest();
});
