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
    'newPhotos' => [],
]);

rules([
    'judul' => 'required|string|max:255',
    'kategori' => 'required|in:kegiatan,fasilitas,event',
    'deskripsi' => 'required|string',
    'tanggal' => 'required|date',
    'status' => 'required|in:aktif,arsip',
    'newPhotos.*' => 'image|max:2048', // 2MB Max per photo
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

    foreach ($this->newPhotos as $photo) {
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

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6" x-data="{
        files: [],
        uploading: false,
        progress: 0,
        addFiles(e) {
            let selected = Array.from(e.files);
            selected.forEach(file => {
                if (file.size > 2097152) { // 2MB
                    alert('File ' + file.name + ' terlalu besar (>2MB).');
                    return;
                }
                file.preview = URL.createObjectURL(file);
                this.files.push(file);
            });
            e.value = '';
        },
        removeFile(index) {
            URL.revokeObjectURL(this.files[index].preview);
            this.files.splice(index, 1);
        },
        submitGallery() {
            if (this.files.length === 0) {
                @this.call('save');
                return;
            }

            this.uploading = true;
            @this.uploadMultiple(
                'newPhotos',
                this.files,
                () => { // Success
                    this.uploading = false;
                    @this.call('save');
                },
                () => { // Error
                    this.uploading = false;
                    alert('Gagal mengupload foto. Silakan coba lagi.');
                },
                (event) => { // Progress
                    this.progress = event.detail.progress;
                }
            );
        }
    }">
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
                        <div class="filepond fp-bordered fp-grid gap-2 [--fp-grid:2] dark:bg-navy-700">
                            <input type="file" multiple accept="image/*" @change="addFiles($event.target)"
                                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        </div>
                        <x-input-error :messages="$errors->get('newPhotos')" />
                        @foreach($errors->get('newPhotos.*') as $messages)
                            @foreach($messages as $message)
                                <span class="text-tiny+ text-error">{{ $message }}</span>
                            @endforeach
                        @endforeach

                        <!-- Progress Bar -->
                        <div x-show="uploading" class="mt-2 w-full bg-slate-200 rounded-full h-2.5 dark:bg-navy-600">
                            <div class="bg-primary h-2.5 rounded-full" :style="'width: ' + progress + '%'"></div>
                        </div>
                        <div x-show="uploading" class="text-xs text-slate-500 mt-1"
                            x-text="'Uploading... ' + progress + '%'"></div>

                        
                    </x-input-label>
                    <!-- Previews -->
                        <div class="mt-2 grid grid-cols-3 gap-4" x-show="files.length > 0">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="relative group rounded-lg border border-slate-200 p-1 dark:border-navy-500">
                                    <img :src="file.preview" class="h-24 w-full rounded-lg object-cover">
                                    <button @click="removeFile(index)" type="button"
                                        class="absolute top-0 right-0 m-1 bg-red-500 text-white p-1 rounded-full shadow-sm hover:bg-red-600 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
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
                    <x-primary-button @click="submitGallery" type="button" ::disabled="uploading">
                        <span x-show="!uploading">Simpan Galeri</span>
                        <span x-show="uploading">Menyimpan...</span>
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>