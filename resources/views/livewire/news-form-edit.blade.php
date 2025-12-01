<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use function Livewire\Volt\{state, rules, mount, uses};

uses(WithFileUploads::class);

state([
    'news' => null,
    'kategori_id' => '',
    'judul' => '',
    'slug' => '',
    'konten' => '',
    'gambar' => null, // New upload
    'existing_gambar' => null, // Existing path
    'status' => 'draft',
    'selected_tags' => [],
    'categories' => [],
    'tags' => [],
]);

mount(function ($id) {
    $this->news = News::with('tags')->findOrFail($id);
    $this->categories = NewsCategory::all();
    $this->tags = NewsTag::all();

    $this->kategori_id = $this->news->kategori_id;
    $this->judul = $this->news->judul;
    $this->slug = $this->news->slug;
    $this->konten = $this->news->konten;
    $this->existing_gambar = $this->news->gambar;
    $this->status = $this->news->status;
    $this->selected_tags = $this->news->tags->pluck('id')->toArray();
});

rules([
    'kategori_id' => 'required|exists:news_categories,id',
    'judul' => 'required|string|max:255',
    'slug' => 'required|string|max:255', // Unique check manual
    'konten' => 'required|string',
    'gambar' => 'nullable|image|max:2048',
    'status' => 'required|in:draft,published',
    'selected_tags' => 'array',
    'selected_tags.*' => 'exists:news_tags,id',
]);

// Auto-generate slug when judul changes
$updatedJudul = function () {
    $this->slug = Str::slug($this->judul);
};

$save = function () {
    $this->validate();

    // Check uniqueness excluding current record
    $exists = News::where('slug', $this->slug)
        ->where('id', '!=', $this->news->id)
        ->exists();

    if ($exists) {
        $this->addError('slug', 'Slug sudah digunakan.');
        return;
    }

    $gambarPath = $this->existing_gambar;
    if ($this->gambar) {
        // Delete old image if exists
        if ($this->existing_gambar && Storage::disk('public')->exists($this->existing_gambar)) {
            Storage::disk('public')->delete($this->existing_gambar);
        }
        $gambarPath = $this->gambar->store('news', 'public');
    }

    $this->news->update([
        'kategori_id' => $this->kategori_id,
        'judul' => $this->judul,
        'slug' => $this->slug,
        'konten' => $this->konten,
        'gambar' => $gambarPath,
        'status' => $this->status,
    ]);

    $this->news->tags()->sync($this->selected_tags);

    $this->dispatch('news-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Konten Berita
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Judul Berita</span>
                        <x-text-input wire:model.live="judul" placeholder="Contoh: Kegiatan Workshop Tutor" type="text"
                            :error="$errors->has('judul')" />
                        <x-input-error :messages="$errors->get('judul')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Slug</span>
                        <x-text-input wire:model="slug" placeholder="Contoh: kegiatan-workshop-tutor" type="text"
                            :error="$errors->has('slug')" />
                        <x-input-error :messages="$errors->get('slug')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Konten</span>
                        <x-textarea-input wire:model="konten" placeholder="Isi berita..." rows="10"
                            :error="$errors->has('konten')" />
                        <x-input-error :messages="$errors->get('konten')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan & Media
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Kategori</span>
                        <x-select-input wire:model="kategori_id" :error="$errors->has('kategori_id')">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('kategori_id')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Gambar Utama</span>
                        <input type="file" wire:model="gambar"
                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                        <x-input-error :messages="$errors->get('gambar')" />
                        @if ($gambar)
                            <div class="mt-2">
                                <p class="text-xs text-slate-500">Preview Baru:</p>
                                <img src="{{ $gambar->temporaryUrl() }}" alt="Preview"
                                    class="h-32 w-auto rounded-lg object-cover">
                            </div>
                        @elseif($existing_gambar)
                            <div class="mt-2">
                                <p class="text-xs text-slate-500">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $existing_gambar) }}" alt="Current"
                                    class="h-32 w-auto rounded-lg object-cover">
                            </div>
                        @endif
                    </x-input-label>

                    <div>
                        <span class="font-medium text-slate-600 dark:text-navy-100">Tags</span>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" wire:model="selected_tags" value="{{ $tag->id }}"
                                        class="form-checkbox is-basic size-4 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent" />
                                    <span>{{ $tag->nama_tag }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('selected_tags')" />
                    </div>

                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="news-updated" message="Data berita berhasil diperbarui." />
</div>