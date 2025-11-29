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

rules(fn () => [
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
                        <div 
                            x-data="{showModal:true}"
                            x-init="setTimeout(() => showModal = false, 3000)"
                        >
                            <template x-teleport="#x-teleport-target">
                                <div
                                    class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                    x-show="showModal"
                                    role="dialog"
                                    @keydown.window.escape="showModal = false"
                                >
                                    <div
                                        class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                        @click="showModal = false"
                                        x-show="showModal"
                                        x-transition:enter="ease-out"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                    ></div>
                                    <div
                                        class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
                                        x-show="showModal"
                                        x-transition:enter="ease-out"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="inline size-28 text-success"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                            ></path>
                                        </svg>

                                        <div class="mt-4">
                                            <h2 class="text-2xl text-slate-700 dark:text-navy-100">
                                            Berhasil
                                            </h2>
                                            <p class="mt-2">
                                            {{ session('message') }}
                                            </p>
                                            <button
                                            @click="showModal = false"
                                            class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
                                            >
                                            Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @endif
                    <label class="block">
                        <span>Judul</span>
                        <input wire:model="judul"
                            @error('judul')
                            class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"
                            @else
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror
                            placeholder="Masukkan judul pengumuman" type="text" />
                        @error('judul') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>
                    <label class="block">
                        <span>Isi Pengumuman</span>
                        <textarea wire:model="isi" rows="6"
                            @error('isi')
                            class="form-textarea mt-1.5 w-full rounded-lg border border-error bg-transparent p-2.5 placeholder:text-slate-400/70"
                            @else
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror
                            placeholder="Tulis isi pengumuman disini..."></textarea>
                        @error('isi') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    {{-- Thumbnail Upload --}}
                    <label class="block">
                        <span>Thumbnail (Opsional)</span>
                        @if($existing_thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $existing_thumbnail) }}" alt="Thumbnail" class="h-20 w-auto rounded border border-slate-200 object-cover dark:border-navy-500">
                            </div>
                        @endif
                        <input wire:model="new_thumbnail" type="file" accept="image/*"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        @error('new_thumbnail') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                        <span class="text-xs text-slate-400">Max 2MB. Format: JPG, PNG, JPEG.</span>
                    </label>

                    {{-- Lampiran File Upload --}}
                    <label class="block">
                        <span>Lampiran File (Opsional)</span>
                        @if($existing_lampiran_file)
                            <div class="mb-2 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <a href="{{ asset('storage/' . $existing_lampiran_file) }}" target="_blank" class="text-primary hover:underline dark:text-accent-light">Lihat Lampiran Saat Ini</a>
                            </div>
                        @endif
                        <input wire:model="new_lampiran_file" type="file"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        @error('new_lampiran_file') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                        <span class="text-xs text-slate-400">Max 10MB.</span>
                    </label>
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
                    <label class="block">
                        <span>Kategori</span>
                        <select wire:model="kategori"
                            @error('kategori')
                            class="form-select mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2"
                            @else
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror>
                            <option value="Umum">Umum</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Kesiswaan">Kesiswaan</option>
                            <option value="Kepegawaian">Kepegawaian</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Darurat">Darurat</option>
                        </select>
                        @error('kategori') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span>Prioritas</span>
                        <select wire:model="prioritas"
                            @error('prioritas')
                            class="form-select mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2"
                            @else
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror>
                            <option value="Normal">Normal</option>
                            <option value="Penting">Penting</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                        @error('prioritas') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span>Status</span>
                        <select wire:model="status"
                            @error('status')
                            class="form-select mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2"
                            @else
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror>
                            <option value="draft">Draft</option>
                            <option value="dipublikasikan">Dipublikasikan</option>
                            <option value="terjadwal">Terjadwal</option>
                            <option value="kadaluarsa">Kadaluarsa</option>
                        </select>
                        @error('status') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span>Tanggal Publikasi</span>
                        <input wire:model="published_at"
                            @error('published_at')
                            class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"
                            @else
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror
                            type="datetime-local" />
                        @error('published_at') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span>Tanggal Mulai</span>
                        <input wire:model="start_date"
                            @error('start_date')
                            class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"
                            @else
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror
                            type="date" />
                        @error('start_date') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span>Tanggal Akhir</span>
                        <input wire:model="end_date"
                            @error('end_date')
                            class="form-input mt-1.5 w-full rounded-lg border border-error bg-transparent px-3 py-2 placeholder:text-slate-400/70"
                            @else
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            @enderror
                            type="date" />
                        @error('end_date') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                    </label>
                </div>
                <div class="mt-5">
                    <button wire:click="save"
                        class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div 
        x-data="{showModal:false}"
        x-on:announcement-updated.window="showModal = true"
    >
    
    <template x-teleport="#x-teleport-target">
      <div
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-show="showModal"
        role="dialog"
        @keydown.window.escape="showModal = false"
      >
        <div
          class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
          @click="showModal = false"
          x-show="showModal"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        ></div>
        <div
          class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
          x-show="showModal"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="inline size-28 text-success"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
          </svg>

          <div class="mt-4">
            <h2 class="text-2xl text-slate-700 dark:text-navy-100">
              Pengumuman berhasil dihapus
            </h2>
            <p class="mt-2">
              Pengumuman ini telah dihapus.
            </p>
            <button
              @click="showModal = false"
              class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>
</div>
