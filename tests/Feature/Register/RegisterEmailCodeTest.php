<?php

use App\Models\User;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertEmpty;
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

    $uuid = getUuidFromResponse($response);
    $response->assertRedirect(route('auth.register.email.validate.show', $uuid));
});

test('(Register Step 1) inactive user email exists', function () {
    // create inactive user with same email
    $email = 'test@example.com';
    User::create([
        'email' => $email,
        'uuid' => Str::uuid()->toString(),
        'status' => User::STATUS_INACTIVE
    ]);

    // try to store email and get code
    $response = postJson(route('auth.register.email.store'), [
        'email' => $email
    ]);

    $uuid = getUuidFromResponse($response);
    // redirect to particular step since the user already exists
    $response->assertRedirect(route('auth.register.phone.create', $uuid));
});

test('(Register Step 1) active user email exists', function () {
    // create inactive user with same email
    $email = 'test@example.com';
    User::create([
        'email' => $email,
        'uuid' => Str::uuid()->toString(),
        'status' => User::STATUS_ACTIVE
    ]);

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

    $uuid = getUuidFromResponse($response);
    $code = getVerificationCodeFromCache($uuid);

    $response = deleteJson(route('auth.register.email.validate.destroy', $uuid), [
        'code' => $code
    ]);

    // redirect to particular step
    $uuid = getUuidFromResponse($response);
    $response->assertRedirect(route('auth.register.phone.create', ['user' => $uuid]));

    $user = User::whereEmail($email)->first();
    assertEmpty($user->tokens);
});

test('(Register Step 1) verify email with expired code', function () {
    $response = postJson(route('auth.register.email.store'), [
        'email' => 'test@example.com'
    ]);

    $uuid = getUuidFromResponse($response);
    $code = getVerificationCodeFromCache($uuid);

    // token expired
    testTime()->addSeconds(config('auth.email_code_timeout') + 100);

    $response = deleteJson(route('auth.register.email.validate.destroy', $uuid), [
        'code' => $code
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});

function getUuidFromResponse($response): string
{
    $location = $response->headers->get('location');
    return substr($location, strripos($location, "/") + 1);
}

function getVerificationCodeFromCache($uuid): string
{
    $cacheKey = "auth.sendcode.email.{$uuid}";
    return Cache::get($cacheKey)['code'];
}

