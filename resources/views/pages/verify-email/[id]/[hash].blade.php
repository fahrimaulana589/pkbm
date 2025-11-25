<?php
use function Laravel\Folio\{name,render,middleware};
use Illuminate\View\View;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

name('verification.verify');
middleware(['signed','throttle:6,1']);

render(function (View $view) {

    $user = User::findOrFail($view->id);

    if ($user && $user->hasVerifiedEmail()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

    return $view->with('status', 'verified');    
});


