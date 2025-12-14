<?php

use App\Models\DataPpdb;
use App\Enums\DataPpdbType;
use Illuminate\Validation\Rule;
use function Livewire\Volt\{state, rules, mount};



state([
    'dataPpdb' => null,
    'ppdb_id' => null,
    'nama' => '',
    'jenis' => DataPpdbType::TEXT,
    'status' => 'active',
    'default' => '',
]);

mount(function ($ppdbId, $id) {
    $this->ppdb_id = $ppdbId;
    $this->dataPpdb = DataPpdb::where('ppdb_id', $ppdbId)->findOrFail($id);

    $this->nama = $this->dataPpdb->nama;
    $this->jenis = $this->dataPpdb->jenis;
    $this->status = $this->dataPpdb->status;
    $this->default = $this->dataPpdb->default;
});

rules(fn() => [
    'nama' => [
        'required',
        'string',
        'max:255',
        Rule::unique('data_ppdbs')->where(fn($query) => $query->where('ppdb_id', $this->ppdb_id))->ignore($this->dataPpdb->id)
    ],
    'jenis' => ['required', Rule::enum(DataPpdbType::class)],
    'status' => ['required', Rule::in(['active', 'optional', 'inactive'])],
    'default' => 'nullable|string|max:255',
]);

$save = function () {
    $this->validate();

    $this->dataPpdb->update([
        'nama' => $this->nama,
        'jenis' => $this->jenis,
        'default' => $this->default,
        'status' => $this->status,
    ]);

    $this->dispatch('data-ppdb-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Data Atribut
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Perbarui detail atribut data yang akan ditampilkan pada formulir PPDB.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Data</span>
                        <x-text-input wire:model="nama" type="text" placeholder="Contoh: Nomor Induk Kependudukan (NIK)"
                            :error="$errors->has('nama')" />
                        <x-input-error :messages="$errors->get('nama')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Jenis Input</span>
                        <x-select-input wire:model="jenis" :error="$errors->has('jenis')">
                            @foreach(DataPpdbType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->label() }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('jenis')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Nilai Default / Keterangan (Opsional)</span>
                        <x-text-input wire:model="default" type="text"
                            placeholder="Masukkan keterangan tambahan jika ada..." :error="$errors->has('default')" />
                        <x-input-error :messages="$errors->get('default')" />
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
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="active">Wajib (Required)</option>
                            <option value="optional">Opsional (Optional)</option>
                            <option value="inactive">Non-Aktif (Hidden)</option>
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

    <x-success-modal trigger="data-ppdb-updated" message="Data atribut berhasil diperbarui." />
</div>