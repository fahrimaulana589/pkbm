<?php

use App\Models\InfoPpdb;
use function Livewire\Volt\{state, rules};

state([
    'judul' => '',
    'deskripsi' => '',
]);

rules([
    'judul' => 'required|string|max:255',
    'deskripsi' => 'required|string',
]);

$save = function () {
    $this->validate();

    InfoPpdb::create([
        'judul' => $this->judul,
        'deskripsi' => $this->deskripsi,
        'penulis_id' => auth()->id(),
    ]);

    session()->flash('status', 'Berhasil');
    session()->flash('message', 'Info PPDB berhasil ditambahkan.');
    return $this->redirectRoute('ppdb.info.index', navigate: true);

};

?>

<div class="card px-4 pb-4 sm:px-5">
    <div class="my-3 flex h-8 items-center justify-between">
        <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
            Informasi Info PPDB
        </h2>
    </div>
    <div class="max-w-xl">
        <p>
            Isi detail Info PPDB yang akan ditampilkan kepada pengguna.
        </p>
        <div class="mt-5 flex flex-col gap-4">
            <x-input-label>
                <span>Judul</span>
                <x-text-input wire:model="judul" placeholder="Masukkan judul Info PPDB" type="text"
                    :error="$errors->has('judul')" />
                <x-input-error :messages="$errors->get('judul')" />
            </x-input-label>

            <x-input-label>
                <span>Deskripsi</span>
                <x-textarea-input wire:model="deskripsi" rows="6" placeholder="Tulis deskripsi Info PPDB disini..."
                    :error="$errors->has('deskripsi')">
                </x-textarea-input>
                <x-input-error :messages="$errors->get('deskripsi')" />
            </x-input-label>
        </div>
        <div class="mt-5">
            <x-primary-button wire:click="save">
                Simpan Info PPDB
            </x-primary-button>
        </div>
    </div>
</div>