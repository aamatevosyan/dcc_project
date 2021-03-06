<?php

namespace App\Http\Controllers\Auth\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register\RegisterFinalizeRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Auth;
use Hash;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Request;

class RegisterController extends Controller
{
    public function create(Request $request, User $user): InertiaResponse
    {
        return Inertia::render('Auth/Finalize', ['uuid' => $user->uuid]);
    }

    public function store(RegisterFinalizeRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $validated['status'] = User::STATUS_ACTIVE;

        $user->update($validated);

        Auth::login($user, true);

        return redirect(RouteServiceProvider::HOME);
    }
}
