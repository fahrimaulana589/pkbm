<?php

use App\Models\Ppdb;
use App\Models\DataPpdb;
use App\Models\Pendaftar;
use App\Forms\PpdbRegistrationForm;
use Kris\LaravelFormBuilder\FormBuilder;
use function Livewire\Volt\{state, mount, rules, uses};

$getForm = function (FormBuilder $formBuilder) {
    // Fetch active PPDB (assuming latest active or similar logic, simplistic for now)
    $activePpdb = Ppdb::where('status', 'open')->latest()->first();

    if (!$activePpdb) {
        return null;
    }

    return $formBuilder->create(PpdbRegistrationForm::class, [
        'method' => 'POST',
        'url' => route('ppdb.daftar'), // Use existing route or current page
        'model' => [], // Model data
        'data' => ['ppdb_id' => $activePpdb->id],
        'form_options' => [
            'attr' => ['wire:submit.prevent' => 'save']
        ]
    ]);
};

state([
    'name' => '',
    'email' => '',
    'phone' => '',
    'address' => '',
    'birth_place' => '',
    'birth_date' => '',
    'extra_attributes' => [],
    'activePpdb' => null,
    'ppdb_id' => null
]);

mount(function () {
    $this->activePpdb = Ppdb::where('status', 'open')->latest()->first();
    if ($this->activePpdb) {
        $this->ppdb_id = $this->activePpdb->id;
    }
});

$save = function (FormBuilder $formBuilder) {
    if (!$this->ppdb_id)
        return;

    // Validate Standard Fields (Simple approach, ideal is extracting from Form)
    // For now hardcoding core rules + dynamic rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:pendaftars,email', // Basic unique check
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'birth_place' => 'required|string|max:255',
        'birth_date' => 'required|date',
    ];

    // Dynamic Rules
    $attributes = DataPpdb::where('ppdb_id', $this->ppdb_id)
        ->where('status', '!=', 'inactive')
        ->get();

    foreach ($attributes as $attr) {
        $rule = $attr->status === 'active' ? 'required' : 'nullable';
        // Add specific type validation if needed
        $key = \Illuminate\Support\Str::slug($attr->nama, '_');
        $rules['extra_attributes.' . $key] = $rule;
    }

    $this->validate($rules);

    Pendaftar::create([
        'program_id' => 1, // DUMMY: Needs dynamic program selection or context
        'name' => $this->name,
        'email' => $this->email,
        'phone' => $this->phone,
        'address' => $this->address,
        'birth_place' => $this->birth_place,
        'birth_date' => $this->birth_date,
        'status' => 'pending',
        'code' => 'REG-' . strtoupper(uniqid()),
        'extra_attributes' => $this->extra_attributes,
    ]);

    session()->flash('message', 'Pendaftaran Berhasil! Data Anda telah tersimpan.');

    // Reset form
    $this->reset(['name', 'email', 'phone', 'address', 'birth_place', 'birth_date', 'extra_attributes']);
};

?>

<div>
    <div class="card p-4 sm:p-5">
        @if (session()->has('message'))
            <div class="alert flex rounded-lg bg-success/10 py-4 px-4 text-success dark:bg-success/15 mb-4">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        @if($activePpdb)
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100">
                    Formulir Pendaftaran
                </h3>
            </div>

            {{-- Render the form --}}
            {!! form($this->getForm(app(FormBuilder::class))) !!}
        @else
            <div class="alert flex rounded-lg bg-warning/10 py-4 px-4 text-warning dark:bg-warning/15">
                <p>Tidak ada PPDB yang aktif saat ini.</p>
            </div>
        @endif
    </div>
</div>