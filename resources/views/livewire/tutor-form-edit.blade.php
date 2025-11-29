<?php

use App\Models\Tutor;
use function Livewire\Volt\{state, rules, mount};

state([
    'tutor' => null,
    'nama' => '',
    'no_hp' => '',
    'alamat' => '',
    'pendidikan_terakhir' => '',
    'keahlian' => '',
    'status' => '',
]);

mount(function ($id) {
    $this->tutor = Tutor::findOrFail($id);
    $this->nama = $this->tutor->nama;
    $this->no_hp = $this->tutor->no_hp;
    $this->alamat = $this->tutor->alamat;
    $this->pendidikan_terakhir = $this->tutor->pendidikan_terakhir;
    $this->keahlian = $this->tutor->keahlian;
    $this->status = $this->tutor->status;
});

rules([
    'nama' => 'required|string|max:255',
    'no_hp' => 'required|string|max:20',
    'alamat' => 'required|string',
    'pendidikan_terakhir' => 'required|string',
    'keahlian' => 'required|string',
    'status' => 'required|in:aktif,nonaktif',
]);

$save = function () {
    $this->validate();

    $this->tutor->update([
        'nama' => $this->nama,
        'no_hp' => $this->no_hp,
        'alamat' => $this->alamat,
        'pendidikan_terakhir' => $this->pendidikan_terakhir,
        'keahlian' => $this->keahlian,
        'status' => $this->status,
    ]);

    $this->dispatch('tutor-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Tutor
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Perbarui detail informasi tutor.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Lengkap</span>
                        <x-text-input wire:model="nama" placeholder="Masukkan nama lengkap tutor" type="text"
                            :error="$errors->has('nama')" />
                        <x-input-error :messages="$errors->get('nama')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Nomor HP</span>
                        <x-text-input wire:model="no_hp" placeholder="Contoh: 081234567890" type="text"
                            :error="$errors->has('no_hp')" />
                        <x-input-error :messages="$errors->get('no_hp')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Alamat</span>
                        <x-textarea-input wire:model="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                            :error="$errors->has('alamat')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('alamat')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Keahlian / Mata Pelajaran</span>
                        <x-text-input wire:model="keahlian" placeholder="Contoh: Matematika, Bahasa Inggris" type="text"
                            :error="$errors->has('keahlian')" />
                        <x-input-error :messages="$errors->get('keahlian')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan Tambahan
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Pendidikan Terakhir</span>
                        <x-select-input wire:model="pendidikan_terakhir" :error="$errors->has('pendidikan_terakhir')">
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1 Pendidikan">S1 Pendidikan</option>
                            <option value="S1 Non-Pendidikan">S1 Non-Pendidikan</option>
                            <option value="S2 Pendidikan">S2 Pendidikan</option>
                            <option value="S2 Non-Pendidikan">S2 Non-Pendidikan</option>
                            <option value="S3">S3</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('pendidikan_terakhir')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
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

    <x-success-modal trigger="tutor-updated" message="Data tutor berhasil diperbarui." />
</div>