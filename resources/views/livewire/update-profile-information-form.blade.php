<?php

use function Livewire\Volt\{state,rules,mount};

state('user');
state('name');
state('email');
state('is_must_verified');
state('is_new_email_verified');
state('count',1);

mount(function ($user) {
    $this->name = $user->name;
    $this->email = $user->email;
    $this->is_must_verified = false;
    $this->is_new_email_verified = true;

    $this->user = auth()->user();
});

rules(fn() => [
    'name'  => 'required|string|max:255',
    'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $this->user->id,
]);

$submit = function () {
    $this->validate();

    if (($this->email !== $this->user->email)) {
      $this->is_must_verified = true;
      $this->is_new_email_verified = false;
      // Here you can add logic to send a verification email if needed
      $this->addError('email', 'You need to verify your new email address.');
    }else{
      $this->user->fill([
              'name'  => $this->name,
              'email' => $this->email,
          ])->save();
          $this->dispatch('profile-updated');
    }
};

$verification_email = function () {
  
  $temp_user = clone $this->user;

  $url = URL::temporarySignedRoute(
      'verification.verify.new-email',
      now()->addMinutes(60),
      [
        'id' => $this->user->id,
        'data' => $this->email,
        'hash' => sha1($this->email)
      ]
  );

  $notification = new class($url) extends \Illuminate\Auth\Notifications\VerifyEmail {
    private $url;
    public function __construct($url) { $this->url = $url; }
    protected function verificationUrl($notifiable) { return $this->url; }
  };

  \Illuminate\Support\Facades\Notification::send($temp_user, $notification);

  $this->resetErrorBag('email');
  $this->addError('email', 'Verification email sent to your new address.');
};

$is_email_verified = function () {
  if(!$this->is_new_email_verified && auth()->user()->email == $this->email){
    $this->is_new_email_verified = true;
    $this->is_must_verified = false;
    $this->resetErrorBag();
    $this->dispatch('profile-updated');
  }
};

?>

<div>
    <!-- Basic Input Text -->
    <div class="card px-4 pb-4 sm:px-5">
        <div wire:poll.1s="is_email_verified">
          
        </div>
    
        <div class="my-3 flex h-8 items-center justify-between">
            <h2
            class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base"
            >
            {{ __('Profile Information') }}
            </h2>
        </div>

        <div class="max-w-xl">
            <p>
            {{ __("Update your account's profile information and email address.") }}
            </p>
            <form method="post" wire:submit.prevent="submit" class="mt-5 flex flex-col gap-4">
                <x-input-label>
                    <span>Name</span>
                    <x-text-input wire:model="name" 
                        placeholder="Name" 
                        type="text" 
                        name="name" 
                        :error="$errors->has('name')" />
                    <x-input-error :messages="$errors->get('name')" />
                </x-input-label>

                <x-input-label>
                    <span>Email</span>
                    <x-text-input wire:model="email" 
                        placeholder="Email" 
                        type="text" 
                        name="email" 
                        :error="$errors->has('email')" />
                    <x-input-error :messages="$errors->get('email')" />
                </x-input-label>

                <div>
                    <x-primary-button>
                        Save
                    </x-primary-button>
                    
                    @if ($this->is_must_verified)
                        <x-secondary-button wire:click="verification_email" class="ml-2">
                            Verification email sent
                        </x-secondary-button>
                    @endif
                </div>
            </form>
        </div>
    </div>
   
    <x-success-modal 
        trigger="profile-updated" 
        title="Profile Updated Successfully" 
        message="Your profile information has been updated." 
    />
</div>

