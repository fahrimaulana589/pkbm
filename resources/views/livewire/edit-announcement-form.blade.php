<?php

use App\Models\Announcement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, rules, mount, save, uses};

uses(WithFileUploads::class);

state([
    'announcement' => null,
    'judul' => '',
    'isi' => '',
    'kategori' => '',
    'prioritas' => '',
    'status' => '',
    'start_date' => '',
    'end_date' => '',
    'published_at' => '',
    'new_lampiran_file' => null,
    'new_thumbnail' => null,
    'existing_lampiran_file' => null,
    'existing_thumbnail' => null,
]);

mount(function ($id) {
    $this->announcement = Announcement::findOrFail($id);
    $this->judul = $this->announcement->judul;
    $this->isi = $this->announcement->isi;
    $this->kategori = $this->announcement->kategori;
    $this->prioritas = $this->announcement->prioritas;
    $this->status = $this->announcement->status;
    $this->start_date = $this->announcement->start_date ? $this->announcement->start_date->format('Y-m-d') : '';
    $this->end_date = $this->announcement->end_date ? $this->announcement->end_date->format('Y-m-d') : '';
    $this->published_at = $this->announcement->published_at ? $this->announcement->published_at->format('Y-m-d\TH:i') : '';

    // Check if files physically exist
    $this->existing_lampiran_file = ($this->announcement->lampiran_file && Storage::disk('public')->exists($this->announcement->lampiran_file))
        ? $this->announcement->lampiran_file
        : null;

    $this->existing_thumbnail = ($this->announcement->thumbnail && Storage::disk('public')->exists($this->announcement->thumbnail))
        ? $this->announcement->thumbnail
        : null;
});

rules(fn() => [
    'judul' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('announcements', 'judul')->ignore($this->announcement->id)],
    'isi' => 'required|string',
    'kategori' => 'required|in:Umum,Akademik,Kesiswaan,Kepegawaian,Kegiatan,Darurat',
    'prioritas' => 'required|in:Normal,Penting,Tinggi',
    'status' => 'required|in:draft,dipublikasikan,terjadwal,kadaluarsa',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
    'published_at' => 'required|date',
    'new_lampiran_file' => [$this->existing_lampiran_file ? 'nullable' : 'required', 'file', 'max:10240'], // Max 10MB
    'new_thumbnail' => [$this->existing_thumbnail ? 'nullable' : 'required', 'image', 'max:2048'], // Max 2MB
]);

$save = function () {
    $this->validate();

    $data = [
        'judul' => $this->judul,
        'slug' => Str::slug($this->judul),
        'isi' => $this->isi,
        'kategori' => $this->kategori,
        'prioritas' => $this->prioritas,
        'status' => $this->status,
        'start_date' => $this->start_date ?: null,
        'end_date' => $this->end_date ?: null,
        'published_at' => $this->published_at ?: null,
    ];

    if ($this->new_lampiran_file) {
        if ($this->announcement->lampiran_file) {
            Storage::disk('public')->delete($this->announcement->lampiran_file);
        }
        $data['lampiran_file'] = $this->new_lampiran_file->store('announcements/attachments', 'public');
    }

    if ($this->new_thumbnail) {
        if ($this->announcement->thumbnail) {
            Storage::disk('public')->delete($this->announcement->thumbnail);
        }
        $data['thumbnail'] = $this->new_thumbnail->store('announcements/thumbnails', 'public');
    }

    $this->announcement->update($data);
    $this->dispatch('announcement-updated');
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
                    Perbarui detail pengumuman yang akan ditampilkan kepada pengguna.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    @if (session()->has('message'))
                        <div x-data="{showModal:true}" x-init="setTimeout(() => showModal = false, 3000)">
                            <template x-teleport="#x-teleport-target">
                                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                    x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                                    <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                        @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"></div>
                                    <div class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                                        x-show="showModal" x-transition:enter="ease-out"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="inline size-28 text-success"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>

                                        <div class="mt-4">
                                            <h2 class="text-2xl text-slate-700 dark:text-navy-100">
                                                Berhasil
                                            </h2>
                                            <p class="mt-2">
                                                {{ session('message') }}
                                            </p>
                                            <button @click="showModal = false"
                                                class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @endif
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
                        @if($existing_thumbnail)
                            <div
                                class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500 relative">
                                <div
                                    class="text-xs text-slate-500 absolute top-2 left-2 bg-white/80 dark:bg-navy-700/80 px-1 rounded">
                                    Thumbnail Saat Ini</div>
                                <img src="{{ asset('storage/' . $existing_thumbnail) }}" alt="Thumbnail"
                                    class="h-48 w-full rounded-lg object-cover">
                            </div>
                        @endif
                        <div class="relative">
                            <x-text-input wire:model="new_thumbnail" type="file" accept="image/*"
                                :error="$errors->has('new_thumbnail')" />
                            <div wire:loading wire:target="new_thumbnail" class="absolute right-3 top-2.5">
                                <div
                                    class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('new_thumbnail')" />
                        <span class="text-xs text-slate-400">Max 2MB. Format: JPG, PNG, JPEG.</span>
                        @if ($new_thumbnail && method_exists($new_thumbnail, 'temporaryUrl'))
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500 relative">
                                <div
                                    class="text-xs text-slate-500 absolute top-2 left-2 bg-white/80 dark:bg-navy-700/80 px-1 rounded">
                                    Preview Baru</div>
                                <img src="{{ $new_thumbnail->temporaryUrl() }}" alt="Preview"
                                    class="h-48 w-full rounded-lg object-cover">
                            </div>
                        @endif
                    </x-input-label>

                    {{-- Lampiran File Upload --}}
                    <x-input-label>
                        <span>Lampiran File (Opsional)</span>
                        @if($existing_lampiran_file)
                            <div class="mb-2 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <a href="{{ asset('storage/' . $existing_lampiran_file) }}" target="_blank"
                                    class="text-primary hover:underline dark:text-accent-light">Lihat Lampiran Saat Ini</a>
                            </div>
                        @endif
                        <x-text-input wire:model="new_lampiran_file" type="file"
                            :error="$errors->has('new_lampiran_file')" />
                        <x-input-error :messages="$errors->get('new_lampiran_file')" />
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
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="announcement-updated" message="Pengumuman berhasil diperbarui." />
</div>