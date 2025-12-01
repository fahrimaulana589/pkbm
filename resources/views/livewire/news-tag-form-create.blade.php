<?php

use App\Models\NewsTag;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, mount};

state([
    'nama_tag' => '',
    'slug' => '',
]);

rules([
    'nama_tag' => 'required|string|max:255',
    'slug' => 'required|string|max:255|unique:news_tags,slug',
]);

// Auto-generate slug when nama_tag changes
$updatedNamaTag = function () {
    $this->slug = Str::slug($this->nama_tag);
};

$save = function () {
    $this->validate();

    NewsTag::create([
        'nama_tag' => $this->nama_tag,
        'slug' => $this->slug,
    ]);

    session()->flash('status', 'Tag berhasil dibuat');
    session()->flash('message', 'Data tag berhasil ditambahkan.');
    return $this->redirectRoute('admin.tag-berita.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Tag
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi tag berita baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Tag</span>
                        <x-text-input wire:model.live="nama_tag" placeholder="Contoh: Workshop" type="text"
                            :error="$errors->has('nama_tag')" />
                        <x-input-error :messages="$errors->get('nama_tag')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Slug</span>
                        <x-text-input wire:model="slug" placeholder="Contoh: workshop" type="text"
                            :error="$errors->has('slug')" />
                        <x-input-error :messages="$errors->get('slug')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Tag
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>