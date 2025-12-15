<?php

use App\Models\Contact;
use function Livewire\Volt\{state, mount, rules, save};

state([
    'id' => null,
    'kategori' => '',
    'label' => '',
    'value' => '',
    'type' => 'text',
]);

mount(function ($id) {
    $contact = Contact::findOrFail($id);
    $this->id = $contact->id;
    $this->kategori = $contact->kategori;
    $this->label = $contact->label;
    $this->value = $contact->value;
    $this->type = $contact->type;
});

rules([
    'kategori' => 'required|string|max:255',
    'label' => 'required|string|max:255',
    'value' => 'required|string',
    'type' => 'required|in:text,link,map,tel,email',
]);

$save = function () {
    $this->validate();

    $contact = Contact::findOrFail($this->id);
    $contact->update([
        'kategori' => $this->kategori,
        'label' => $this->label,
        'value' => $this->value,
        'type' => $this->type,
    ]);

    $this->dispatch('contact-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Kontak
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Perbarui informasi detail kontak.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <!-- Kategori -->
                    <x-input-label for="kategori">
                        <span>Kategori</span>
                        <span class="text-xs text-slate-400 block mb-1">Contoh: Identitas, Alamat, Kontak, Sosmed</span>
                        <x-text-input wire:model="kategori" id="kategori" class="mt-1 w-full" type="text"
                            placeholder="Masukkan Kategori" :error="$errors->has('kategori')" />
                        <x-input-error :messages="$errors->get('kategori')" />
                    </x-input-label>

                    <!-- Label -->
                    <x-input-label for="label">
                        <span>Label</span>
                        <span class="text-xs text-slate-400 block mb-1">Contoh: Nama PKBM, Titik Belajar 1, WhatsApp
                            Admin</span>
                        <x-text-input wire:model="label" id="label" class="mt-1 w-full" type="text"
                            placeholder="Masukkan Label" :error="$errors->has('label')" />
                        <x-input-error :messages="$errors->get('label')" />
                    </x-input-label>

                    <!-- Value -->
                    <x-input-label for="value">
                        <span>Isi Data (Value)</span>
                        <span class="text-xs text-slate-400 block mb-1">Masukkan nilai data. Jika tipe Link/Map,
                            masukkan URL lengkap.</span>
                        <x-textarea-input wire:model="value" rows="4" placeholder="Masukkan isi data..." class="mt-1"
                            :error="$errors->has('value')"></x-textarea-input>
                        <x-input-error :messages="$errors->get('value')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan Tipe
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <!-- Type -->
                    <x-input-label for="type">
                        <span>Tipe Data</span>
                        <span class="text-xs text-slate-400 block mb-1">Pilih tipe untuk format tampilan yang
                            sesuai</span>
                        <x-select-input wire:model="type" id="type" class="mt-1 w-full" :error="$errors->has('type')">
                            <option value="text">Text (Biasa)</option>
                            <option value="link">Link (URL)</option>
                            <option value="map">Map (Link Peta)</option>
                            <option value="tel">Telepon (Tel/WA)</option>
                            <option value="email">Email</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('type')" />
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
    <x-success-modal trigger="contact-updated" message="Kontak berhasil diperbarui." />
</div>