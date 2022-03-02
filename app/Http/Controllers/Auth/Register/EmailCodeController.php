<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\ResendEmailCodeRequest;
use App\Http\Requests\Auth\Register\SendEmailCodeRequest;
use App\Http\Requests\Auth\Register\ValidateEmailCodeRequest;
use App\Jobs\SendCodeByEmail;
use App\Models\User;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Str;

class EmailCodeController extends Controller
{
    /**
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Send 5 sign code via sms for validation
     * @param  SendEmailCodeRequest  $request
     * @return RedirectResponse
     */
    public function store(SendEmailCodeRequest $request): RedirectResponse
    {
        // if user exists, redirect to particular step
        if ($user = User::active()->firstWhere('email', $request->email)) {
            return redirect()->route('auth.register.phone.create', [
                'user' => $user->uuid,
            ]);
        }

        // we put empty value, because after redirect to register.validate we check for cache key
        // if key doesn't exist, redirect to register
        $uuid = Str::uuid()->toString();

        Cache::put(
            "auth.sendcode.email.{$uuid}",
            [
                'email' => $request->email,
                'ttl' => now()->addSeconds(config('auth.email_code_timeout'))->timestamp,
                'code' => null
            ],
            now()->addDay()
        );

        SendCodeByEmail::dispatch($request->email, $uuid);

        return redirect()->route('auth.register.email.validate.show', compact('uuid'));
    }

    /**
     * Show verify code form
     * @param  Request  $request
     * @param  string  $uuid
     * @return RedirectResponse|InertiaResponse
     */
    public function show(Request $request, string $uuid): RedirectResponse|InertiaResponse
    {
        $cacheKey = "auth.sendcode.email.{$uuid}";
        if (!$dataFromCache = Cache::get($cacheKey)) {
            return redirect()->route('auth.register.email.create');
        }

        $expires = max($dataFromCache['ttl'] - now()->timestamp, 0);
        $email = $dataFromCache['email'];

        return Inertia::render('Auth/VerifyCode', compact('uuid', 'expires', 'email'));
    }

    /**
     * Validate code sent by sms
     * @param  ValidateEmailCodeRequest  $request
     * @param  string  $uuid
     * @return RedirectResponse
     */
    public function destroy(ValidateEmailCodeRequest $request, string $uuid): RedirectResponse
    {
        $cacheKey = "auth.sendcode.email.{$uuid}";
        $dataFromCache = Cache::get($cacheKey);

        if (!$dataFromCache
            || $request->code !== Arr::get($dataFromCache, 'code')
            || !max($dataFromCache['ttl'] - now()->timestamp, 0)
        ) {
            throw ValidationException::withMessages([
                'code' => __('message.provided_code_expired')
            ]);
        }

        $user = User::firstOrCreate(
            ['email' => $dataFromCache['email']],
            ['email_verified_at' => now()]
        );

        Cache::forget($cacheKey);
        $user->tokens()->delete();

        return redirect()->route('auth.register.phone.create', ['user' => $user->uuid]);
    }

    /**
     * Resend code
     * @param  ResendEmailCodeRequest  $request
     * @return RedirectResponse
     */
    public function resend(ResendEmailCodeRequest $request): RedirectResponse
    {
        $uuid = $request->uuid;
        $email = $request->email;
        $cacheKey = "auth.sendcode.email.{$uuid}";
        $dataFromCache = Cache::get($cacheKey);

        if (!$dataFromCache
            || $request->email !== $dataFromCache['email']
            || !max($dataFromCache['ttl'] - now()->timestamp, 0)
        ) {
            return redirect()->route('register');
        }

        Cache::put(
            "auth.sendcode.email.{$uuid}",
            [
                'email' => $email,
                'ttl' => now()->addSeconds(config('auth.email_code_timeout'))->timestamp,
                'code' => null
            ],
            now()->addDay()
        );

        SendCodeByEmail::dispatch($email, $uuid);

        return redirect()->route('auth.register.email.validate.show', compact('uuid'));
    }
}
