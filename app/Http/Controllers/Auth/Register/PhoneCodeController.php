<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\ResendPhoneCodeRequest;
use App\Http\Requests\Auth\Register\SendPhoneCodeRequest;
use App\Http\Requests\Auth\Register\ValidatePhoneCodeRequest;
use App\Jobs\SendCodeByPhone;
use App\Models\User;
use Arr;
use Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class PhoneCodeController extends Controller
{
    /**
     * @param  Request  $request
     * @return InertiaResponse
     */
    public function index(Request $request): InertiaResponse
    {
        return Inertia::render('Auth/Phone/Send');
    }

    /**
     * Send 5 sign code via sms for validation
     * @param  SendPhoneCodeRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function store(SendPhoneCodeRequest $request, User $user): RedirectResponse
    {
        // if user exists, redirect to finalize
        if ($user->phone) {
            return redirect()->route('auth.register.finalize.create', [
                'user' => $user->uuid,
            ]);
        }

        $uuid = $user->uuid;

        Cache::put(
            "auth.sendcode.phone.{$uuid}",
            [
                'phone' => $request->phone,
                'ttl' => now()->addSeconds(config('auth.sms_code_timeout'))->timestamp,
                'code' => null
            ],
            now()->addSeconds(config('auth.sms_cool_down_after_seconds'))
        );

        SendCodeByPhone::dispatch($request->phone, $uuid);

        return redirect()->route('auth.register.phone.validate.show', compact('uuid'));
    }

    /**
     * Show verify code form
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse|InertiaResponse
     */
    public function show(Request $request, User $user): RedirectResponse|InertiaResponse
    {
        $uuid = $user->uuid;

        $cacheKey = "auth.sendcode.phone.{$uuid}";
        if (!$dataFromCache = Cache::get($cacheKey)) {
            return redirect()->route('auth.register.phone.create');
        }

        $expires = max($dataFromCache['ttl'] - now()->timestamp, 0);
        $phone = $dataFromCache['phone'];

        return Inertia::render('Auth/Phone/Verify', compact('uuid', 'expires', 'phone'));
    }

    /**
     * Validate code sent by sms
     * @param  ValidatePhoneCodeRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(ValidatePhoneCodeRequest $request, User $user): RedirectResponse
    {
        $uuid = $user->uuid;
        $cacheKey = "auth.sendcode.phone.{$uuid}";
        $dataFromCache = Cache::get($cacheKey);

        if (!$dataFromCache
            || $request->code !== Arr::get($dataFromCache, 'code')
            || !max($dataFromCache['ttl'] - now()->timestamp, 0)
        ) {
            throw ValidationException::withMessages([
                'code' => __('The provided code was incorrect.')
            ]);
        }

        $user->update(['phone' => $request->phone]);

        Cache::forget($cacheKey);

        return redirect()->route('auth.register.finalize.create', ['user' => $uuid]);
    }

    /**
     * Resend code
     * @param  ResendPhoneCodeRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function resend(ResendPhoneCodeRequest $request, User $user): RedirectResponse
    {
        $uuid = $request->uuid;
        $phone = $request->phone;
        $cacheKey = "auth.sendcode.phone.{$uuid}";
        $dataFromCache = Cache::get($cacheKey);

        if (!$dataFromCache
            || $request->phone !== $dataFromCache['phone']
            || !max($dataFromCache['ttl'] - now()->timestamp, 0)
        ) {
            return redirect()->route('auth.register.phone.create');
        }

        Cache::put(
            "auth.sendcode.phone.{$uuid}",
            [
                'phone' => $phone,
                'ttl' => now()->addSeconds(config('auth.sms_code_timeout'))->timestamp,
                'code' => null
            ],
            now()->addSeconds(config('auth.sms_cool_down_after_seconds'))
        );

        SendCodeByPhone::dispatch($phone, $uuid);

        return redirect()->route('auth.register.phone.validate.show', compact('uuid'));
    }
}
