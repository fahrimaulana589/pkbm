<?php

use App\Models\Program;
use function Livewire\Volt\{state, rules};

state([
    'kategori' => 'Paket A',
    'nama_program' => '',
    'deskripsi' => '',
    'durasi' => '',
    'status' => 'aktif',
]);

rules([
    'kategori' => 'required|in:Paket A,Paket B,Paket C,Keaksaraan,Kursus,Pelatihan,Life Skill',
    'nama_program' => 'required|string|max:255',
    'deskripsi' => 'nullable|string',
    'durasi' => 'nullable|string|max:255',
    'status' => 'required|in:aktif,nonaktif',
]);

$save = function () {
    $this->validate();

    Program::create([
        'kategori' => $this->kategori,
        'nama_program' => $this->nama_program,
        'deskripsi' => $this->deskripsi,
        'durasi' => $this->durasi,
        'status' => $this->status,
    ]);

    session()->flash('status', 'Program berhasil dibuat');
    session()->flash('message', 'Data program berhasil ditambahkan.');
    return $this->redirectRoute('admin.program.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Program
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi program pendidikan baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Program</span>
                        <x-text-input wire:model="nama_program" placeholder="Contoh: Pendidikan Kesetaraan Paket C"
                            type="text" :error="$errors->has('nama_program')" />
                        <x-input-error :messages="$errors->get('nama_program')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Deskripsi</span>
                        <x-textarea-input wire:model="deskripsi" rows="4"
                            placeholder="Deskripsi singkat tentang program..." :error="$errors->has('deskripsi')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('deskripsi')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Durasi</span>
                        <x-text-input wire:model="durasi" placeholder="Contoh: 12 Bulan" type="text"
                            :error="$errors->has('durasi')" />
                        <x-input-error :messages="$errors->get('durasi')" />
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
                        <span>Kategori</span>
                        <x-select-input wire:model="kategori" :error="$errors->has('kategori')">
                            <option value="Paket A">Paket A</option>
                            <option value="Paket B">Paket B</option>
                            <option value="Paket C">Paket C</option>
                            <option value="Keaksaraan">Keaksaraan</option>
                            <option value="Kursus">Kursus</option>
                            <option value="Pelatihan">Pelatihan</option>
                            <option value="Life Skill">Life Skill</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('kategori')" />
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
                        Simpan Program
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>