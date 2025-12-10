<?php

use Livewire\Volt\Component;
use App\Models\DataPpdb;
use App\Models\Ppdb;
use Livewire\Attributes\Validate;

new class extends Component {
    public ?DataPpdb $dataPpdb = null;

    #[Validate('required')]
    public $ppdb_id = '';

    #[Validate('required|string|max:255')]
    public $nama = '';

    #[Validate('required')]
    public $jenis = 'text';

    #[Validate('required')]
    public $status = 'active';

    #[Validate('nullable|string|max:255')]
    public $default = '';

    public $ppdbOptions = [];

    public function mount($ppdbId, $id = null)
    {
        $this->ppdb_id = $ppdbId;

        if ($id) {
            $this->dataPpdb = DataPpdb::where('ppdb_id', $ppdbId)->findOrFail($id);
            $this->nama = $this->dataPpdb->nama;
            $this->jenis = $this->dataPpdb->jenis;
            $this->status = $this->dataPpdb->status;
            $this->default = $this->dataPpdb->default;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->dataPpdb) {
            $this->dataPpdb->update([
                'nama' => $this->nama,
                'jenis' => $this->jenis,
                'default' => $this->default,
                'status' => $this->status,
            ]);

            $this->dispatch('data-ppdb-updated');
        } else {
            DataPpdb::create([
                'ppdb_id' => $this->ppdb_id,
                'nama' => $this->nama,
                'jenis' => $this->jenis,
                'default' => $this->default,
                'status' => $this->status,
            ]);

            session()->flash('status', 'Berhasil');
            session()->flash('message', 'Data berhasil ditambahkan.');
            return $this->redirectRoute('admin.ppdb.master.data.index', ['id' => $this->ppdb_id], navigate: true);
        }
    }
}; ?>

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
                    Isi detail atribut data yang akan ditampilkan pada formulir PPDB.
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
                            <option value="text">Teks Singkat (Text)</option>
                            <option value="number">Angka (Number)</option>
                            <option value="date">Tanggal (Date)</option>
                            <option value="file">Upload File</option>
                            <option value="textarea">Teks Panjang (Textarea)</option>
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
                        {{ $this->dataPpdb ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="data-ppdb-updated" message="Data atribut berhasil diperbarui." />
</div>