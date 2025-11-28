<?php

use App\Models\Announcement;
use function Livewire\Volt\{state, computed, mount, rules, validate};

$pengumumans = Announcement::with('penulis')->orderBy('created_at', 'desc')->get();
state('pengumumans',$pengumumans);

$getStatusBadge = fn($status) => match($status) {
    'dipublikasikan' => '<div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">Dipublikasikan</div>',
    'draft' => '<div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">Draft</div>',
    'kadaluarsa' => '<div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">Kadaluarsa</div>',
    'terjadwal' => '<div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">Terjadwal</div>',
    default => '<div class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-500/50 dark:text-navy-200">'.$status.'</div>',
};

$getDateDisplay = fn($date) => !$date ? '-' : \Carbon\Carbon::parse($date)->format('d M Y');

?>

<div>
    <div class="flex items-center space-x-4 py-5 lg:py-6">
          <h2
            class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl"
          >
            Pengumuman
          </h2>
          <div class="hidden h-full py-1 sm:flex">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
          </div>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <!-- Announcement Table -->
        <div>
            <div class="flex items-center justify-between">
                <h2
                class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100"
                >
                Tabel Pengumuman
                </h2>
                <div class="flex">
                <div class="flex items-center" x-data="{isInputActive:false}">
                    <label class="block">
                    <input
                        x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                        :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                        class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                        placeholder="Cari Pengumuman..."
                        type="text"
                    />
                    </label>
                    <button
                    @click="isInputActive = !isInputActive"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-4.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                    </button>
                </div>
                <div
                    x-data="usePopper({placement:'bottom-end',offset:4})"
                    @click.outside="if(isShowPopper) isShowPopper = false"
                    class="inline-flex"
                >
                    <button
                    x-ref="popperRef"
                    @click="isShowPopper = !isShowPopper"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                    >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="size-4.5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                        />
                    </svg>
                    </button>
                    <div
                    x-ref="popperRoot"
                    class="popper-root"
                    :class="isShowPopper && 'show'"
                    >
                    <div
                        class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700"
                    >
                        <ul>
                        <li>
                            <a
                            href="#"
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                            >Tambah Baru</a
                            >
                        </li>
                        <li>
                            <a
                            href="#"
                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                            >Export</a
                            >
                        </li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="card mt-3">
                <div
                class="is-scrollbar-hidden min-w-full overflow-x-auto"
                >
                <table class="is-hoverable w-full text-left">
                    <thead>
                    <tr>
                        <th
                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        #
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Judul
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Kategori
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Prioritas
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Status
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Tanggal Mulai
                        </th>
                        <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Tanggal Akhir
                        </th>
                        <th
                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                        >
                        Aksi
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($this->pengumumans as $index => $pengumuman)
                        <tr
                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500"
                        >
                        <td
                            class="whitespace-nowrap px-4 py-3 sm:px-5"
                        >
                            {{ $index + 1 }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="font-medium text-slate-700 dark:text-navy-100">
                                {{ $pengumuman->judul }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                                {{ \Illuminate\Support\Str::limit($pengumuman->isi, 60) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="text-slate-700 dark:text-navy-100">
                                {{ $pengumuman->kategori }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @if($pengumuman->prioritas === 'Tinggi')
                                <div class="badge rounded-full bg-error/10 text-error">Tinggi</div>
                            @elseif($pengumuman->prioritas === 'Penting')
                                <div class="badge rounded-full bg-warning/10 text-warning">Penting</div>
                            @else
                                <div class="badge rounded-full bg-success/10 text-success">Normal</div>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {!! $this->getStatusBadge($pengumuman->status) !!}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="text-slate-700 dark:text-navy-100">
                                {{ $this->getDateDisplay($pengumuman->start_date) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="text-slate-700 dark:text-navy-100">
                                {{ $this->getDateDisplay($pengumuman->end_date) }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div
                            x-data="usePopper({placement:'bottom-end',offset:4})"
                            @click.outside="if(isShowPopper) isShowPopper = false"
                            class="inline-flex"
                            >
                            <button
                                x-ref="popperRef"
                                @click="isShowPopper = !isShowPopper"
                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                            >
                                <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="size-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 010 2zm7 0a1 1 0 11-2 0 1 1 0 010 2z"
                                />
                                </svg>
                            </button>

                            <div
                                x-ref="popperRoot"
                                class="popper-root"
                                :class="isShowPopper && 'show'"
                            >
                                <div
                                class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700"
                                >
                                <ul>
                                    <li>
                                    <a
                                        href="#"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                                        >Edit</a
                                    >
                                    </li>
                                    <li>
                                    <a
                                        href="#"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100"
                                        >Lihat Detail</a
                                    >
                                    </li>
                                    <li>
                                    <a
                                        href="#"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden text-error transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600"
                                        >Hapus</a
                                    >
                                    </li>
                                </ul>
                                </div>
                            </div>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>

                <div
                class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5"
                >
                <div class="text-xs-plus">Menampilkan {{ $this->pengumumans->count() }} dari {{ $this->pengumumans->count() }} entri</div>
                </div>
            </div>
        </div> 
    </div>
</div>