<?php

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, rules, mount, uses};

uses(WithFileUploads::class);

state([
    'gallery' => null,
    'judul' => '',
    'kategori' => '',
    'deskripsi' => '',
    'tanggal' => '',
    'status' => '',
    'new_photos' => [],
    'existing_photos' => [],
    'photo_captions' => [],
]);

mount(function ($id) {
    $this->gallery = Gallery::with('photos')->findOrFail($id);
    $this->judul = $this->gallery->judul;
    $this->kategori = $this->gallery->kategori;
    $this->deskripsi = $this->gallery->deskripsi;
    $this->tanggal = $this->gallery->tanggal->format('Y-m-d');
    $this->status = $this->gallery->status;
    $this->existing_photos = $this->gallery->photos;

    foreach ($this->existing_photos as $photo) {
        $this->photo_captions[$photo->id] = $photo->caption;
    }
});

rules([
    'judul' => 'required|string|max:255',
    'kategori' => 'required|in:kegiatan,fasilitas,event',
    'deskripsi' => 'required|string',
    'tanggal' => 'required|date',
    'status' => 'required|in:aktif,arsip',
    'new_photos.*' => 'image|max:2048',
    'photo_captions.*' => 'nullable|string|max:255',
]);

$save = function () {
    $this->validate();

    $this->gallery->update([
        'judul' => $this->judul,
        'kategori' => $this->kategori,
        'deskripsi' => $this->deskripsi,
        'tanggal' => $this->tanggal,
        'status' => $this->status,
    ]);

    // Update captions
    foreach ($this->photo_captions as $id => $caption) {
        if ($photo = GalleryPhoto::find($id)) {
            $photo->update(['caption' => $caption]);
        }
    }

    // Add new photos
    foreach ($this->new_photos as $photo) {
        $path = $photo->store('gallery/' . $this->gallery->id, 'public');
        GalleryPhoto::create([
            'gallery_id' => $this->gallery->id,
            'file_path' => $path,
            'caption' => '',
            'urutan' => 0,
        ]);
    }

    // Refresh photos
    $this->existing_photos = $this->gallery->photos()->get();
    $this->new_photos = [];
    foreach ($this->existing_photos as $photo) {
        $this->photo_captions[$photo->id] = $photo->caption;
    }

    session()->flash('status', 'Galeri berhasil diperbarui');
    session()->flash('message', 'Data galeri berhasil diperbarui.');
};

$deletePhoto = function ($photoId) {
    $photo = GalleryPhoto::find($photoId);
    if ($photo) {
        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }
        $photo->delete();

        $this->existing_photos = $this->gallery->photos()->get();
        unset($this->photo_captions[$photoId]);
    }
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

                    <div class="mt-4">
                        <h3 class="font-medium text-slate-700 dark:text-navy-100 mb-2">Foto Galeri</h3>

                        <!-- Existing Photos -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            @foreach ($existing_photos as $photo)
                                <div class="relative group border rounded-lg p-2 dark:border-navy-500">
                                    <img src="{{ Storage::url($photo->file_path) }}"
                                        class="h-32 w-full object-cover rounded-lg mb-2">
                                    <x-text-input wire:model="photo_captions.{{ $photo->id }}" placeholder="Caption..."
                                        class="w-full text-sm" />
                                    <button wire:click="deletePhoto('{{ $photo->id }}')"
                                        class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                        onclick="confirm('Hapus foto ini?') || event.stopImmediatePropagation()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>

                        <x-input-label>
                            <span>Tambah Foto Baru</span>
                            <input type="file" wire:model="new_photos" multiple accept="image/*"
                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                            <x-input-error :messages="$errors->get('new_photos')" />
                            <x-input-error :messages="$errors->get('new_photos.*')" />

                            <div wire:loading wire:target="new_photos" class="mt-2 text-xs text-slate-500">Uploading...
                            </div>

                            @if ($new_photos)
                                <div class="mt-4 grid grid-cols-3 gap-4">
                                    @foreach ($new_photos as $photo)
                                        @if(method_exists($photo, 'temporaryUrl'))
                                            <div class="relative rounded-lg border border-slate-200 p-1 dark:border-navy-500">
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
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>