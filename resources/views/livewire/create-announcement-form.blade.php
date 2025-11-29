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
                        <input wire:model="thumbnail" type="file" accept="image/*"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        @error('thumbnail') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
                        <span class="text-xs text-slate-400">Max 2MB. Format: JPG, PNG, JPEG.</span>
                    </label>

                    {{-- Lampiran File Upload --}}
                    <label class="block">
                        <span>Lampiran File (Opsional)</span>
                        <input wire:model="lampiran_file" type="file"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        @error('lampiran_file') <span class="text-tiny+ text-error">{{ $message }}</span> @enderror
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
                        Simpan Pengumuman
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
