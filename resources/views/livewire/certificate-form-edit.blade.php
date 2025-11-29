<?php

use App\Models\Certificate;
use App\Models\Student;
use App\Models\Program;
use function Livewire\Volt\{state, rules, mount};

state([
    'certificate' => null,
    'student_id' => '',
    'program_id' => '',
    'nomor_sertifikat' => '',
    'tanggal' => '',
    'file_pdf' => '',
    'students' => [],
    'programs' => [],
]);

mount(function ($id) {
    $this->certificate = Certificate::findOrFail($id);
    $this->students = Student::where('status', 'aktif')->get();
    $this->programs = Program::where('status', 'aktif')->get();

    $this->student_id = $this->certificate->student_id;
    $this->program_id = $this->certificate->program_id;
    $this->nomor_sertifikat = $this->certificate->nomor_sertifikat;
    $this->tanggal = $this->certificate->tanggal->format('Y-m-d');
    $this->file_pdf = $this->certificate->file_pdf;
});

rules([
    'student_id' => 'required|exists:students,id',
    'program_id' => 'required|exists:programs,id',
    'nomor_sertifikat' => 'required|string|max:255', // Unique check handled manually if needed or ignore self
    'tanggal' => 'required|date',
    'file_pdf' => 'required|string|max:255',
]);

$save = function () {
    $this->validate();

    // Check uniqueness excluding current record
    $exists = Certificate::where('nomor_sertifikat', $this->nomor_sertifikat)
        ->where('id', '!=', $this->certificate->id)
        ->exists();

    if ($exists) {
        $this->addError('nomor_sertifikat', 'Nomor sertifikat sudah ada.');
        return;
    }

    $this->certificate->update([
        'student_id' => $this->student_id,
        'program_id' => $this->program_id,
        'nomor_sertifikat' => $this->nomor_sertifikat,
        'tanggal' => $this->tanggal,
        'file_pdf' => $this->file_pdf,
    ]);

    $this->dispatch('certificate-updated');
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
                    Perbarui detail informasi sertifikat.
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
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-success-modal trigger="certificate-updated" message="Data sertifikat berhasil diperbarui." />
</div>