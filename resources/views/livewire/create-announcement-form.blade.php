<?php

use App\Models\Announcement;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, rules, uses};

uses(WithFileUploads::class);

state([
    'judul' => '',
    'isi' => '',
    'kategori' => 'Umum',
    'prioritas' => 'Normal',
    'status' => 'draft',
    'start_date' => '',
    'end_date' => '',
    'published_at' => '',
    'lampiran_file' => null,
    'thumbnail' => null,
]);

rules([
    'judul' => 'required|string|max:255|unique:announcements,judul',
    'isi' => 'required|string',
    'kategori' => 'required|in:Umum,Akademik,Kesiswaan,Kepegawaian,Kegiatan,Darurat',
    'prioritas' => 'required|in:Normal,Penting,Tinggi',
    'status' => 'required|in:draft,dipublikasikan,terjadwal,kadaluarsa',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'published_at' => 'required|date',
    'lampiran_file' => 'required|file|max:10240', // Max 10MB
    'thumbnail' => 'required|image|max:2048', // Max 2MB
]);


$save = function () {
    $this->validate();

    $lampiranPath = $this->lampiran_file ? $this->lampiran_file->store('announcements/attachments', 'public') : null;
    $thumbnailPath = $this->thumbnail ? $this->thumbnail->store('announcements/thumbnails', 'public') : null;

    Announcement::create([
        'judul' => $this->judul,
        'slug' => Str::slug($this->judul),
        'isi' => $this->isi,
        'kategori' => $this->kategori,
        'prioritas' => $this->prioritas,
        'status' => $this->status,
        'start_date' => $this->start_date ?: null,
        'end_date' => $this->end_date ?: null,
        'published_at' => $this->published_at ?: null,
        'lampiran_file' => $lampiranPath,
        'thumbnail' => $thumbnailPath,
        'penulis_id' => auth()->id(),
    ]);

    session()->flash('status', 'Pengumuman berhasil dibuat');
    session()->flash('message', 'Pengumuman berhasil ditambahkan.');
    return $this->redirectRoute('admin.pengumuman', navigate: true);
};
?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Pengumuman
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail pengumuman yang akan ditampilkan kepada pengguna.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Judul</span>
                        <x-text-input wire:model="judul" placeholder="Masukkan judul pengumuman" type="text"
                            :error="$errors->has('judul')" />
                        <x-input-error :messages="$errors->get('judul')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Isi Pengumuman</span>
                        <x-textarea-input wire:model="isi" rows="6" placeholder="Tulis isi pengumuman disini..."
                            :error="$errors->has('isi')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('isi')" />
                    </x-input-label>

                    {{-- Thumbnail Upload --}}
                    <x-input-label>
                        <span>Thumbnail (Opsional)</span>
                        <div class="relative">
                            <x-text-input wire:model="thumbnail" type="file" accept="image/*"
                                :error="$errors->has('thumbnail')" />
                            <div wire:loading wire:target="thumbnail" class="absolute right-3 top-2.5">
                                <div
                                    class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('thumbnail')" />
                        <span class="text-xs text-slate-400">Max 2MB. Format: JPG, PNG, JPEG.</span>
                        @if ($thumbnail && method_exists($thumbnail, 'temporaryUrl'))
                            <div class="grid grid-cols-3">
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500 relative">
                                <img src="{{ $thumbnail->temporaryUrl() }}" alt="Preview"
                                    class="h-48 w-full rounded-lg object-cover">
                            </div>
                            </div>
                        @endif
                    </x-input-label>

                    {{-- Lampiran File Upload --}}
                    <x-input-label>
                        <span>Lampiran File (Opsional)</span>
                        <x-text-input wire:model="lampiran_file" type="file" :error="$errors->has('lampiran_file')" />
                        <x-input-error :messages="$errors->get('lampiran_file')" />
                        <span class="text-xs text-slate-400">Max 10MB.</span>
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan Publikasi
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Kategori</span>
                        <x-select-input wire:model="kategori" :error="$errors->has('kategori')">
                            <option value="Umum">Umum</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Kesiswaan">Kesiswaan</option>
                            <option value="Kepegawaian">Kepegawaian</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Darurat">Darurat</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('kategori')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Prioritas</span>
                        <x-select-input wire:model="prioritas" :error="$errors->has('prioritas')">
                            <option value="Normal">Normal</option>
                            <option value="Penting">Penting</option>
                            <option value="Tinggi">Tinggi</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('prioritas')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="draft">Draft</option>
                            <option value="dipublikasikan">Dipublikasikan</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="kadaluarsa">Kadaluarsa</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tanggal Publikasi</span>
                        <x-text-input wire:model="published_at" type="datetime-local"
                            :error="$errors->has('published_at')" />
                        <x-input-error :messages="$errors->get('published_at')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tanggal Mulai</span>
                        <x-text-input wire:model="start_date" type="date" :error="$errors->has('start_date')" />
                        <x-input-error :messages="$errors->get('start_date')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tanggal Akhir</span>
                        <x-text-input wire:model="end_date" type="date" :error="$errors->has('end_date')" />
                        <x-input-error :messages="$errors->get('end_date')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Pengumuman
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>