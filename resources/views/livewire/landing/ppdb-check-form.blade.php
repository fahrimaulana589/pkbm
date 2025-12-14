<?php
use App\Models\Pendaftar;
use function Livewire\Volt\{state, rules};

state(['code' => '', 'result' => null, 'feedbackMessage' => '']);

rules(['code' => 'required|string']);

$check = function () {
    $this->validate();

    $this->result = Pendaftar::where('code', $this->code)->first();

    if (!$this->result) {
        $this->feedbackMessage = 'Data pendaftar dengan kode tersebut tidak ditemukan.';
    } else {
        $this->feedbackMessage = '';
    }
};
?>

<div>
    {{-- Success Message from Registration --}}
    @if(session('success_registration'))
        <div class="bg-success/10 border border-success/20 rounded-lg p-6 mb-8 text-center animate-fade-in-up">
            <div class="inline-flex items-center justify-center p-3 bg-success/20 rounded-full text-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-success mb-2">Pendaftaran Berhasil!</h2>
            <p class="text-slate-600 dark:text-navy-200 mb-6">Terima kasih telah mendaftar. Data Anda telah kami simpan.
            </p>

            <div
                class="bg-white dark:bg-navy-700 p-6 rounded-xl shadow-lg border-2 border-dashed border-primary/50 max-w-md mx-auto relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-2 opacity-50">
                    <svg class="w-16 h-16 text-primary/10" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z" />
                    </svg>
                </div>

                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kode Pendaftaran Anda</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-navy-100 tracking-widest font-mono my-2 select-all cursor-text"
                    onclick="navigator.clipboard.writeText('{{ session('registration_code') }}'); alert('Kode berhasil disalin!')"
                    title="Klik untuk menyalin">
                    {{ session('registration_code') }}
                </h3>
                <p class="text-xs text-error font-semibold mt-2 animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    HARAP SIMPAN / COPY KODE INI
                </p>
                <p class="text-xs text-slate-500 mt-3 border-t pt-2 dark:border-navy-600">
                    Kode juga telah dikirim ke email Anda. Gunakan kode ini untuk mengecek status pendaftaran.
                </p>
            </div>
        </div>
    @endif

    {{-- Check Form --}}
    <div class="card p-6 max-w-xl mx-auto">
        <h3 class="text-lg font-medium text-slate-700 dark:text-navy-100 mb-4 text-center">Cek Status Pendaftaran
        </h3>

        <form wire:submit="check" class="space-y-4">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Masukkan Kode Pendaftaran</span>
                <div class="flex mt-1.5 space-x-2">
                    <input wire:model="code"
                        class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                        type="text" placeholder="Contoh: 123456" />
                    <button type="submit"
                        class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Cek
                    </button>
                </div>
                @error('code') <span class="text-tiny text-error">{{ $message }}</span> @enderror
            </label>
        </form>

        @if($feedbackMessage)
            <div class="mt-4 p-3 bg-error/10 text-error rounded-lg text-sm text-center">
                {{ $feedbackMessage }}
            </div>
        @endif

        @if($result)
            <div class="mt-6 border-t pt-4 dark:border-navy-600">
                <h4 class="font-medium text-slate-700 dark:text-navy-100 mb-3">Hasil Pencarian:</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2 border-slate-100 dark:border-navy-600">
                        <span class="text-slate-500">Nama Lengkap</span>
                        <span class="font-medium text-slate-700 dark:text-navy-100">{{ $result->name }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2 border-slate-100 dark:border-navy-600">
                        <span class="text-slate-500">Program</span>
                        <span
                            class="font-medium text-slate-700 dark:text-navy-100">{{ $result->program->nama_program ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2 border-slate-100 dark:border-navy-600">
                        <span class="text-slate-500">Status</span>
                        <span class="badge rounded-full 
                                                        @if($result->status === \App\Enums\PendaftarStatus::DITERIMA) bg-success/10 text-success
                                                        @elseif($result->status === \App\Enums\PendaftarStatus::DITOLAK) bg-error/10 text-error
                                                        @elseif($result->status === \App\Enums\PendaftarStatus::DIPROSES) bg-info/10 text-info
                                                        @else bg-warning/10 text-warning @endif">
                            {{ $result->status->label() }}
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>