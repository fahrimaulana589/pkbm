<?php

use App\Models\Schedule;
use App\Models\ClassGroup;
use function Livewire\Volt\{state, rules, mount};

state([
    'schedule' => null,
    'rombel_id' => '',
    'hari' => '',
    'jam_mulai' => '',
    'jam_selesai' => '',
    'materi' => '',
    'classGroups' => [],
]);

mount(function ($id) {
    $this->schedule = Schedule::findOrFail($id);
    $this->classGroups = ClassGroup::all();

    $this->rombel_id = $this->schedule->rombel_id;
    $this->hari = $this->schedule->hari;
    $this->jam_mulai = \Carbon\Carbon::parse($this->schedule->jam_mulai)->format('H:i');
    $this->jam_selesai = \Carbon\Carbon::parse($this->schedule->jam_selesai)->format('H:i');
    $this->materi = $this->schedule->materi;
});

rules([
    'rombel_id' => 'required|exists:class_groups,id',
    'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
    'jam_mulai' => 'required|date_format:H:i',
    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    'materi' => 'required|string|max:255',
]);

$save = function () {
    $this->validate();

    $this->schedule->update([
        'rombel_id' => $this->rombel_id,
        'hari' => $this->hari,
        'jam_mulai' => $this->jam_mulai,
        'jam_selesai' => $this->jam_selesai,
        'materi' => $this->materi,
    ]);

    $this->dispatch('schedule-updated');
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Jadwal
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Perbarui detail informasi jadwal belajar.
                </p>
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Materi Pelajaran</span>
                        <x-text-input wire:model="materi" placeholder="Contoh: Matematika Dasar" type="text"
                            :error="$errors->has('materi')" />
                        <x-input-error :messages="$errors->get('materi')" />
                    </x-input-label>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Jam Mulai</span>
                            <x-text-input wire:model="jam_mulai" type="time" :error="$errors->has('jam_mulai')" />
                            <x-input-error :messages="$errors->get('jam_mulai')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Jam Selesai</span>
                            <x-text-input wire:model="jam_selesai" type="time" :error="$errors->has('jam_selesai')" />
                            <x-input-error :messages="$errors->get('jam_selesai')" />
                        </x-input-label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Pengaturan
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label>
                        <span>Rombel</span>
                        <x-select-input wire:model="rombel_id" :error="$errors->has('rombel_id')">
                            @foreach($classGroups as $group)
                                <option value="{{ $group->id }}">{{ $group->nama_rombel }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('rombel_id')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Hari</span>
                        <x-select-input wire:model="hari" :error="$errors->has('hari')">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </x-select-input>
                        <x-input-error :messages="$errors->get('hari')" />
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

    <x-success-modal trigger="schedule-updated" message="Data jadwal berhasil diperbarui." />
</div>