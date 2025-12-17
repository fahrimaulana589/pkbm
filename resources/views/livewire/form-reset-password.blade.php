<?php

use App\Models\PkbmProfile;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, rules};
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

state('token');
state('email');
state('password');
state('password_confirmation');

rules(fn() => [
    'email' => 'required|string|email|exists:users,email',
    'password' => 'required|string|min:8|confirmed',
    'password_confirmation' => 'required|string|min:8',
]);

$submit = function () {
    $this->validate();

    $status = Password::reset(
        [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ],
        function ($user) {
            $user->forceFill([
                'password' => bcrypt($this->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    if ($status == Password::PASSWORD_RESET) {
        // Password reset successful → redirect to login page
        return $this->redirectRoute('login', [], navigate: true);
    } else {
        // Password reset failed → show error message
        $this->addError('email', __($status));
    }
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

            <div class="mt-4">
                <label class="relative flex">
                    <input
                        class="form-input peer w-full rounded-lg bg-slate-150 px-3 py-2 pl-9 ring-primary/50 placeholder:text-slate-400 hover:bg-slate-200 focus:ring dark:bg-navy-900/90 dark:ring-accent/50 dark:placeholder:text-navy-300 dark:hover:bg-navy-900 dark:focus:bg-navy-900"
                        placeholder="Password Confirmation" type="password" name="password_confirmation"
                        wire:model="password_confirmation" value="{{ old('password_confirmation')}}" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                </label>
                @error('password_confirmation')
                    <span class="text-tiny+ text-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="btn mt-10 h-10 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                Reset Password
            </button>
        </form>
    </div>
    <div class="my-5 flex justify-center text-xs text-slate-400 dark:text-navy-300">
        <a href="#">Privacy Notice</a>
        <div class="mx-3 my-1 w-px bg-slate-200 dark:bg-navy-500"></div>
        <a href="#">Term of service</a>
    </div>
</main>