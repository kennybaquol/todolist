<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('home', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('register button redirects to register page', function () {
    $response = $this->get('/login');

    $response->assertSee('register');

    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('forgot password link redirects to forgot-password page', function () {
    $response = $this->get('/login');

    $response->assertSee('forgot-password');

    $response = $this->get(route('password.request'));

    $response->assertStatus(200);
});
