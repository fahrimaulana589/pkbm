<?php

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, rules, mount, uses};

uses(WithFileUploads::class);

state([
    'kategori_id' => '',
    'judul' => '',
    'slug' => '',
    'konten' => '',
    'gambar' => null,
    'status' => 'draft',
    'selected_tags' => [],
    'categories' => [],
    'tags' => [],
]);

mount(function () {
    $this->categories = NewsCategory::all();
    $this->tags = NewsTag::all();
    if ($this->categories->isNotEmpty()) {
        $this->kategori_id = $this->categories->first()->id;
    }
});

rules([
    'kategori_id' => 'required|exists:news_categories,id',
    'judul' => 'required|string|max:255',
    'slug' => 'required|string|max:255|unique:news,slug',
    'konten' => 'required|string',
    'gambar' => 'nullable|image|max:2048', // 2MB Max
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

    $gambarPath = null;
    if ($this->gambar) {
        $gambarPath = $this->gambar->store('news', 'public');
    }

    $news = News::create([
        'kategori_id' => $this->kategori_id,
        'judul' => $this->judul,
        'slug' => $this->slug,
        'konten' => $this->konten,
        'gambar' => $gambarPath,
        'status' => $this->status,
    ]);

    if (!empty($this->selected_tags)) {
        $news->tags()->attach($this->selected_tags);
    }

    session()->flash('status', 'Berita berhasil dibuat');
    session()->flash('message', 'Data berita berhasil ditambahkan.');
    return $this->redirectRoute('admin.berita.index', navigate: true);
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
                                <img src="{{ $gambar->temporaryUrl() }}" alt="Preview"
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
                        Simpan Berita
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>