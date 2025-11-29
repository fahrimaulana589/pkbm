<?php

use App\Models\Certificate;
use App\Models\Student;
use App\Models\Program;
use function Livewire\Volt\{state, rules, mount};

state([
    'student_id' => '',
    'program_id' => '',
    'nomor_sertifikat' => '',
    'tanggal' => '',
    'file_pdf' => '', // Placeholder for file upload
    'students' => [],
    'programs' => [],
]);

mount(function () {
    $this->students = Student::where('status', 'aktif')->get();
    $this->programs = Program::where('status', 'aktif')->get();

    if ($this->students->isNotEmpty()) {
        $this->student_id = $this->students->first()->id;
    }
    if ($this->programs->isNotEmpty()) {
        $this->program_id = $this->programs->first()->id;
    }
});

rules([
    'student_id' => 'required|exists:students,id',
    'program_id' => 'required|exists:programs,id',
    'nomor_sertifikat' => 'required|string|max:255|unique:certificates,nomor_sertifikat',
    'tanggal' => 'required|date',
    'file_pdf' => 'required|string|max:255', // Simplified for now
]);

$save = function () {
    $this->validate();

    Certificate::create([
        'student_id' => $this->student_id,
        'program_id' => $this->program_id,
        'nomor_sertifikat' => $this->nomor_sertifikat,
        'tanggal' => $this->tanggal,
        'file_pdf' => $this->file_pdf,
    ]);

    session()->flash('status', 'Sertifikat berhasil dibuat');
    session()->flash('message', 'Data sertifikat berhasil ditambahkan.');
    return $this->redirectRoute('admin.sertifikat.index', navigate: true);
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Sertifikat
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Isi detail informasi sertifikat baru.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Nomor Sertifikat</span>
                        <x-text-input wire:model="nomor_sertifikat" placeholder="Contoh: PKBM-2024-00001" type="text"
                            :error="$errors->has('nomor_sertifikat')" />
                        <x-input-error :messages="$errors->get('nomor_sertifikat')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Tanggal Terbit</span>
                        <x-text-input wire:model="tanggal" type="date" :error="$errors->has('tanggal')" />
                        <x-input-error :messages="$errors->get('tanggal')" />
                    </x-input-label>

                    <x-input-label>
                        <span>File PDF (Path/URL)</span>
                        <x-text-input wire:model="file_pdf" placeholder="Contoh: /sertifikat/file.pdf" type="text"
                            :error="$errors->has('file_pdf')" />
                        <x-input-error :messages="$errors->get('file_pdf')" />
                    </x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Penerima & Program
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Siswa / Warga Belajar</span>
                        <x-select-input wire:model="student_id" :error="$errors->has('student_id')">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->nama_lengkap }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('student_id')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Program Pendidikan</span>
                        <x-select-input wire:model="program_id" :error="$errors->has('program_id')">
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('program_id')" />
                    </x-input-label>
                </div>
                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Sertifikat
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>