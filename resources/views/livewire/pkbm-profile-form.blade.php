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
    'jenjang_pendidikan' => '',
    'status_sekolah' => '',
    'alamat' => '',
    'rt_rw' => '',
    'kode_pos' => '',
    'desa' => '',
    'kecamatan' => '',
    'kota' => '',
    'provinsi' => '',
    'negara' => '',
    'lintang' => '',
    'bujur' => '',
    'telepon' => '',
    'fax' => '',
    'email' => '',
    'website' => '',
    'kepala_pkbm' => '',
    'visi' => '',
    'misi' => '',
    'sk_pendirian' => '',
    'tanggal_sk_pendirian' => '',
    'status_kepemilikan' => '',
    'sk_izin_operasional' => '',
    'tanggal_sk_izin_operasional' => '',
    'kebutuhan_khusus_dilayani' => '',
    'nomor_rekening' => '',
    'nama_bank' => '',
    'cabang_kcp_unit' => '',
    'rekening_atas_nama' => '',
    'mbs' => '',
    'memungut_iuran' => false,
    'nominal_iuran' => '',
    'nama_wajib_pajak' => '',
    'npwp' => '',
    'waktu_penyelenggaraan' => '',
    'bersedia_menerima_bos' => true,
    'akreditasi' => '',
    'sumber_listrik' => '',
    'daya_listrik' => '',
    'akses_internet' => '',
    'new_logo' => null,
    'existing_logo' => null,
    'kata_sambutan' => '',
    'new_foto_sambutan' => null,
    'existing_foto_sambutan' => null,
    'latar_belakang' => '',
    'new_struktur_organisasi' => null,
    'existing_struktur_organisasi' => null,
]);

mount(function () {
    $this->profile = PkbmProfile::first();
    if ($this->profile) {
        $this->nama_pkbm = $this->profile->nama_pkbm;
        $this->npsn = $this->profile->npsn;
        $this->jenjang_pendidikan = $this->profile->jenjang_pendidikan;
        $this->status_sekolah = $this->profile->status_sekolah;
        $this->alamat = $this->profile->alamat;
        $this->rt_rw = $this->profile->rt_rw;
        $this->kode_pos = $this->profile->kode_pos;
        $this->desa = $this->profile->desa;
        $this->kecamatan = $this->profile->kecamatan;
        $this->kota = $this->profile->kota;
        $this->provinsi = $this->profile->provinsi;
        $this->negara = $this->profile->negara;
        $this->lintang = $this->profile->lintang;
        $this->bujur = $this->profile->bujur;
        $this->telepon = $this->profile->telepon;
        $this->fax = $this->profile->fax;
        $this->email = $this->profile->email;
        $this->website = $this->profile->website;
        $this->kepala_pkbm = $this->profile->kepala_pkbm;
        $this->visi = $this->profile->visi;
        $this->misi = $this->profile->misi;
        $this->sk_pendirian = $this->profile->sk_pendirian;
        $this->tanggal_sk_pendirian = $this->profile->tanggal_sk_pendirian?->format('Y-m-d');
        $this->status_kepemilikan = $this->profile->status_kepemilikan;
        $this->sk_izin_operasional = $this->profile->sk_izin_operasional;
        $this->tanggal_sk_izin_operasional = $this->profile->tanggal_sk_izin_operasional?->format('Y-m-d');
        $this->kebutuhan_khusus_dilayani = $this->profile->kebutuhan_khusus_dilayani;
        $this->nomor_rekening = $this->profile->nomor_rekening;
        $this->nama_bank = $this->profile->nama_bank;
        $this->cabang_kcp_unit = $this->profile->cabang_kcp_unit;
        $this->rekening_atas_nama = $this->profile->rekening_atas_nama;
        $this->mbs = $this->profile->mbs;
        $this->memungut_iuran = $this->profile->memungut_iuran;
        $this->nominal_iuran = $this->profile->nominal_iuran;
        $this->nama_wajib_pajak = $this->profile->nama_wajib_pajak;
        $this->npwp = $this->profile->npwp;
        $this->waktu_penyelenggaraan = $this->profile->waktu_penyelenggaraan;
        $this->bersedia_menerima_bos = $this->profile->bersedia_menerima_bos;
        $this->akreditasi = $this->profile->akreditasi;
        $this->sumber_listrik = $this->profile->sumber_listrik;
        $this->daya_listrik = $this->profile->daya_listrik;
        $this->akses_internet = $this->profile->akses_internet;
        $this->existing_logo = $this->profile->logo;
        $this->kata_sambutan = $this->profile->kata_sambutan;
        $this->existing_foto_sambutan = $this->profile->foto_sambutan;
        $this->latar_belakang = $this->profile->latar_belakang;
        $this->existing_struktur_organisasi = $this->profile->foto_struktur_organisasi;
    }
});

