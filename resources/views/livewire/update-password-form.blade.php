<?php

use function Livewire\Volt\{state,rules};

state('user');
state('current_password');
state('new_password');
state('new_password_confirmation');

rules(fn() => [
    'current_password' => 'required|string|current_password',
    'new_password'              => 'required|string|min:8|confirmed',
    'new_password_confirmation' => 'required|string|min:8',
]);

$submit = function () {
    $this->validate();

    // Update the user's password
    $this->user->password = bcrypt($this->new_password);
    $this->user->save();

    $this->dispatch('profile-updated-password');
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Update Password') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Ensure your account is using a long, random password to stay secure.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
                <x-input-label>
                    <span>Current Password</span>
                    <x-text-input wire:model="current_password" 
                        placeholder="Current Password" 
                        type="password" 
                        name="current_password" 
                        :error="$errors->has('current_password')" />
                    <x-input-error :messages="$errors->get('current_password')" />
                </x-input-label>

                <x-input-label>
                    <span>New Password</span>
                    <x-text-input wire:model="new_password" 
                        placeholder="New Password" 
                        type="password" 
                        name="new_password" 
                        :error="$errors->has('new_password')" />
                    <x-input-error :messages="$errors->get('new_password')" />
                </x-input-label>

                <x-input-label>
                    <span>Confirm New Password</span>
                    <x-text-input wire:model="new_password_confirmation" 
                        placeholder="Confirm New Password" 
                        type="password" 
                        name="new_password_confirmation" 
                        :error="$errors->has('new_password_confirmation')" />
                    <x-input-error :messages="$errors->get('new_password_confirmation')" />
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
        trigger="profile-updated-password" 
        title="Password Updated Successfully" 
        message="Your password has been updated." 
    />
</div>
