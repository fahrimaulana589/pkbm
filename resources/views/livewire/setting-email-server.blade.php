<?php

use function Livewire\Volt\{state,rules,mount};
use App\Models\Setting;

state('email_server');
state('email_port');
state('email_username');
state('email_password');

rules(fn() => [
    'email_server' => 'required|string',
    'email_port' => 'required|integer',
    'email_username' => 'required|string',
    'email_password' => 'required|string',
]);

mount(function () {
    $settings = Setting::find(1);
    if ($settings) {
        $this->email_server = $settings->email_server;
        $this->email_port = $settings->email_port;
        $this->email_username = $settings->email_username;
        $this->email_password = $settings->email_password;
        // Note: For security reasons, you might not want to load the password directly
    }
});

$submit = function () {
    $this->validate();

    // Update the email server settings
    // (Implementation depends on how settings are stored in your application)
    Setting::updateOrCreate(
        ['id' => 1],
        [
            'email_server' => $this->email_server,
            'email_port' => $this->email_port,
            'email_username' => $this->email_username,
            'email_password' => $this->email_password,
        ]
    );

    $this->dispatch('email-server-updated');
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Update Email Server') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Ensure your email server settings are correct to stay connected.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
                <x-input-label>
                    <span>Email Server</span>
                    <x-text-input wire:model="email_server" 
                        placeholder="Email Server" 
                        type="text" 
                        name="email_server" 
                        :error="$errors->has('email_server')" />
                    <x-input-error :messages="$errors->get('email_server')" />
                </x-input-label>

                <x-input-label>
                    <span>Email Port</span>
                    <x-text-input wire:model="email_port" 
                        placeholder="Email Port" 
                        type="text" 
                        name="email_port" 
                        :error="$errors->has('email_port')" />
                    <x-input-error :messages="$errors->get('email_port')" />
                </x-input-label>

                <x-input-label>
                    <span>Email Username</span>
                    <x-text-input wire:model="email_username" 
                        placeholder="Email Username" 
                        type="text" 
                        name="email_username" 
                        :error="$errors->has('email_username')" />
                    <x-input-error :messages="$errors->get('email_username')" />
                </x-input-label>

                <x-input-label>
                    <span>Email Password</span>
                    <x-text-input wire:model="email_password" 
                        placeholder="Email Password" 
                        type="text" 
                        name="email_password" 
                        :error="$errors->has('email_password')" />
                    <x-input-error :messages="$errors->get('email_password')" />
                </x-input-label>

                <div>
                    <x-primary-button>
                        Save
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
   
    <x-success-modal 
        trigger="email-server-updated" 
        title="Email Server Updated Successfully" 
        message="Your email server settings have been updated." 
    />
</div>