rules(fn() => [
    'nama_pkbm' => 'required|string|max:255',
    'npsn' => 'required|string|max:20',
    'jenjang_pendidikan' => 'nullable|string',
    'status_sekolah' => 'nullable|string',
    'alamat' => 'required|string',
    'rt_rw' => 'nullable|string',
    'kode_pos' => 'nullable|string',
    'desa' => 'required|string|max:100',
    'kecamatan' => 'required|string|max:100',
    'kota' => 'required|string|max:100',
    'provinsi' => 'required|string|max:100',
    'negara' => 'nullable|string',
    'lintang' => 'nullable|string',
    'bujur' => 'nullable|string',
    'telepon' => 'required|string|max:20',
    'fax' => 'nullable|string',
    'email' => 'required|email|max:255',
    'website' => 'nullable|url',
    'kepala_pkbm' => 'required|string|max:255',
    'visi' => 'required|string',
    'misi' => 'required|string',
    'sk_pendirian' => 'nullable|string',
    'tanggal_sk_pendirian' => 'nullable|date',
    'status_kepemilikan' => 'nullable|string',
    'sk_izin_operasional' => 'nullable|string',
    'tanggal_sk_izin_operasional' => 'nullable|date',
    'kebutuhan_khusus_dilayani' => 'nullable|string',
    'nomor_rekening' => 'nullable|string',
    'nama_bank' => 'nullable|string',
    'cabang_kcp_unit' => 'nullable|string',
    'rekening_atas_nama' => 'nullable|string',
    'mbs' => 'nullable|string',
    'memungut_iuran' => 'boolean',
    'nominal_iuran' => 'nullable|numeric',
    'nama_wajib_pajak' => 'nullable|string',
    'npwp' => 'nullable|string',
    'waktu_penyelenggaraan' => 'nullable|string',
    'bersedia_menerima_bos' => 'boolean',
    'akreditasi' => 'nullable|string',
    'sumber_listrik' => 'nullable|string',
    'daya_listrik' => 'nullable|integer',
    'akses_internet' => 'nullable|string',
    'new_logo' => [$this->existing_logo ? 'nullable' : 'required', 'image', 'max:2048'], // Max 2MB
    'kata_sambutan' => 'nullable|string',
    'new_foto_sambutan' => ['nullable', 'image', 'max:2048'],
    'latar_belakang' => 'nullable|string',
    'new_struktur_organisasi' => ['nullable', 'image', 'max:2048'],
]);

