<?php

use App\Models\Pendaftar;
use App\Models\DataPpdb;
use App\Models\Program; // Assuming Program model exists
use App\Enums\DataPpdbType; // Assuming Enum exists
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, mount, rules, uses};

state([
    'pendaftar' => null,
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'birth_place' => '',
    'birth_date' => '',
    'status' => '',
    'program_id' => '',
    'extra_attributes' => [],
    'dataPpdbMap' => [],
    'programs' => [],
]);

mount(function ($id) {
    $this->pendaftar = Pendaftar::findOrFail($id);

    $this->name = $this->pendaftar->name;
    $this->email = $this->pendaftar->email;
    $this->phone = $this->pendaftar->phone;
    $this->address = $this->pendaftar->address;
    $this->birth_place = $this->pendaftar->birth_place;
    $this->birth_date = $this->pendaftar->birth_date;
    $this->status = $this->pendaftar->status;
    $this->program_id = $this->pendaftar->program_id;
    $this->extra_attributes = $this->pendaftar->extra_attributes->all();

    // Load DataPpdb definitions to assist with Labels and Types
    // Keying by slug to match extra_attributes keys
    $this->dataPpdbMap = DataPpdb::all()->mapWithKeys(function ($item) {
        return [Str::slug($item->nama, '_') => $item];
    })->toArray();

    $this->programs = Program::all();
});

$save = function () {
    $rules = [
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'max:255', Rule::unique('pendaftars')->ignore($this->pendaftar->id)],
        'phone' => ['required', 'string', 'max:20', Rule::unique('pendaftars')->ignore($this->pendaftar->id)],
        'address' => 'required|string',
        'birth_place' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'status' => ['required', Rule::enum(\App\Enums\PendaftarStatus::class)],
        'program_id' => 'required|exists:programs,id',
    ];

    // Add validation for extra_attributes if needed, mostly nullable for admin edit flexibility
    foreach ($this->extra_attributes as $key => $value) {
        $rules['extra_attributes.' . $key] = 'nullable';
    }

    $this->validate($rules);

    $this->pendaftar->update([
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'birth_place' => $this->birth_place,
        'birth_date' => $this->birth_date,
        'status' => $this->status,
        'program_id' => $this->program_id,
        'extra_attributes' => $this->extra_attributes,
    ]);

    session()->flash('message', 'Data Pendaftar berhasil diperbarui.');

    $this->dispatch('pendaftar-updated');
};

// Helper to get definition
$getDefinition = function ($key) {
    return $this->dataPpdbMap[$key] ?? null;
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Pendaftar
                </h2>
            </div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    {{-- Core Fields --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-input-label>
                            <span>Nama Lengkap</span>
                            <x-text-input wire:model="name" type="text" :error="$errors->has('name')" />
                            <x-input-error :messages="$errors->get('name')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Email</span>
                            <x-text-input wire:model="email" type="email" :error="$errors->has('email')" />
                            <x-input-error :messages="$errors->get('email')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Nomor HP/WA</span>
                            <x-text-input wire:model="phone" type="text" :error="$errors->has('phone')" />
                            <x-input-error :messages="$errors->get('phone')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Tempat Lahir</span>
                            <x-text-input wire:model="birth_place" type="text" :error="$errors->has('birth_place')" />
                            <x-input-error :messages="$errors->get('birth_place')" />
                        </x-input-label>

                        <x-input-label>
                            <span>Tanggal Lahir</span>
                            <x-text-input wire:model="birth_date" type="date" :error="$errors->has('birth_date')" />
                            <x-input-error :messages="$errors->get('birth_date')" />
                        </x-input-label>
                    </div>

                    <x-input-label>
                        <span>Alamat Lengkap</span>
                        <x-textarea-input wire:model="address" rows="3" :error="$errors->has('address')" />
                        <x-input-error :messages="$errors->get('address')" />
                    </x-input-label>

                    {{-- Dynamic Fields --}}
                    @if(!empty($extra_attributes))
                        <div class="h-px bg-slate-200 dark:bg-navy-500 my-4"></div>
                        <h3 class="text-base font-medium text-slate-800 dark:text-navy-50">Data Tambahan</h3>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($extra_attributes as $key => $value)
                                @php
                                    $def = $this->getDefinition($key);
                                    $label = $def ? $def['nama'] : ucwords(str_replace('_', ' ', $key));
                                    $type = $def ? $def['jenis'] : 'TEXT';
                                @endphp
                                <x-input-label>
                                    <span>{{ $label }}</span>

                                    @if($type === \App\Enums\DataPpdbType::TEXTAREA)
                                        <x-textarea-input wire:model="extra_attributes.{{ $key }}" rows="2" />
                                    @elseif($type === \App\Enums\DataPpdbType::DATE)
                                        <x-text-input wire:model="extra_attributes.{{ $key }}" type="date" />
                                    @elseif($type === \App\Enums\DataPpdbType::NUMBER)
                                        <x-text-input wire:model="extra_attributes.{{ $key }}" type="number" />
                                    @else
                                        <!-- Default / Text -->
                                        <x-text-input wire:model="extra_attributes.{{ $key }}" type="text" />
                                    @endif
                                </x-input-label>
                            @endforeach
                        </div>
                    @endif
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
                        <span>Program</span>
                        <x-select-input wire:model="program_id" :error="$errors->has('program_id')">
                            <option value="">Pilih Program</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                            @endforeach
                        </x-select-input>
                        <x-input-error :messages="$errors->get('program_id')" />
                    </x-input-label>

                    <x-input-label>
                        <span>Status</span>
                        <x-select-input wire:model="status" :error="$errors->has('status')">
                            @foreach(\App\Enums\PendaftarStatus::cases() as $case)
                                <option value="{{ $case->value }}">{{ $case->label() }}</option>
                            @endforeach
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

    <x-success-modal trigger="pendaftar-updated" message="Data pendaftar berhasil diperbarui." />
</div>