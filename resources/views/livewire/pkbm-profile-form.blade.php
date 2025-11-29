<?php

use App\Models\PkbmProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use function Livewire\Volt\{state, rules, mount, uses};

uses(WithFileUploads::class);

state([
    'profile' => null,
    'nama_pkbm' => '',
    'npsn' => '',
    'alamat' => '',
    'provinsi' => '',
    'kota' => '',
    'kecamatan' => '',
    'desa' => '',
    'telepon' => '',
    'email' => '',
    'kepala_pkbm' => '',
    'visi' => '',
    'misi' => '',
    'new_logo' => null,
    'existing_logo' => null,
]);

mount(function () {
    $this->profile = PkbmProfile::first();
    if ($this->profile) {
        $this->nama_pkbm = $this->profile->nama_pkbm;
        $this->npsn = $this->profile->npsn;
        $this->alamat = $this->profile->alamat;
        $this->provinsi = $this->profile->provinsi;
        $this->kota = $this->profile->kota;
        $this->kecamatan = $this->profile->kecamatan;
        $this->desa = $this->profile->desa;
        $this->telepon = $this->profile->telepon;
        $this->email = $this->profile->email;
        $this->kepala_pkbm = $this->profile->kepala_pkbm;
        $this->visi = $this->profile->visi;
        $this->misi = $this->profile->misi;
        $this->existing_logo = $this->profile->logo;
    }
});

rules([
    'nama_pkbm' => 'required|string|max:255',
    'npsn' => 'nullable|string|max:20',
    'alamat' => 'nullable|string',
    'provinsi' => 'nullable|string|max:100',
    'kota' => 'nullable|string|max:100',
    'kecamatan' => 'nullable|string|max:100',
    'desa' => 'nullable|string|max:100',
    'telepon' => 'nullable|string|max:20',
    'email' => 'nullable|email|max:255',
    'kepala_pkbm' => 'nullable|string|max:255',
    'visi' => 'nullable|string',
    'misi' => 'nullable|string',
    'new_logo' => 'nullable|image|max:2048', // Max 2MB
]);

$save = function () {
    $this->validate();

    if (!$this->profile) {
        $this->profile = new PkbmProfile();
    }

    $data = [
        'nama_pkbm' => $this->nama_pkbm,
        'npsn' => $this->npsn,
        'alamat' => $this->alamat,
        'provinsi' => $this->provinsi,
        'kota' => $this->kota,
        'kecamatan' => $this->kecamatan,
        'desa' => $this->desa,
        'telepon' => $this->telepon,
        'email' => $this->email,
        'kepala_pkbm' => $this->kepala_pkbm,
        'visi' => $this->visi,
        'misi' => $this->misi,
    ];

    if ($this->new_logo) {
        if ($this->profile->logo) {
            Storage::disk('public')->delete($this->profile->logo);
        }
        $data['logo'] = $this->new_logo->store('pkbm/logo', 'public');
        $this->existing_logo = $data['logo'];
    }

    if ($this->profile->exists) {
        $this->profile->update($data);
    } else {
        $this->profile = PkbmProfile::create($data);
    }

    $this->dispatch('profile-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Identitas PKBM
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Informasi dasar mengenai lembaga PKBM.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama PKBM</span>
                        <x-text-input wire:model="nama_pkbm" placeholder="Nama PKBM" type="text"
                            :error="$errors->has('nama_pkbm')" />
                        <x-input-error :messages="$errors->get('nama_pkbm')" />
                    </x-input-label>

                    <x-input-label>
                        <span>NPSN</span>
                        <x-text-input wire:model="npsn" placeholder="Nomor Pokok Sekolah Nasional" type="text"
                            :error="$errors->has('npsn')" />
                        <x-input-error :messages="$errors->get('npsn')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Kepala PKBM</span>
                        <x-text-input wire:model="kepala_pkbm" placeholder="Nama Kepala PKBM" type="text"
                            :error="$errors->has('kepala_pkbm')" />
                        <x-input-error :messages="$errors->get('kepala_pkbm')" />
                    </x-input-label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Telepon</span>
                            <x-text-input wire:model="telepon" placeholder="Nomor Telepon" type="text"
                                :error="$errors->has('telepon')" />
                            <x-input-error :messages="$errors->get('telepon')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Email</span>
                            <x-text-input wire:model="email" placeholder="Alamat Email" type="email"
                                :error="$errors->has('email')" />
                            <x-input-error :messages="$errors->get('email')" />
                        </x-input-label>
                    </div>

                    <x-input-label>
                        <span>Alamat Lengkap</span>
                        <x-textarea-input wire:model="alamat" rows="3" placeholder="Alamat jalan, RT/RW..."
                            :error="$errors->has('alamat')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('alamat')" />
                    </x-input-label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Provinsi</span>
                            <x-text-input wire:model="provinsi" placeholder="Provinsi" type="text"
                                :error="$errors->has('provinsi')" />
                            <x-input-error :messages="$errors->get('provinsi')" />
                        </x-input-label>
                        <x-input-label>
                            <span>Kota/Kabupaten</span>
                            <x-text-input wire:model="kota" placeholder="Kota/Kabupaten" type="text"
                                :error="$errors->has('kota')" />
                            <x-input-error :messages="$errors->get('kota')" />
                        </x-input-label>
                        <x-input-label>
                            <span>Kecamatan</span>
                            <x-text-input wire:model="kecamatan" placeholder="Kecamatan" type="text"
                                :error="$errors->has('kecamatan')" />
                            <x-input-error :messages="$errors->get('kecamatan')" />
                        </x-input-label>
                        <x-input-label>
                            <span>Desa/Kelurahan</span>
                            <x-text-input wire:model="desa" placeholder="Desa/Kelurahan" type="text"
                                :error="$errors->has('desa')" />
                            <x-input-error :messages="$errors->get('desa')" />
                        </x-input-label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Visi & Misi
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Visi</span>
                        <x-textarea-input wire:model="visi" rows="4" placeholder="Visi PKBM..."
                            :error="$errors->has('visi')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('visi')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Misi</span>
                        <x-textarea-input wire:model="misi" rows="6" placeholder="Misi PKBM..."
                            :error="$errors->has('misi')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('misi')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Logo Lembaga
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Upload Logo</span>
                        @if($existing_logo)
                            <div
                                class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                <img src="{{ asset('storage/' . $existing_logo) }}" alt="Logo PKBM"
                                    class="h-32 w-auto object-contain">
                            </div>
                        @endif
                        <x-text-input wire:model="new_logo" type="file" accept="image/*"
                            :error="$errors->has('new_logo')" />
                        <x-input-error :messages="$errors->get('new_logo')" />
                        <span class="text-xs text-slate-400">Max 2MB. Format: PNG, JPG, JPEG.</span>
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save" class="w-full justify-center">
                        Simpan Profil
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="profile-updated" message="Profil PKBM berhasil diperbarui." />
</div>