$save = function () {
    $this->validate();

    if (!$this->profile) {
        $this->profile = new PkbmProfile();
    }

    $data = [
        'nama_pkbm' => $this->nama_pkbm,
        'npsn' => $this->npsn,
        'jenjang_pendidikan' => $this->jenjang_pendidikan,
        'status_sekolah' => $this->status_sekolah,
        'alamat' => $this->alamat,
        'rt_rw' => $this->rt_rw,
        'kode_pos' => $this->kode_pos,
        'desa' => $this->desa,
        'kecamatan' => $this->kecamatan,
        'kota' => $this->kota,
        'provinsi' => $this->provinsi,
        'negara' => $this->negara,
        'lintang' => $this->lintang,
        'bujur' => $this->bujur,
        'telepon' => $this->telepon,
        'fax' => $this->fax,
        'email' => $this->email,
        'website' => $this->website,
        'kepala_pkbm' => $this->kepala_pkbm,
        'visi' => $this->visi,
        'misi' => $this->misi,
        'kata_sambutan' => $this->kata_sambutan,
        'sk_pendirian' => $this->sk_pendirian,
        'tanggal_sk_pendirian' => $this->tanggal_sk_pendirian ?: null,
        'status_kepemilikan' => $this->status_kepemilikan,
        'sk_izin_operasional' => $this->sk_izin_operasional,
        'tanggal_sk_izin_operasional' => $this->tanggal_sk_izin_operasional ?: null,
        'kebutuhan_khusus_dilayani' => $this->kebutuhan_khusus_dilayani,
        'nomor_rekening' => $this->nomor_rekening,
        'nama_bank' => $this->nama_bank,
        'cabang_kcp_unit' => $this->cabang_kcp_unit,
        'rekening_atas_nama' => $this->rekening_atas_nama,
        'mbs' => $this->mbs,
        'memungut_iuran' => $this->memungut_iuran,
        'nominal_iuran' => $this->nominal_iuran ?: null,
        'nama_wajib_pajak' => $this->nama_wajib_pajak,
        'npwp' => $this->npwp,
        'waktu_penyelenggaraan' => $this->waktu_penyelenggaraan,
        'bersedia_menerima_bos' => $this->bersedia_menerima_bos,
        'akreditasi' => $this->akreditasi,
        'sumber_listrik' => $this->sumber_listrik,
        'daya_listrik' => $this->daya_listrik ?: null,
        'akses_internet' => $this->akses_internet,
        'latar_belakang' => $this->latar_belakang,
    ];

    if ($this->new_logo) {
        if ($this->existing_logo) {
            Storage::disk('public')->delete($this->existing_logo);
        }
        $data['logo'] = $this->new_logo->store('pkbm/logo', 'public');
        $this->existing_logo = $data['logo'];
        $this->new_logo = null;
    }

    if ($this->new_foto_sambutan) {
        if ($this->existing_foto_sambutan) {
            Storage::disk('public')->delete($this->existing_foto_sambutan);
        }
        $data['foto_sambutan'] = $this->new_foto_sambutan->store('pkbm/sambutan', 'public');
        $this->existing_foto_sambutan = $data['foto_sambutan'];
        $this->new_foto_sambutan = null;
    }

    if ($this->new_struktur_organisasi) {
        if ($this->existing_struktur_organisasi) {
            Storage::disk('public')->delete($this->existing_struktur_organisasi);
        }
        $data['foto_struktur_organisasi'] = $this->new_struktur_organisasi->store('pkbm/struktur', 'public');
        $this->existing_struktur_organisasi = $data['foto_struktur_organisasi'];
        $this->new_struktur_organisasi = null;
    }

    if ($this->profile->exists) {
        $this->profile->update($data);
    } else {
        $this->profile = PkbmProfile::create($data);
    }

    $this->dispatch('profile-updated');
};

?>

