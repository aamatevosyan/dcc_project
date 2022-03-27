<?php

use App\Models\User;
use Tests\Feature\Register\RegisterUtils;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertTrue;
use function Spatie\PestPluginTestTime\testTime;

test('(Register Step 2) invalid phone', function () {
    $email = 'test@example.com';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    $response = postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['phone']);
});

test('(Register Step 2) valid phone', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    $response = postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);

    $response->assertRedirect(route('auth.register.phone.validate.show', [
        'user' => $uuid
    ]));

    assertTrue(RegisterUtils::hasPhoneCodeInCache($uuid));
});

test('(Register Step 2) user already has phone verification', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE, $phone);
    $uuid = $user->uuid;
    $response = postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);

    $response->assertRedirect(route('auth.register.finalize.create', [
        'user' => $uuid
    ]));
});

test('(Register Step 2) verify phone code', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);
    assertEmpty(User::whereEmail($email)->first()->phone);

    $code = RegisterUtils::getPhoneVerificationCodeFromCache($uuid);
    $response = deleteJson(route('auth.register.phone.validate.destroy', $uuid), [
        'code' => $code
    ]);

    // redirect to particular step
    $response->assertRedirect(route('auth.register.finalize.create', ['user' => $uuid]));

    // phone saved
    assertEquals($phone, User::whereUuid($uuid)->first()->phone);
    assertFalse(RegisterUtils::hasPhoneCodeInCache($uuid));
});

test('(Register Step 2) verify phone with expired code', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);
    $code = RegisterUtils::getPhoneVerificationCodeFromCache($uuid);

    // code expired
    testTime()->addSeconds(config('auth.sms_code_timeout') + 100);

    $response = deleteJson(route('auth.register.phone.validate.destroy', $uuid), [
        'code' => $code
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['code']);
});

test('(Register Step 2) resend phone code', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);

    $oldCode = RegisterUtils::getPhoneVerificationCodeFromCache($uuid);

    // try to resend code
    $response = postJson(route('auth.register.phone.resend', $uuid), [
        'phone' => $phone,
        'user' => $uuid
    ]);

    $response->assertRedirect(route('auth.register.phone.validate.show', [
        'user' => $uuid
    ]));

    $newCode = RegisterUtils::getPhoneVerificationCodeFromCache($uuid);

    assertNotEquals($oldCode, $newCode);
});

test('(Register Step 2) resend expired code', function () {
    $email = 'test@example.com';
    $phone = '+7777777777';

    $user = RegisterUtils::createUser($email, User::STATUS_INACTIVE);
    $uuid = $user->uuid;
    postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);

    // code expired
    testTime()->addSeconds(config('auth.sms_code_timeout') + 100);

    // try to resend code
    $response = postJson(route('auth.register.phone.resend', $uuid), [
        'phone' => $phone,
        'user' => $uuid
    ]);

    $response->assertRedirect(route('auth.register.phone.create', ['user' => $user]));

    // another try to send code
    $response = postJson(route('auth.register.phone.store', $uuid), [
        'user' => $uuid,
        'phone' => $phone
    ]);
    $response->assertRedirect(route('auth.register.phone.validate.show', [
        'user' => $uuid
    ]));

    assertTrue(RegisterUtils::hasPhoneCodeInCache($uuid));
});
