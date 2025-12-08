<?php

use function Livewire\Volt\{state, mount};
use App\Models\Program;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\ClassGroup;

state([
    'programsCount' => 0,
    'tutorsCount' => 0,
    'studentsCount' => 0,
    'rombelsCount' => 0,
]);

use Illuminate\Support\Facades\DB;

mount(function () {
    // dd('STATS COMPONENT LOADED'); 
    $stats = DB::query()
        ->selectSub(Program::where('status', 'aktif')->selectRaw('count(*)'), 'programs')
        ->selectSub(Tutor::where('status', 'aktif')->selectRaw('count(*)'), 'tutors')
        ->selectSub(Student::where('status', 'aktif')->selectRaw('count(*)'), 'students')
        ->selectSub(ClassGroup::selectRaw('count(*)'), 'rombels')
        ->first();

    $this->programsCount = $stats->programs;
    $this->tutorsCount = $stats->tutors;
    $this->studentsCount = $stats->students;
    $this->rombelsCount = $stats->rombels;
});

?>

<section class="bg-primary py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Terus Berkembang Bersama Kami
            </h2>
            <p class="mt-3 text-xl text-indigo-200 sm:mt-4">
                Bergabunglah dengan komunitas belajar yang dinamis dan suportif.
            </p>
        </div>
        <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-2 sm:gap-8 lg:grid-cols-4">
            <div class="flex flex-col">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">Program</dt>
                <dd class="order-1 text-5xl font-extrabold text-white">{{ $programsCount }}</dd>
            </div>
            <div class="flex flex-col mt-10 sm:mt-0">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">Tutor</dt>
                <dd class="order-1 text-5xl font-extrabold text-white">{{ $tutorsCount }}</dd>
            </div>
            <div class="flex flex-col mt-10 sm:mt-0">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">Siswa</dt>
                <dd class="order-1 text-5xl font-extrabold text-white">{{ $studentsCount }}</dd>
            </div>
            <div class="flex flex-col mt-10 sm:mt-0">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">Rombel</dt>
                <dd class="order-1 text-5xl font-extrabold text-white">{{ $rombelsCount }}</dd>
            </div>
        </dl>
    </div>
</section>