<?php

use App\Models\Pendaftar;
use App\Enums\PendaftarStatus;
use function Livewire\Volt\{computed};

$stats = computed(function () {
  return [
    'total' => Pendaftar::count(),
    'terdaftar' => Pendaftar::where('status', PendaftarStatus::TERDAFTAR)->count(),
    'diproses' => Pendaftar::where('status', PendaftarStatus::DIPROSES)->count(),
    'diterima' => Pendaftar::where('status', PendaftarStatus::DITERIMA)->count(),
    'ditolak' => Pendaftar::where('status', PendaftarStatus::DITOLAK)->count(),
  ];
});

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
  <!-- Stats -->
  <div class="col-span-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5 lg:gap-6">
    <!-- Total Card -->
    <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-primary/20 cursor-pointer">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Total Pendaftar</p>
          <div class="mt-2 flex items-baseline space-x-1">
            <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['total'] }}</span>
          </div>
        </div>
        <div
          class="flex size-10 items-center justify-center rounded-lg bg-primary/10 text-primary dark:bg-accent/10 dark:text-accent-light">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Terdaftar Card -->
    <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-info/20 cursor-pointer">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Baru Terdaftar</p>
          <div class="mt-2 flex items-baseline space-x-1">
            <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['terdaftar'] }}</span>
          </div>
        </div>
        <div
          class="flex size-10 items-center justify-center rounded-lg bg-info/10 text-info dark:bg-accent/10 dark:text-accent-light">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Diproses Card -->
    <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-warning/20 cursor-pointer">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Sedang Diproses</p>
          <div class="mt-2 flex items-baseline space-x-1">
            <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['diproses'] }}</span>
          </div>
        </div>
        <div
          class="flex size-10 items-center justify-center rounded-lg bg-warning/10 text-warning dark:bg-accent/10 dark:text-accent-light">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Diterima Card -->
    <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-success/20 cursor-pointer">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Diterima</p>
          <div class="mt-2 flex items-baseline space-x-1">
            <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['diterima'] }}</span>
          </div>
        </div>
        <div
          class="flex size-10 items-center justify-center rounded-lg bg-success/10 text-success dark:bg-accent/10 dark:text-accent-light">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Ditolak Card -->
    <div class="card p-4 transition-all duration-200 hover:shadow-lg hover:shadow-error/20 cursor-pointer">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-xs+ font-medium uppercase text-slate-500 dark:text-navy-200">Ditolak</p>
          <div class="mt-2 flex items-baseline space-x-1">
            <span class="text-2xl font-bold text-slate-700 dark:text-navy-100">{{ $this->stats['ditolak'] }}</span>
          </div>
        </div>
        <div
          class="flex size-10 items-center justify-center rounded-lg bg-error/10 text-error dark:bg-accent/10 dark:text-accent-light">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>