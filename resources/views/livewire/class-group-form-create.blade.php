<?php

use App\Models\ClassGroup;
use App\Models\Program;
use App\Models\Tutor;
use function Livewire\Volt\{state, rules, mount};

state([
    'program_id' => '',
    'tutor_id' => '',
    'nama_rombel' => '',
    'periode' => '',
    'programs' => [],
    'tutors' => [],
]);

mount(function () {
    $this->programs = Program::where('status', 'aktif')->get();
    $this->tutors = Tutor::where('status', 'aktif')->get();

    if ($this->programs->isNotEmpty()) {
        $this->program_id = $this->programs->first()->id;
    }
    if ($this->tutors->isNotEmpty()) {
        $this->tutor_id = $this->tutors->first()->id;
    }
});

rules([
    'program_id' => 'required|exists:programs,id',
    'tutor_id' => 'required|exists:tutors,id',
    'nama_rombel' => 'required|string|max:255',
    'periode' => 'required|string|max:255',
]);

$save = function () {
    $this->validate();

    ClassGroup::create([
        'program_id' => $this->program_id,
        'tutor_id' => $this->tutor_id,
        'nama_rombel' => $this->nama_rombel,
        'periode' => $this->periode,
    ]);

    session()->flash('status', 'Rombel berhasil dibuat');
    session()->flash('message', 'Data rombel berhasil ditambahkan.');
    return $this->redirectRoute('admin.rombel.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Rombel
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi rombel baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nama Rombel</span>
                        <x-text-input wire:model="nama_rombel" placeholder="Contoh: Paket C Rombel 1" type="text"
                            :error="$errors->has('nama_rombel')" />
                        <x-input-error :messages="$errors->get('nama_rombel')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Periode</span>
                        <x-text-input wire:model="periode" placeholder="Contoh: 2024/2025" type="text"
                            :error="$errors->has('periode')" />
                        <x-input-error :messages="$errors->get('periode')" />
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
                        <span>Tutor / Wali Kelas</span>
                        <x-select-input wire:model="tutor_id" :error="$errors->has('tutor_id')">
                            @foreach($tutors as $tutor)
                                <option value="{{ $tutor->id }}">{{ $tutor->nama }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('tutor_id')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Rombel
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>