<?php

use App\Models\PkbmProfile;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, rules};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;

state('email');
state('password');
state('remember');

rules(fn() => [
    'email' => 'required|string|email',
    'password' => 'required|string',
]);

$submit = function () {
    $this->validate();

    $this->authenticate();

    // Login berhasil → redirect
    return $this->redirectRoute('admin.dashboard', [], navigate: true);
};

$authenticate = function () {
    $this->ensureIsNotRateLimited();

    if (
        !Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], (bool) $this->remember)
    ) {

        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    RateLimiter::clear($this->throttleKey());
};


$ensureIsNotRateLimited = function () {
    if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
        return;
    }

    event(new Lockout($this));

    $seconds = RateLimiter::availableIn($this->throttleKey());

    throw ValidationException::withMessages([
        'email' => trans('auth.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]),
    ]);
};

$throttleKey = function (): string {
    return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
};

?>

<main class="flex w-full flex-col items-center bg-white dark:bg-navy-700 lg:max-w-md">
    <div class="flex w-full max-w-sm grow flex-col justify-center p-5">
        <div class="text-center">
            @if(isset($profile) && $profile && $profile->logo)
                <img class="mx-auto size-16 lg:hidden rounded-lg" src="{{ Storage::url($profile->logo) }}" alt="logo" />
            @else
                <img class="mx-auto size-16 lg:hidden" src="{{ asset('images/app-logo.svg') }}" alt="logo" />
            @endif
            <div class="mt-4">
                <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                    Welcome Back
                </h2>
                <p class="text-slate-400 dark:text-navy-300">
                    Please sign in to continue
                </p>
            </div>
        </div>
        <form class="mt-16" wire:submit.prevent="submit" method="post">
            <div>
                <label class="relative flex">
                    <input
                        class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                        placeholder="Username or email" type="text" name="email" wire:model="email"
                        value="{{ old('email')}}" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                </label>
                @error('email')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <label class="relative flex">
                    <input
                        class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                        placeholder="Password" type="password" name="password" wire:model="password"
                        value="{{ old('password')}}" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                </label>
                @error('password')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4 flex items-center justify-between space-x-2">
                <label class="inline-flex items-center space-x-2">
                    <input wire:model="remember"
                        class="form-checkbox is-outline size-5 rounded border-slate-400/70 bg-slate-100 before:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-500 dark:bg-navy-900 dark:before:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                        type="checkbox" />
                    <span class="line-clamp-1">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" wire:navigate.hover
                    class="text-xs text-slate-400 transition-colors line-clamp-1 hover:text-slate-800 focus:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 dark:focus:text-navy-100">Forgot
                    Password?</a>
            </div>

            <button type="submit"
                class="btn mt-10 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Sign In
            </button>
        </form>
    </div>
    <div class="my-5 flex justify-center text-xs text-slate-400 dark:text-navy-300">
        <a href="#">Privacy Notice</a>
        <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
        <a href="#">Term of service</a>
    </div>
</main>