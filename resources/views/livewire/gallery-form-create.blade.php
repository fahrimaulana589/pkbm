<?php

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, rules, mount, uses};

uses(WithFileUploads::class);

state([
    'judul' => '',
    'kategori' => 'kegiatan',
    'deskripsi' => '',
    'tanggal' => date('Y-m-d'),
    'status' => 'aktif',
    'photos' => [],
]);

rules([
    'judul' => 'required|string|max:255',
    'kategori' => 'required|in:kegiatan,fasilitas,event',
    'deskripsi' => 'required|string',
    'tanggal' => 'required|date',
    'status' => 'required|in:aktif,arsip',
    'photos.*' => 'image|max:2048', // 2MB Max per photo
]);

$save = function () {
    $this->validate();

    $gallery = Gallery::create([
        'judul' => $this->judul,
        'kategori' => $this->kategori,
        'deskripsi' => $this->deskripsi,
        'tanggal' => $this->tanggal,
        'status' => $this->status,
    ]);

    foreach ($this->photos as $photo) {
        $path = $photo->store('gallery/' . $gallery->id, 'public');
        GalleryPhoto::create([
            'gallery_id' => $gallery->id,
            'file_path' => $path,
            'caption' => '',
            'urutan' => 0,
        ]);
    }

    session()->flash('status', 'Galeri berhasil dibuat');
    session()->flash('message', 'Data galeri berhasil ditambahkan.');
    return $this->redirectRoute('admin.galeri.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Konten Galeri
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Judul Galeri</span>
                        <x-text-input wire:model="judul" placeholder="Contoh: Kegiatan Outbound 2024" type="text"
                            :error="$errors->has('judul')" />
                        <x-input-error :messages="$errors->get('judul')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Deskripsi</span>
                        <x-textarea-input wire:model="deskripsi" placeholder="Deskripsi kegiatan..." rows="5"
                            :error="$errors->has('deskripsi')" />
                        <x-input-error :messages="$errors->get('deskripsi')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Foto Galeri</span>
                        <div
                            class="filepond fp-bordered fp-grid gap-2 [--fp-grid:2] dark:bg-navy-700">
                            <input type="file" wire:model="photos" multiple accept="image/*"
                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        </div>
                        <x-input-error :messages="$errors->get('photos')" />
                        <x-input-error :messages="$errors->get('photos.*')" />
                        
                        <div wire:loading wire:target="photos" class="mt-2 text-xs text-slate-500">Uploading...</div>

                        @if ($photos)
                            <div class="mt-4 grid grid-cols-3 gap-4">
                                @foreach ($photos as $photo)
                                    @if(method_exists($photo, 'temporaryUrl'))
                                        <div class="relative">
                                            <img src="{{ $photo->temporaryUrl() }}" class="h-24 w-full rounded-lg object-cover">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Kategori</span>
                        <x-select-input wire:model="kategori" :error="$errors->has('kategori')">
                            <option value="kegiatan">Kegiatan</option>
                            <option value="fasilitas">Fasilitas</option>
                            <option value="event">Event</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('kategori')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tanggal</span>
                        <x-text-input wire:model="tanggal" type="date" :error="$errors->has('tanggal')" />
                        <x-input-error :messages="$errors->get('tanggal')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="aktif">Aktif</option>
                            <option value="arsip">Arsip</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" />
                    </x-input-label>

                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Galeri
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>