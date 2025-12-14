<?php

use App\Models\InfoPpdb;
use function Livewire\Volt\{state, computed, uses};
use Livewire\WithPagination;

uses([WithPagination::class]);

state('search', '');

$infos = computed(function () {
    return InfoPpdb::with('penulis')
        ->where('judul', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(9);
});

$getDateDisplay = fn($date) => !$date ? '-' : \Carbon\Carbon::parse($date)->format('d F Y');

?>

<div>
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
                <div class="bg-slate-50 rounded-lg p-8 inline-block">
                    <p class="text-slate-500">Belum ada informasi PPDB terbaru.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $this->infos->links() }}
    </div>
</div>