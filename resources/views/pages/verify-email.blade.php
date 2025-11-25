<?php 

use function Laravel\Folio\{name,middleware};

name('verification.notice');
middleware(['auth']);

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
                    <p class="text-slate-400 dark:text-navy-300">
                           {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    
                    </p>
                </div>
            </div>
            @livewire('verification-email')
        </div>
    </main>
</x-guest-layout>
