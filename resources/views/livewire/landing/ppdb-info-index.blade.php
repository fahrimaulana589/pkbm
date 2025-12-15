<?php

use App\Models\InfoPpdb;
use App\Models\Ppdb;
use function Livewire\Volt\{state, computed, uses, mount};
use Livewire\WithPagination;

uses([WithPagination::class]);

state(['search' => '', 'activePpdb' => null]);

mount(function () {
    $this->activePpdb = Ppdb::where('status', 'open')->latest()->first();
});

$infos = computed(function () {
    return InfoPpdb::with('penulis')
        ->where('judul', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(9);
});

$getDateDisplay = fn($date) => !$date ? '-' : \Carbon\Carbon::parse($date)->format('d F Y');

?>

<div>
    @if($activePpdb)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($this->infos as $info)
                <div
                    class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center space-x-2 text-sm text-slate-500 mb-3">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $info->penulis->name ?? 'Admin' }}
                            </span>
                            <span>&bull;</span>
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $this->getDateDisplay($info->created_at) }}
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2 hover:text-primary transition-colors">
                            {{ $info->judul }}
                        </h3>
                        <p class="text-slate-600 mb-4 line-clamp-3">
                            {{ $info->deskripsi }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-navy-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Belum ada informasi</h3>
                    <p class="mt-2 text-slate-500 dark:text-slate-400">
                        Informasi PPDB terbaru belum tersedia saat ini.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $this->infos->links() }}
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-10 text-center">
            <div class="bg-warning/10 text-warning rounded-full p-3 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Pendaftaran Ditutup</h3>
            <p class="text-slate-500 mt-2">Saat ini tidak ada periode PPDB yang sedang aktif. Silakan kembali lagi nanti.
            </p>
        </div>
    @endif
</div>