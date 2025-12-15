<?php

use Livewire\Volt\Component;
use App\Models\Setting;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;

    public $ppdb_foto;
    public $existing_ppdb_foto;
    public $ppdb_sambutan;
    public $ppdb_alur;

    public function mount()
    {
        $setting = Setting::first();
        if ($setting) {
            $this->existing_ppdb_foto = $setting->ppdb_foto;
            $this->ppdb_sambutan = $setting->ppdb_sambutan;
            $this->ppdb_alur = $setting->ppdb_alur;
        }
    }

    public function save()
    {
        $this->validate([
            'ppdb_foto' => 'nullable|image|max:2048', // 2MB Max
            'ppdb_sambutan' => 'nullable|string',
            'ppdb_alur' => 'nullable|string',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'email_server' => 'smtp.mailtrap.io',
                'email_port' => '2525',
                'email_username' => 'user',
                'email_password' => 'pass',
            ]);
        }

        $data = [
            'ppdb_sambutan' => $this->ppdb_sambutan,
            'ppdb_alur' => $this->ppdb_alur,
        ];

        if ($this->ppdb_foto) {
            if ($this->existing_ppdb_foto) {
                Storage::disk('public')->delete($this->existing_ppdb_foto);
            }
            $data['ppdb_foto'] = $this->ppdb_foto->store('settings', 'public');
            $this->existing_ppdb_foto = $data['ppdb_foto'];
            $this->reset(['ppdb_foto']);
        }

        $setting->update($data);

        $this->dispatch('setting-updated');
    }
}; ?>

<div>
    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        {{-- Main Content (8 cols) --}}
        <div class="col-span-12 lg:col-span-8">
            {{-- Sambutan Section --}}
            <div class="card px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Sambutan PPDB
                    </h2>
                </div>
                <div class="max-w-xl">
                    <p class="mb-4">
                        Pesan sambutan yang akan muncul di halaman depan PPDB.
                    </p>
                    <div class="flex flex-col gap-4">
                        <x-input-label>
                            <span>Kata Sambutan</span>
                            <x-textarea-input wire:model="ppdb_sambutan" rows="8"
                                placeholder="Tuliskan kata sambutan di sini..."
                                :error="$errors->has('ppdb_sambutan')"></x-textarea-input>
                            <x-input-error :messages="$errors->get('ppdb_sambutan')" />
                        </x-input-label>
                    </div>
                </div>
            </div>

            {{-- Alur Section --}}
            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Alur Pendaftaran
                    </h2>
                </div>
                <div class="max-w-xl">
                    <p class="mb-4">
                        Penjelasan mengenai langkah-langkah atau alur pendaftaran siswa baru.
                    </p>
                    <div class="flex flex-col gap-4">
                        <x-input-label>
                            <span>Informasi Alur</span>
                            <x-textarea-input wire:model="ppdb_alur" rows="8" placeholder="Jelaskan alur pendaftaran..."
                                :error="$errors->has('ppdb_alur')"></x-textarea-input>
                            <x-input-error :messages="$errors->get('ppdb_alur')" />
                        </x-input-label>
                    </div>
                    <div class="mt-5">
                        <x-primary-button wire:click="save">
                            Simpan Pengaturan
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Side Content (4 cols) --}}
        <div class="col-span-12 lg:col-span-4">
            {{-- Foto Section --}}
            <div class="card px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Foto Sambutan
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="flex flex-col gap-4">
                        <x-input-label>
                            <span>Upload Foto</span>
                            @if($existing_ppdb_foto)
                                <div class="mt-2 text-center">
                                    <div
                                        class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ Storage::url($existing_ppdb_foto) }}" alt="Foto PPDB"
                                            class="h-32 w-auto object-contain">
                                    </div>
                                    <p class="text-xs text-slate-500">Foto Saat Ini</p>
                                </div>
                            @endif

                            <div class="relative mt-2">
                                <x-text-input wire:model="ppdb_foto" type="file" accept="image/*"
                                    :error="$errors->has('ppdb_foto')" />
                                <div wire:loading wire:target="ppdb_foto" class="absolute right-3 top-2.5">
                                    <div
                                        class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('ppdb_foto')" />
                            <span class="text-xs text-slate-400">Max 2MB. Format: PNG, JPG, JPEG.</span>

                            @if ($ppdb_foto && method_exists($ppdb_foto, 'temporaryUrl'))
                                <div class="grid mt-2">
                                    <div
                                        class="flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ $ppdb_foto->temporaryUrl() }}" alt="Preview"
                                            class="h-32 w-auto object-contain">
                                    </div>
                                    <p class="text-xs text-center text-slate-500 mt-1">Preview Baru</p>
                                </div>
                            @endif
                        </x-input-label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="setting-updated" message="Pengaturan PPDB berhasil disimpan." />
</div>