<div>
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
                        Informasi dasar mengenai identitas sekolah.
                    </p>
                    <div class="mt-5 flex flex-col gap-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
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
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Jenjang Pendidikan</span>
                                <x-text-input wire:model="jenjang_pendidikan" placeholder="Contoh: Paket A/B/C"
                                    type="text" :error="$errors->has('jenjang_pendidikan')" />
                                <x-input-error :messages="$errors->get('jenjang_pendidikan')" />
                            </x-input-label>

                            <x-input-label>
                                <span>Status Sekolah</span>
                                <x-text-input wire:model="status_sekolah" placeholder="Contoh: Swasta" type="text"
                                    :error="$errors->has('status_sekolah')" />
                                <x-input-error :messages="$errors->get('status_sekolah')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>Kepala PKBM</span>
                            <x-text-input wire:model="kepala_pkbm" placeholder="Nama Kepala PKBM" type="text"
                                :error="$errors->has('kepala_pkbm')" />
                            <x-input-error :messages="$errors->get('kepala_pkbm')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Alamat Jalan</span>
                            <x-textarea-input wire:model="alamat" rows="2" placeholder="Nama Jalan..."
                                :error="$errors->has('alamat')">
                            </x-textarea-input>
                            <x-input-error :messages="$errors->get('alamat')" />
                        </x-input-label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>RT / RW</span>
                                <x-text-input wire:model="rt_rw" placeholder="Contoh: 001/002" type="text"
                                    :error="$errors->has('rt_rw')" />
                                <x-input-error :messages="$errors->get('rt_rw')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Kode Pos</span>
                                <x-text-input wire:model="kode_pos" placeholder="Kode Pos" type="text"
                                    :error="$errors->has('kode_pos')" />
                                <x-input-error :messages="$errors->get('kode_pos')" />
                            </x-input-label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Desa/Kelurahan</span>
                                <x-text-input wire:model="desa" placeholder="Desa/Kelurahan" type="text"
                                    :error="$errors->has('desa')" />
                                <x-input-error :messages="$errors->get('desa')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Kecamatan</span>
                                <x-text-input wire:model="kecamatan" placeholder="Kecamatan" type="text"
                                    :error="$errors->has('kecamatan')" />
                                <x-input-error :messages="$errors->get('kecamatan')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Kota/Kabupaten</span>
                                <x-text-input wire:model="kota" placeholder="Kota/Kabupaten" type="text"
                                    :error="$errors->has('kota')" />
                                <x-input-error :messages="$errors->get('kota')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Provinsi</span>
                                <x-text-input wire:model="provinsi" placeholder="Provinsi" type="text"
                                    :error="$errors->has('provinsi')" />
                                <x-input-error :messages="$errors->get('provinsi')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>Negara</span>
                            <x-text-input wire:model="negara" placeholder="Negara" type="text"
                                :error="$errors->has('negara')" />
                            <x-input-error :messages="$errors->get('negara')" />
                        </x-input-label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Lintang</span>
                                <x-text-input wire:model="lintang" placeholder="Koordinat Lintang" type="text"
                                    :error="$errors->has('lintang')" />
                                <x-input-error :messages="$errors->get('lintang')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Bujur</span>
                                <x-text-input wire:model="bujur" placeholder="Koordinat Bujur" type="text"
                                    :error="$errors->has('bujur')" />
                                <x-input-error :messages="$errors->get('bujur')" />
                            </x-input-label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pelengkap -->
            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Data Pelengkap
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="mt-5 flex flex-col gap-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>SK Pendirian</span>
                                <x-text-input wire:model="sk_pendirian" placeholder="Nomor SK Pendirian" type="text"
                                    :error="$errors->has('sk_pendirian')" />
                                <x-input-error :messages="$errors->get('sk_pendirian')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Tanggal SK Pendirian</span>
                                <x-text-input wire:model="tanggal_sk_pendirian" type="date"
                                    :error="$errors->has('tanggal_sk_pendirian')" />
                                <x-input-error :messages="$errors->get('tanggal_sk_pendirian')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>Status Kepemilikan</span>
                            <x-text-input wire:model="status_kepemilikan" placeholder="Contoh: Yayasan" type="text"
                                :error="$errors->has('status_kepemilikan')" />
                            <x-input-error :messages="$errors->get('status_kepemilikan')" />
                        </x-input-label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>SK Izin Operasional</span>
                                <x-text-input wire:model="sk_izin_operasional" placeholder="Nomor SK Izin" type="text"
                                    :error="$errors->has('sk_izin_operasional')" />
                                <x-input-error :messages="$errors->get('sk_izin_operasional')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Tgl SK Izin Ops</span>
                                <x-text-input wire:model="tanggal_sk_izin_operasional" type="date"
                                    :error="$errors->has('tanggal_sk_izin_operasional')" />
                                <x-input-error :messages="$errors->get('tanggal_sk_izin_operasional')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>Kebutuhan Khusus Dilayani</span>
                            <x-text-input wire:model="kebutuhan_khusus_dilayani" placeholder="Contoh: Tidak Ada"
                                type="text" :error="$errors->has('kebutuhan_khusus_dilayani')" />
                            <x-input-error :messages="$errors->get('kebutuhan_khusus_dilayani')" />
                        </x-input-label>

                        <div class="border-t border-slate-200 dark:border-navy-500 my-2"></div>
                        <h3 class="font-medium text-slate-700 dark:text-navy-100">Data Rekening & Keuangan</h3>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Nama Bank</span>
                                <x-text-input wire:model="nama_bank" placeholder="Nama Bank" type="text"
                                    :error="$errors->has('nama_bank')" />
                                <x-input-error :messages="$errors->get('nama_bank')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Cabang KCP/Unit</span>
                                <x-text-input wire:model="cabang_kcp_unit" placeholder="Cabang Bank" type="text"
                                    :error="$errors->has('cabang_kcp_unit')" />
                                <x-input-error :messages="$errors->get('cabang_kcp_unit')" />
                            </x-input-label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Nomor Rekening</span>
                                <x-text-input wire:model="nomor_rekening" placeholder="Nomor Rekening" type="text"
                                    :error="$errors->has('nomor_rekening')" />
                                <x-input-error :messages="$errors->get('nomor_rekening')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Atas Nama Rekening</span>
                                <x-text-input wire:model="rekening_atas_nama" placeholder="Atas Nama" type="text"
                                    :error="$errors->has('rekening_atas_nama')" />
                                <x-input-error :messages="$errors->get('rekening_atas_nama')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>MBS</span>
                            <x-text-input wire:model="mbs" placeholder="MBS" type="text" :error="$errors->has('mbs')" />
                            <x-input-error :messages="$errors->get('mbs')" />
                        </x-input-label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="inline-flex items-center space-x-2">
                                <span class="text-slate-700 dark:text-navy-100">Memungut Iuran?</span>
                                <input wire:model="memungut_iuran" type="checkbox"
                                    class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent" />
                            </label>

                            <x-input-label>
                                <span>Nominal Iuran / Siswa</span>
                                <x-text-input wire:model="nominal_iuran" placeholder="0" type="number"
                                    :error="$errors->has('nominal_iuran')" />
                                <x-input-error :messages="$errors->get('nominal_iuran')" />
                            </x-input-label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Nama Wajib Pajak</span>
                                <x-text-input wire:model="nama_wajib_pajak" placeholder="Nama WP" type="text"
                                    :error="$errors->has('nama_wajib_pajak')" />
                                <x-input-error :messages="$errors->get('nama_wajib_pajak')" />
                            </x-input-label>
                            <x-input-label>
                                <span>NPWP</span>
                                <x-text-input wire:model="npwp" placeholder="Nomor NPWP" type="text"
                                    :error="$errors->has('npwp')" />
                                <x-input-error :messages="$errors->get('npwp')" />
                            </x-input-label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak Sekolah -->
            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Kontak Sekolah
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="mt-5 flex flex-col gap-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Nomor Telepon</span>
                                <x-text-input wire:model="telepon" placeholder="Nomor Telepon" type="text"
                                    :error="$errors->has('telepon')" />
                                <x-input-error :messages="$errors->get('telepon')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Nomor Fax</span>
                                <x-text-input wire:model="fax" placeholder="Nomor Fax" type="text"
                                    :error="$errors->has('fax')" />
                                <x-input-error :messages="$errors->get('fax')" />
                            </x-input-label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Email</span>
                                <x-text-input wire:model="email" placeholder="Email" type="email"
                                    :error="$errors->has('email')" />
                                <x-input-error :messages="$errors->get('email')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Website</span>
                                <x-text-input wire:model="website" placeholder="https://..." type="url"
                                    :error="$errors->has('website')" />
                                <x-input-error :messages="$errors->get('website')" />
                            </x-input-label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Periodik -->
            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Data Periodik
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="mt-5 flex flex-col gap-4">
                        <x-input-label>
                            <span>Waktu Penyelenggaraan</span>
                            <x-text-input wire:model="waktu_penyelenggaraan" placeholder="Contoh: Pagi/Siang"
                                type="text" :error="$errors->has('waktu_penyelenggaraan')" />
                            <x-input-error :messages="$errors->get('waktu_penyelenggaraan')" />
                        </x-input-label>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Akreditasi</span>
                                <x-text-input wire:model="akreditasi" placeholder="Contoh: A/B/Belum" type="text"
                                    :error="$errors->has('akreditasi')" />
                                <x-input-error :messages="$errors->get('akreditasi')" />
                            </x-input-label>
                            <label class="inline-flex items-center space-x-2 mt-6">
                                <span class="text-slate-700 dark:text-navy-100">Bersedia Menerima BOS?</span>
                                <input wire:model="bersedia_menerima_bos" type="checkbox"
                                    class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent" />
                            </label>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input-label>
                                <span>Sumber Listrik</span>
                                <x-text-input wire:model="sumber_listrik" placeholder="PLN / Lainnya" type="text"
                                    :error="$errors->has('sumber_listrik')" />
                                <x-input-error :messages="$errors->get('sumber_listrik')" />
                            </x-input-label>
                            <x-input-label>
                                <span>Daya Listrik (Watt)</span>
                                <x-text-input wire:model="daya_listrik" placeholder="Contoh: 1300" type="number"
                                    :error="$errors->has('daya_listrik')" />
                                <x-input-error :messages="$errors->get('daya_listrik')" />
                            </x-input-label>
                        </div>

                        <x-input-label>
                            <span>Akses Internet</span>
                            <x-text-input wire:model="akses_internet" placeholder="Contoh: Telkomsel / Indihome"
                                type="text" :error="$errors->has('akses_internet')" />
                            <x-input-error :messages="$errors->get('akses_internet')" />
                        </x-input-label>
                    </div>
                </div>
            </div>

            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Visi, Misi & Latar Belakang
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="mt-5 flex flex-col gap-4">
                        <x-input-label>
                            <span>Latar Belakang / Sejarah</span>
                            <x-textarea-input wire:model="latar_belakang" rows="6" placeholder="Sejarah singkat PKBM..."
                                :error="$errors->has('latar_belakang')">
                            </x-textarea-input>
                            <x-input-error :messages="$errors->get('latar_belakang')" />
                        </x-input-label>
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
                    <div class="flex flex-col gap-4">
                        <x-input-label>
                            <span>Upload Logo</span>
                            @if($existing_logo)
                                <div class="mt-2">
                                    <div
                                        class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ asset('storage/' . $existing_logo) }}" alt="Logo PKBM"
                                            class="h-32 w-auto object-contain">
                                    </div>
                                </div>
                            @endif
                            <div class="relative">
                                <x-text-input wire:model="new_logo" type="file" accept="image/*"
                                    :error="$errors->has('new_logo')" />
                                <div wire:loading wire:target="new_logo" class="absolute right-3 top-2.5">
                                    <div
                                        class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('new_logo')" />
                            <span class="text-xs text-slate-400">Max 2MB. Format: PNG, JPG, JPEG.</span>
                            @if ($new_logo && method_exists($new_logo, 'temporaryUrl'))
                                <div class="grid">
                                    <div
                                        class="mt-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ $new_logo->temporaryUrl() }}" alt="Preview"
                                            class="h-32 w-auto object-contain">
                                    </div>
                                </div>
                            @endif
                        </x-input-label>
                    </div>
                </div>
            </div>

            <div class="card mt-4 px-4 pb-4 sm:px-5">
                <div class="my-3 flex h-8 items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                        Struktur Organisasi
                    </h2>
                </div>
                <div class="max-w-xl">
                    <div class="flex flex-col gap-4">
                        <x-input-label>
                            <span>Upload Struktur</span>
                            @if($existing_struktur_organisasi)
                                <div class="mt-2">
                                    <div
                                        class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ asset('storage/' . $existing_struktur_organisasi) }}"
                                            alt="Struktur Organisasi" class="h-32 w-auto object-contain">
                                    </div>
                                </div>
                            @endif
                            <div class="relative">
                                <x-text-input wire:model="new_struktur_organisasi" type="file" accept="image/*"
                                    :error="$errors->has('new_struktur_organisasi')" />
                                <div wire:loading wire:target="new_struktur_organisasi"
                                    class="absolute right-3 top-2.5">
                                    <div
                                        class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('new_struktur_organisasi')" />
                            <span class="text-xs text-slate-400">Max 2MB. Format: PNG, JPG, JPEG.</span>
                            @if ($new_struktur_organisasi && method_exists($new_struktur_organisasi, 'temporaryUrl'))
                                <div class="grid">
                                    <div
                                        class="mt-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                        <img src="{{ $new_struktur_organisasi->temporaryUrl() }}" alt="Preview"
                                            class="h-32 w-auto object-contain">
                                    </div>
                                </div>
                            @endif
                        </x-input-label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4 px-4 pb-4 sm:px-5">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                Sambutan Kepala PKBM
            </h2>
        </div>
        <div class="max-w-xl">
            <div class="flex flex-col gap-4">
                <x-input-label>
                    <span>Foto Sambutan</span>
                    @if($existing_foto_sambutan)
                        <div class="mt-2 grid grid-cols-3">
                            <div
                                class="mb-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                <img src="{{ asset('storage/' . $existing_foto_sambutan) }}" alt="Foto Sambutan"
                                    class="h-32 w-auto object-contain">
                            </div>
                        </div>
                    @endif
                    <div class="relative">
                        <x-text-input wire:model="new_foto_sambutan" type="file" accept="image/*"
                            :error="$errors->has('new_foto_sambutan')" />
                        <div wire:loading wire:target="new_foto_sambutan" class="absolute right-3 top-2.5">
                            <div
                                class="spinner size-5 animate-spin rounded-full border-2 border-primary border-t-transparent dark:border-accent-light dark:border-t-transparent">
                            </div>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('new_foto_sambutan')" />
                    <span class="text-xs text-slate-400">Max 2MB. Format: PNG, JPG, JPEG.</span>
                    @if ($new_foto_sambutan && method_exists($new_foto_sambutan, 'temporaryUrl'))
                        <div class="grid grid-cols-3">
                            <div
                                class="mt-2 flex justify-center rounded-lg border border-slate-200 p-2 dark:border-navy-500">
                                <img src="{{ $new_foto_sambutan->temporaryUrl() }}" alt="Preview"
                                    class="h-32 w-auto object-contain">
                            </div>
                        </div>
                    @endif
                </x-input-label>

                <x-input-label>
                    <span>Kata Sambutan</span>
                    <x-textarea-input wire:model="kata_sambutan" rows="6" placeholder="Kata sambutan..."
                        :error="$errors->has('kata_sambutan')"></x-textarea-input>
                    <x-input-error :messages="$errors->get('kata_sambutan')" />
                </x-input-label>
            </div>
            <div class="mt-5">
                <x-primary-button wire:click="save">
                    Simpan Profil
                </x-primary-button>
            </div>
        </div>
    </div>

    <x-success-modal trigger="profile-updated" message="Profil PKBM berhasil diperbarui." />
</div>