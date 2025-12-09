<?php

use App\Models\Ppdb;
use function Livewire\Volt\{state, rules};

state([
    'name' => '',
    'tahun' => date('Y'),
    'status' => 'open',
    'start_date' => '',
    'end_date' => '',
]);

rules([
    'name' => 'required|string|max:255',
    'tahun' => 'required|integer|digits:4',
    'status' => 'required|in:open,closed',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
]);

$save = function () {
    $this->validate();

    Ppdb::create([
        'name' => $this->name,
        'tahun' => $this->tahun,
        'status' => $this->status,
        'start_date' => $this->start_date,
        'end_date' => $this->end_date,
    ]);

    session()->flash('message', 'Data PPDB berhasil ditambahkan.');
    return $this->redirectRoute('ppdb.ppdb', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi PPDB
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi PPDB baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama PPDB</span>
                        <x-text-input wire:model="name" placeholder="Masukkan nama PPDB" type="text"
                            :error="$errors->has('name')" />
                        <x-input-error :messages="$errors->get('name')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tahun</span>
                        <x-text-input wire:model="tahun" placeholder="Contoh: 2025" type="number"
                            :error="$errors->has('tahun')" />
                        <x-input-error :messages="$errors->get('tahun')" />
                    </x-input-label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Tanggal Mulai</span>
                            <x-text-input wire:model="start_date" type="date" :error="$errors->has('start_date')" />
                            <x-input-error :messages="$errors->get('start_date')" />
                        </x-input-label>
                        <x-input-label>
                            <span>Tanggal Selesai</span>
                            <x-text-input wire:model="end_date" type="date" :error="$errors->has('end_date')" />
                            <x-input-error :messages="$errors->get('end_date')" />
                        </x-input-label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan Tambahan
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Data
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>