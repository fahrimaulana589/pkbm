<?php

use App\Models\Ppdb;
use App\Models\DataPpdb;
use App\Models\Pendaftar;
use App\Models\Program;
use App\Enums\PendaftarStatus;
use App\Enums\DataPpdbType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, mount, rules};

state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'birth_place' => '',
    'birth_date' => '',
    'program_id' => '',
    'extra_attributes' => [],
    'activePpdb' => null,
    'ppdbAttributes' => [],
    'programs' => [],
]);

mount(function () {
    $this->activePpdb = Ppdb::where('status', 'open')->latest()->first();
    
    if ($this->activePpdb) {
        $this->programs = Program::all();
        $this->ppdbAttributes = DataPpdb::where('ppdb_id', $this->activePpdb->id)
            ->where('status', 'active') // Assuming 'active' is the status for visible attributes
            ->get();
            
        // Initialize extra attributes keys
        foreach($this->ppdbAttributes as $attr) {
            $key = Str::slug($attr->nama, '_');
            $this->extra_attributes[$key] = '';
        }
    }
});

$save = function () {
    if (!$this->activePpdb) return;

    // Build Rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'max:255', Rule::unique('pendaftars')],
        'phone' => ['required', 'string', 'max:20', Rule::unique('pendaftars')],
        'address' => 'required|string',
        'birth_place' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'program_id' => 'required|exists:programs,id',
    ];

    foreach ($this->ppdbAttributes as $attr) {
        $key = Str::slug($attr->nama, '_');
        $fieldRule = ['nullable']; // Default nullable
        
        // Check if required (assuming logic, or always required if active?)
        // User requested "jika data wajib disisi tambahkan *" implies some are optional.
        // But DataPpdb structure might not have 'is_required' column yet?
        // Checking DataPpdb model earlier, no is_required. 
        // For now, I will treat all Active DataPpdb as required if implied, 
        // OR simply make them required since they are "Data PPDB" requested by admin.
        // Let's assume required for now as standard for 'active' attributes.
        $fieldRule = ['required'];

        if ($attr->jenis === DataPpdbType::NUMBER) {
             $fieldRule[] = 'numeric';
        } elseif ($attr->jenis === DataPpdbType::DATE) {
             $fieldRule[] = 'date';
        }
        
        $rules['extra_attributes.' . $key] = $fieldRule;
    }

    $this->validate($rules);

    // Save
    $code = Pendaftar::generateUniqueCode();
    
    Pendaftar::create([
        'ppdb_id' => $this->activePpdb->id,
        'program_id' => $this->program_id,
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'birth_place' => $this->birth_place,
        'birth_date' => $this->birth_date,
        'status' => PendaftarStatus::TERDAFTAR,
        'code' => $code,
        'extra_attributes' => $this->extra_attributes,
    ]);

    session()->flash('success_registration', true);
    session()->flash('registration_code', $code);
    
    return $this->redirectRoute('ppdb.check', navigate: true);
};

?>

<div>
    <div class="card p-4 sm:p-5">
        @if($activePpdb)
            <div class="mb-6">
                <h3 class="text-xl font-medium text-slate-700 dark:text-navy-100">
                    Formulir Pendaftaran
                </h3>
                <p class="text-slate-500 text-sm">Isi data diri anda dengan benar untuk mendaftar pada <span class="font-bold text-primary dark:text-accent-light">{{ $activePpdb->name }}</span></p>
            </div>

            <form wire:submit="save" class="space-y-4">
                {{-- Program Selection --}}
                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Pilih Program <span class="text-error">*</span></span>
                    <select wire:model="program_id"
                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                        <option value="">-- Pilih Program Keahlian --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                        @endforeach
                    </select>
                    @error('program_id') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Nama Lengkap <span class="text-error">*</span></span>
                        <input wire:model="name"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="text" placeholder="Nama sesuai ijazah" />
                        @error('name') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Email <span class="text-error">*</span></span>
                        <input wire:model="email"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="email" placeholder="Contoh: ahmad@gmail.com" />
                        @error('email') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Nomor HP/WA <span class="text-error">*</span></span>
                        <input wire:model="phone"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="text" placeholder="Contoh: 081234567890" />
                        @error('phone') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Tempat Lahir <span class="text-error">*</span></span>
                        <input wire:model="birth_place"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="text" />
                        @error('birth_place') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Tanggal Lahir <span class="text-error">*</span></span>
                        <input wire:model="birth_date"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="date" />
                        @error('birth_date') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>
                </div>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Alamat Lengkap <span class="text-error">*</span></span>
                    <textarea wire:model="address" rows="3"
                        class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        placeholder="Alamat lengkap domisili saat ini"></textarea>
                    @error('address') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                {{-- Dynamic Attributes --}}
                @if($ppdbAttributes->isNotEmpty())
                    <div class="h-px bg-slate-200 dark:bg-navy-500 my-4"></div>
                    <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Data Tambahan</h4>
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($ppdbAttributes as $attr)
                            @php
                                $key = Str::slug($attr->nama, '_');
                            @endphp
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">
                                    {{ $attr->nama }} <span class="text-error">*</span>
                                </span>
                                
                                @if($attr->jenis === DataPpdbType::TEXTAREA)
                                    <textarea wire:model="extra_attributes.{{ $key }}" rows="2"
                                        class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                                @elseif($attr->jenis === DataPpdbType::DATE)
                                    <input wire:model="extra_attributes.{{ $key }}" type="date"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @elseif($attr->jenis === DataPpdbType::NUMBER)
                                    <input wire:model="extra_attributes.{{ $key }}" type="number"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @else
                                    <input wire:model="extra_attributes.{{ $key }}" type="text"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @endif
                                
                                @error('extra_attributes.' . $key) <span class="text-tiny text-error">{{ $message }}</span> @enderror
                            </label>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="btn min-w-[10rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        @else
            <div class="flex flex-col items-center justify-center py-10 text-center">
                <div class="bg-warning/10 text-warning rounded-full p-3 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">Pendaftaran Ditutup</h3>
                <p class="text-slate-500 mt-2">Saat ini tidak ada periode PPDB yang sedang aktif. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>
</div>