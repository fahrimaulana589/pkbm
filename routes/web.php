<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

require __DIR__.'/auth.php';

Route::get('/test-email', function () {
    Mail::raw('Ini adalah email test dari Laravel.', function ($message) {
        $message->to('target@example.com')
                ->subject('Email Test Laravel');
    });

    return 'Email berhasil dikirim!';
});

// Route::get('/test-email', function () {
//     try {
//         Mail::raw('Test Mailtrap dari Laravel!', function ($msg) {
//             $msg->to('your-email@example.com')->subject('Mailtrap Test');
//         });

//         return 'Email terkirim (no exception thrown).';
//     } catch (\Throwable $e) {
//         // tampilkan pesan & stack trace agar kita tahu penyebabnya
//         return response()->json([
//             'error' => $e->getMessage(),
//             'class' => get_class($e),
//             'trace' => collect($e->getTrace())->map(function($t){ return Arr::only($t, ['file','line','function']); })->all()
//         ], 500);
//     }
// });
