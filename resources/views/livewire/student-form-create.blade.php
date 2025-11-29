<?php

use App\Models\Student;
use App\Models\Program;
use function Livewire\Volt\{state, rules, mount};

state([
    'program_id' => '',
    'nik' => '',
    'nisn' => '',
    'nama_lengkap' => '',
    'tempat_lahir' => '',
    'tanggal_lahir' => '',
    'jenis_kelamin' => 'L',
    'alamat' => '',
    'no_hp' => '',
    'status' => 'aktif',
    'programs' => [],
]);

mount(function () {
    $this->programs = Program::where('status', 'aktif')->get();
    if ($this->programs->isNotEmpty()) {
        $this->program_id = $this->programs->first()->id;
    }
});

rules([
    'program_id' => 'required|exists:programs,id',
    'nik' => 'required|string|max:16|unique:students,nik',
    'nisn' => 'nullable|string|max:10',
    'nama_lengkap' => 'required|string|max:255',
    'tempat_lahir' => 'nullable|string|max:100',
    'tanggal_lahir' => 'nullable|date',
    'jenis_kelamin' => 'required|in:L,P',
    'alamat' => 'nullable|string',
    'no_hp' => 'nullable|string|max:20',
    'status' => 'required|in:aktif,lulus,nonaktif',
]);

$save = function () {
    $this->validate();

    Student::create([
        'program_id' => $this->program_id,
        'nik' => $this->nik,
        'nisn' => $this->nisn,
        'nama_lengkap' => $this->nama_lengkap,
        'tempat_lahir' => $this->tempat_lahir,
        'tanggal_lahir' => $this->tanggal_lahir,
        'jenis_kelamin' => $this->jenis_kelamin,
        'alamat' => $this->alamat,
        'no_hp' => $this->no_hp,
        'status' => $this->status,
    ]);

    session()->flash('status', 'Warga belajar berhasil dibuat');
    session()->flash('message', 'Data warga belajar berhasil ditambahkan.');
    return $this->redirectRoute('admin.student.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Warga Belajar
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi warga belajar baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Lengkap</span>
                        <x-text-input wire:model="nama_lengkap" placeholder="Nama Lengkap" type="text"
                            :error="$errors->has('nama_lengkap')" />
                        <x-input-error :messages="$errors->get('nama_lengkap')" />
                    </x-input-label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>NIK</span>
                            <x-text-input wire:model="nik" placeholder="Nomor Induk Kependudukan" type="text"
                                :error="$errors->has('nik')" />
                            <x-input-error :messages="$errors->get('nik')" />
                        </x-input-label>

                        <x-input-label>
                            <span>NISN</span>
                            <x-text-input wire:model="nisn" placeholder="Nomor Induk Siswa Nasional" type="text"
                                :error="$errors->has('nisn')" />
                            <x-input-error :messages="$errors->get('nisn')" />
                        </x-input-label>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Tempat Lahir</span>
                            <x-text-input wire:model="tempat_lahir" placeholder="Tempat Lahir" type="text"
                                :error="$errors->has('tempat_lahir')" />
                            <x-input-error :messages="$errors->get('tempat_lahir')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Tanggal Lahir</span>
                            <x-text-input wire:model="tanggal_lahir" type="date"
                                :error="$errors->has('tanggal_lahir')" />
                            <x-input-error :messages="$errors->get('tanggal_lahir')" />
                        </x-input-label>
                    </div>

                    <x-input-label>
                        <span>Jenis Kelamin</span>
                        <div class="flex space-x-4 pt-2">
                            <label class="inline-flex items-center space-x-2">
                                <input wire:model="jenis_kelamin" value="L"
                                    class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent-light dark:checked:bg-accent-light dark:hover:border-accent-light dark:focus:border-accent-light"
                                    type="radio" />
                                <span>Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                                <input wire:model="jenis_kelamin" value="P"
                                    class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent-light dark:checked:bg-accent-light dark:hover:border-accent-light dark:focus:border-accent-light"
                                    type="radio" />
                                <span>Perempuan</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Alamat</span>
                        <x-textarea-input wire:model="alamat" rows="3" placeholder="Alamat Lengkap..."
                            :error="$errors->has('alamat')">
                        </x-textarea-input>
                        <x-input-error :messages="$errors->get('alamat')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Nomor HP</span>
                        <x-text-input wire:model="no_hp" placeholder="08xxxxxxxxxx" type="text"
                            :error="$errors->has('no_hp')" />
                        <x-input-error :messages="$errors->get('no_hp')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan Akademik
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Program Pendidikan</span>
                        <x-select-input wire:model="program_id" :error="$errors->has('program_id')">
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('program_id')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            <option value="aktif">Aktif</option>
                            <option value="lulus">Lulus</option>
                            <option value="nonaktif">Nonaktif</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('status')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Warga Belajar
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>