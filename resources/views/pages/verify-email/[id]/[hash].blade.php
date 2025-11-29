<?php
use function Laravel\Folio\{name,render,middleware};
use Illuminate\View\View;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

name('verification.verify');
middleware(['signed','throttle:6,1']);

render(function (View $view) {

    $user = User::findOrFail($view->id);

    if (! hash_equals((string) $view->hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }

    if (! $user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return $view;    
});
?>
<x-guest-layout>
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <img class="mx-auto size-16 " src="{{asset('images/app-logo.svg')}}" alt="logo" />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        Selamat datang
                    </h2>
                </div>
            </div>
            @livewire('verification-success')
        </div>
    </main>
</x-guest-layout>


