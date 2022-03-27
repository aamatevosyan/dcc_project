<?php

use App\Models\User;
use Tests\Feature\Register\RegisterUtils;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;
use function Spatie\PestPluginTestTime\testTime;

test('(Register Step 1) register screen can be rendered', function () {
    getJson(route('auth.register.email.create'))
        ->assertStatus(200);
});

test('(Register Step 1) invalid email', function () {
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example'
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('(Register Step 1) valid email', function () {
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);
    $response->assertRedirect(route('auth.register.email.validate.show', $uuid));
    assertTrue(RegisterUtils::hasEmailCodeInCache($uuid));
});

test('(Register Step 1) inactive user email exists', function () {
    // create inactive user with same email
    $email = 'test@example.com';
    RegisterUtils::createUser($email, User::STATUS_INACTIVE);

    // try to store email and get code
    $response = postJson(route('auth.register.email.store'), [
        'email' => $email
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);
    // redirect to particular step since the user already exists
    $response->assertRedirect(route('auth.register.phone.create', $uuid));
});

test('(Register Step 1) active user email exists', function () {
    // create inactive user with same email
    $email = 'test@example.com';
    RegisterUtils::createUser($email, User::STATUS_ACTIVE);

    // try to store email and get code
    $response = postJson(route('auth.register.email.store'), [
        'email' => $email
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('(Register Step 1) verify email code', function () {
    $email = 'test@example.com';
    $response = postJson(route('auth.register.email.store'), [
        'email' => $email
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);
    $code = RegisterUtils::getEmailVerificationCodeFromCache($uuid);

    $response = deleteJson(route('auth.register.email.validate.destroy', $uuid), [
        'code' => $code
    ]);

    // redirect to particular step
    $uuid = RegisterUtils::getUuidFromResponse($response);
    $response->assertRedirect(route('auth.register.phone.create', ['user' => $uuid]));

    assertEmpty(User::whereEmail($email)->first()->tokens);
    assertFalse(RegisterUtils::hasEmailCodeInCache($uuid));
});

test('(Register Step 1) verify email with expired code', function () {
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);
    $code = RegisterUtils::getEmailVerificationCodeFromCache($uuid);

    // code expired
    testTime()->addSeconds(config('auth.email_code_timeout') + 100);

    $response = deleteJson(route('auth.register.email.validate.destroy', $uuid), [
        'code' => $code
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});

test('(Register Step 1) resend email code', function () {
    $email = 'test@example.com';
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);
    $oldCode = RegisterUtils::getEmailVerificationCodeFromCache($uuid);

    // try to resend code
    $response = postJson(route('auth.register.email.resend', $uuid), [
        'email' => $email
    ]);

    $response->assertRedirect(route('auth.register.email.validate.show', $uuid));

    $newCode = RegisterUtils::getEmailVerificationCodeFromCache($uuid);

    assertNotEquals($oldCode, $newCode);
});

test('(Register Step 1) resend expired code', function () {
    $email = 'test@example.com';
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);

    $uuid = RegisterUtils::getUuidFromResponse($response);

    // code expired
    testTime()->addSeconds(config('auth.email_code_timeout') + 100);

    // try to resend code
    $response = postJson(route('auth.register.email.resend', $uuid), [
        'email' => $email
    ]);

    $response->assertRedirect(route('auth.register.email.create'));

    // another try to send code
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);
    $uuid = RegisterUtils::getUuidFromResponse($response);
    $response->assertRedirect(route('auth.register.email.validate.show', $uuid));
    assertTrue(RegisterUtils::hasEmailCodeInCache($uuid));
});
