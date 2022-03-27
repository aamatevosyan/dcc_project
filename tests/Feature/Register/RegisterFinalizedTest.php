<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\Feature\Register\RegisterUtils;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;

test('(Register Step 3) valid request form', function () {
    $firstName = 'Puk';
    $lastName = 'PukPuk';
    $password = '123pukpuk123';

    $user = RegisterUtils::createUser('test@example.com', User::STATUS_INACTIVE, "+77777777");

    $user = User::whereUuid($user->uuid)->first();
    assertEmpty($user->last_name);
    assertEmpty($user->first_name);
    assertEmpty($user->password);

    $response = postJson(route('auth.register.finalize.store', ['user' => $user->uuid]), [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'password' => $password,
        'password_confirmation' => $password
    ]);

    $response->assertRedirect(RouteServiceProvider::HOME);

    $user = User::whereUuid($user->uuid)->first();
    assertEquals(User::STATUS_ACTIVE, $user->status);
    assertNotEmpty($user->last_name);
    assertNotEmpty($user->first_name);
    assertNotEmpty($user->password);
});

test('(Register Step 3) invalid password confirmation', function () {
    $firstName = 'Puk';
    $lastName = 'PukPuk';
    $password = '123pukpuk123';

    $user = RegisterUtils::createUser('test@example.com', User::STATUS_INACTIVE, "+77777777");

    $response = postJson(route('auth.register.finalize.store', ['user' => $user->uuid]), [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'password' => $password,
        'password_confirmation' => '123'
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

test('(Register Step 3) invalid password', function () {
    $firstName = 'Puk';
    $lastName = 'PukPuk';
    $password = '123';

    $user = RegisterUtils::createUser('test@example.com', User::STATUS_INACTIVE, "+77777777");

    $response = postJson(route('auth.register.finalize.store', ['user' => $user->uuid]), [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'password' => $password,
        'password_confirmation' => $password
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});
