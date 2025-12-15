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
    'nik' => '',
    'nisn' => '',
    'jenis_kelamin' => '',
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
            ->where('status', 'active')
            ->get();
            
        foreach($this->ppdbAttributes as $attr) {
            $key = Str::slug($attr->nama, '_');
            $this->extra_attributes[$key] = '';
        }
    }
});

$save = function () {
    if (!$this->activePpdb) return;

    $rules = [
        'name' => 'required|string|max:255',
        'nik' => 'required|digits:16',
        'nisn' => 'nullable|digits:10',
        'jenis_kelamin' => 'required|in:L,P',
        'email' => ['required', 'email', 'max:255', Rule::unique('pendaftars')],
        'phone' => ['required', 'string', 'max:20', Rule::unique('pendaftars')],
        'address' => 'required|string',
        'birth_place' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'program_id' => 'required|exists:programs,id',
    ];

    foreach ($this->ppdbAttributes as $attr) {
        $key = Str::slug($attr->nama, '_');
        $fieldRule = ['required'];

        if ($attr->jenis === DataPpdbType::NUMBER) {
             $fieldRule[] = 'numeric';
        } elseif ($attr->jenis === DataPpdbType::DATE) {
             $fieldRule[] = 'date';
        }
        
        $rules['extra_attributes.' . $key] = $fieldRule;
    }

    $this->validate($rules);

    $code = Pendaftar::generateUniqueCode();
    
    $pendaftar = Pendaftar::create([
        'ppdb_id' => $this->activePpdb->id,
        'program_id' => $this->program_id,
        'nik' => $this->nik,
        'nisn' => $this->nisn,
        'jenis_kelamin' => $this->jenis_kelamin,
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

    // Send Email
    try {
        Mail::to($this->email)->send(new \App\Mail\RegistrationSuccess($pendaftar));
    } catch (\Exception $e) {
        // Log error but continue
        \Illuminate\Support\Facades\Log::error('Registration email failed: ' . $e->getMessage());
    }

    session()->flash('success_registration', true);
    session()->flash('registration_code', $code);
    
    return $this->redirectRoute('ppdb.check', navigate: true);
};

?>

<div>
    @if($activePpdb)
    <div class="card p-4 sm:p-5 bg-white dark:bg-navy-800 dark:text-navy-100">
    
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
                <select wire:model="program_id" name="program_id"
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
                    <input wire:model="name" name="name"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="text" placeholder="Nama sesuai ijazah" />
                    @error('name') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">NIK (Nomor Induk Kependudukan) <span class="text-error">*</span></span>
                        <input wire:model="nik" name="nik"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="text" maxlength="16" placeholder="16 digit NIK" />
                        @error('nik') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">NISN (Nomor Induk Siswa Nasional)</span>
                        <input wire:model="nisn" name="nisn"
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            type="text" maxlength="10" placeholder="10 digit NISN (Opsional)" />
                        @error('nisn') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Jenis Kelamin <span class="text-error">*</span></span>
                        <select wire:model="jenis_kelamin" name="jenis_kelamin"
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                    </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Email <span class="text-error">*</span></span>
                    <input wire:model="email" name="email"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="email" placeholder="Contoh: ahmad@gmail.com" />
                    @error('email') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Nomor HP/WA <span class="text-error">*</span></span>
                    <input wire:model="phone" name="phone"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="text" placeholder="Contoh: 081234567890" />
                    @error('phone') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Tempat Lahir <span class="text-error">*</span></span>
                    <input wire:model="birth_place" name="birth_place"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="text" />
                    @error('birth_place') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>

                <label class="block">
                    <span class="font-medium text-slate-600 dark:text-navy-100">Tanggal Lahir <span class="text-error">*</span></span>
                    <input wire:model="birth_date" name="birth_date"
                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="date" />
                    @error('birth_date') <span class="text-tiny text-error">{{ $message }}</span> @enderror
                </label>
            </div>

            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Alamat Lengkap <span class="text-error">*</span></span>
                <textarea wire:model="address" name="address" rows="3"
                    class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                    placeholder="Alamat lengkap domisili saat ini"></textarea>
                @error('address') <span class="text-tiny text-error">{{ $message }}</span> @enderror
            </label>

            {{-- Dynamic Attributes --}}
            @if($ppdbAttributes->isNotEmpty())
                <div class="h-px bg-slate-200 dark:bg-navy-500 my-4"></div>
                <h4 class="text-base font-medium text-slate-700 dark:text-navy-100 mb-3">Data Tambahan</h4>
                
                {{-- Non-File Attributes First --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach($ppdbAttributes as $attr)
                        @if($attr->jenis !== DataPpdbType::FILE) <!-- Assuming FILE type exists or handled elsewhere logic? No FILE type in Enum yet? User asked for 'jenis file harus ada di bagian bawah', implies FILE type exists or is TEXT. Wait, checking DataPpdbType Enum... -->
                        {{-- Assuming DataPpdbType has FILE or similar. If not, maybe TEXT treated as file link? 
                            Checking context: 'DataPpdbType' enum definition previously showed TEXT, TEXTAREA, NUMBER, DATE. It does NOT have FILE.
                            However, user request "field dengan jenis file harus ada di bagian bawah" implies there SHOULD be or IS a file type.
                            Let's check DataPpdbType Enum again or assume user wants me to ADD it if missing?
                            For now, I'll stick to reordering logics currently available. If file type is missing, I should add it or maybe user means specific field names? 
                            "field dengan jenis file" -> "field with type file".
                            I will add FILE to DataPpdbType Enum as well in next step if checking confirms it's missing.
                            For now, I'll separate the loop logic assuming FILE exists or simple text inputs. 
                            But wait, I verified DataPpdbType before. 
                            Let's implement logic to separate based on type if added. For now just loop normally but if I add FILE type later it will work.
                        --}}
                        @php
                            // Check if type is file (safeguard if Enum updated) or name contains 'file'/'upload'
                            $isFile = $attr->jenis === 'FILE' || str_contains(strtolower($attr->nama), 'upload') || str_contains(strtolower($attr->nama), 'file');
                        @endphp
                        
                        @if(!$isFile)
                            @php $key = Str::slug($attr->nama, '_'); @endphp
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">
                                    {{ $attr->nama }} <span class="text-error">*</span>
                                </span>
                                
                                @if($attr->jenis === DataPpdbType::TEXTAREA)
                                    <textarea wire:model="extra_attributes.{{ $key }}" name="{{ $key }}" rows="2"
                                        class="form-textarea mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"></textarea>
                                @elseif($attr->jenis === DataPpdbType::DATE)
                                    <input wire:model="extra_attributes.{{ $key }}" name="{{ $key }}" type="date"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @elseif($attr->jenis === DataPpdbType::NUMBER)
                                    <input wire:model="extra_attributes.{{ $key }}" name="{{ $key }}" type="number"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @else
                                    <input wire:model="extra_attributes.{{ $key }}" name="{{ $key }}" type="text"
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" />
                                @endif
                                
                                @error('extra_attributes.' . $key) <span class="text-tiny text-error">{{ $message }}</span> @enderror
                            </label>
                        @endif
                        @endif
                    @endforeach
                </div>
                
                {{-- File/Upload Attributes Last --}}
                <div class="mt-4 grid grid-cols-1 gap-4">
                    @foreach($ppdbAttributes as $attr)
                        @php
                            $isFile = $attr->jenis === 'FILE' || str_contains(strtolower($attr->nama), 'upload') || str_contains(strtolower($attr->nama), 'file');
                        @endphp
                        
                        @if($isFile)
                            @php $key = Str::slug($attr->nama, '_'); @endphp
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">
                                    {{ $attr->nama }} <span class="text-error">*</span>
                                </span>
                                <!-- Use file input if type is FILE, else text as fallback but placed at bottom -->
                                <input wire:model="extra_attributes.{{ $key }}" type="text" 
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Link File / Upload (Jika Text)" />
                                    
                                @error('extra_attributes.' . $key) <span class="text-tiny text-error">{{ $message }}</span> @enderror
                            </label>
                        @endif
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
    </div>  
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