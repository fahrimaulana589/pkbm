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
        'status' => 'required|string',
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

    $this->redirect(route('ppdb.pendaftar.index'), navigate: true);
};

// Helper to get definition
$getDefinition = function ($key) {
    return $this->dataPpdbMap[$key] ?? null;
};

?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Informasi Pendaftar
                </h2>
            </div>
            <div class="max-w-xl">
                <p>
                    Perbarui detail informasi pendaftar.
                </p>
                <div class="mt-5 flex flex-col gap-4">

                    {{-- Core Fields --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Nama Lengkap</span>
                            <input wire:model="name"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                type="text" />
                            @error('name') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Email</span>
                            <input wire:model="email"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                type="email" />
                            @error('email') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Nomor HP/WA</span>
                            <input wire:model="phone"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                type="text" />
                            @error('phone') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Program</span>
                            <select wire:model="program_id"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="">Pilih Program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                @endforeach
                            </select>
                            @error('program_id') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Tempat Lahir</span>
                            <input wire:model="birth_place"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                type="text" />
                            @error('birth_place') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Tanggal Lahir</span>
                            <input wire:model="birth_date"
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                type="date" />
                            @error('birth_date') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Status</span>
                            <select wire:model="status"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                                <option value="pending">Pending</option>
                                <option value="accepted">Diterima</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                            @error('status') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                        </label>
                    </div>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Alamat Lengkap</span>
                        <textarea wire:model="address" rows="3"
                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                        @error('address') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

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
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">{{ $label }}</span>

                                    @if($type === \App\Enums\DataPpdbType::TEXTAREA)
                                        <textarea wire:model="extra_attributes.{{ $key }}" rows="2"
                                            class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                                    @elseif($type === \App\Enums\DataPpdbType::DATE)
                                        <input wire:model="extra_attributes.{{ $key }}"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            type="date" />
                                    @elseif($type === \App\Enums\DataPpdbType::NUMBER)
                                        <input wire:model="extra_attributes.{{ $key }}"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            type="number" />
                                    @else
                                        <!-- Default / Text / File (treated as text for now) -->
                                        <input wire:model="extra_attributes.{{ $key }}"
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            type="text" />
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-5">
                    <x-primary-button wire:click="save">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>