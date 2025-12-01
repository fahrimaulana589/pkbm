<?php

use App\Models\NewsCategory;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, mount};

state([
    'nama_kategori' => '',
    'slug' => '',
]);

rules([
    'nama_kategori' => 'required|string|max:255',
    'slug' => 'required|string|max:255|unique:news_categories,slug',
]);

// Auto-generate slug when nama_kategori changes
$updatedNamaKategori = function () {
    $this->slug = Str::slug($this->nama_kategori);
};

$save = function () {
    $this->validate();

    NewsCategory::create([
        'nama_kategori' => $this->nama_kategori,
        'slug' => $this->slug,
    ]);

    session()->flash('status', 'Kategori berhasil dibuat');
    session()->flash('message', 'Data kategori berhasil ditambahkan.');
    return $this->redirectRoute('admin.kategori-berita.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Kategori
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi kategori berita baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Kategori</span>
                        <x-text-input wire:model.live="nama_kategori" placeholder="Contoh: Kegiatan" type="text"
                            :error="$errors->has('nama_kategori')" />
                        <x-input-error :messages="$errors->get('nama_kategori')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Slug</span>
                        <x-text-input wire:model="slug" placeholder="Contoh: kegiatan" type="text"
                            :error="$errors->has('slug')" />
                        <x-input-error :messages="$errors->get('slug')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Kategori
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>