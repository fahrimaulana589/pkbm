<?php
use function Laravel\Folio\{name,render,middleware};
use Illuminate\View\View;

name('profile.edit');

render(function (View $view) {
    $user = auth()->user();
    return $view->with('user', $user);
});

?>
<x-app-layout title="Profile" is-sidebar-open="true" is-header-blur="true">
    <main class="main-content w-full px-[var(--margin-x)] pb-8">
        <div class="flex items-center space-x-4 py-5 lg:py-6">
          <h2
            class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl"
          >
            Profile
          </h2>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            @livewire('update-profile-information-form', ['user' => $user])
            @livewire('update-password-form', ['user' => $user])
            @livewire('delete-user-form',['user'=>$user])
        </div> 
    </main>
</x-app-layout>
