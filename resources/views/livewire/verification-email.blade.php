<?php
use function Livewire\Volt\{state,mount};

$send = function () {
    auth()->user()->sendEmailVerificationNotification();
};

$verify = function () {
    if (auth()->user() && auth()->user()->hasVerifiedEmail()) {
        return $this->redirectRoute('admin.dashboard', [], navigate: true);
    }
};

?>

<div>
    <div class="card mt-5 rounded-lg p-5 lg:p-7">                
        <div wire:poll.1s="verify">
        <button wire:click="send"
            class="btn mt-5 w-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            Verifikasi Email
        </button>
    </div>
</div>
