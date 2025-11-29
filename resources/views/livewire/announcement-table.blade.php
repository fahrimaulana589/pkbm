<?php

use App\Models\Announcement;
use function Livewire\Volt\{state, computed, mount, rules, validate, on};

$pengumumans = Announcement::with('penulis')->orderBy('created_at', 'desc')->get();
state('pengumumans', $pengumumans);
state('id', null);

$getStatusBadge = fn($status) => match($status) {
    'dipublikasikan' => '<div class="badge rounded-full bg-success/10 text-success dark:bg-success/15">Dipublikasikan</div>',
    'draft' => '<div class="badge rounded-full bg-warning/10 text-warning dark:bg-warning/15">Draft</div>',
    'kadaluarsa' => '<div class="badge rounded-full bg-error/10 text-error dark:bg-error/15">Kadaluarsa</div>',
    'terjadwal' => '<div class="badge rounded-full bg-info/10 text-info dark:bg-info/15">Terjadwal</div>',
    default => '<div class="badge rounded-full bg-slate-100 text-slate-600 dark:bg-navy-500/50 dark:text-navy-200">'.$status.'</div>',
};

$getDateDisplay = fn($date) => !$date ? '-' : \Carbon\Carbon::parse($date)->format('d M Y');

$confim = function ($id) {
    // Here you can implement password confirmation logic if needed
    $this->id = $id;
    $this->dispatch('delete-announcement-confirmation');
};

$delete = function () {
    Announcement::find($this->id)->delete();
    $this->pengumumans = Announcement::with('penulis')->orderBy('created_at', 'desc')->get();   
    $this->dispatch('delete-announcement-confirmated');
};

?>

<div>
    <!-- STYLE TAMBAHAN UNTUK DRAG LOGIC -->
    <style>
        /* Memaksa elemen anak mewarisi cursor parent agar transisi mulus */
        .inherit-cursor * { cursor: inherit !important; }
        
        /* PENTING: Kembalikan cursor pointer untuk elemen interaktif (tombol/link) */
        .inherit-cursor button, 
        .inherit-cursor a, 
        .inherit-cursor [role="button"],
        .inherit-cursor input,
        .inherit-cursor select { 
            cursor: pointer !important; 
        }

        .cursor-grab { cursor: grab; }
        .cursor-grabbing { cursor: grabbing; }
        .cursor-text { cursor: text; }
        .cursor-default { cursor: default; }

        /* Sembunyikan scrollbar native tapi tetap bisa discroll */
        .is-scrollbar-hidden::-webkit-scrollbar { display: none; }
        .is-scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }

        /* Fix Popper/Dropdown Layout Shift */
        .popper-root {
            position: absolute;
            z-index: 100;
            visibility: hidden;
        }
        .popper-root.show {
            visibility: visible;
        }
    </style>

    <div class="flex items-center space-x-4 py-5 lg:py-6">
          <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Pengumuman
          </h2>
          <div class="hidden h-full py-1 sm:flex">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
          </div>
    </div>
    
    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <!-- Announcement Table -->
        <div>
            <!-- Header Tools (Search, dll) -->
            <div class="flex items-center justify-between">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        </button>
                    </div>
                    <!-- Menu Popper Atas -->
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                        </button>
                        <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                            <div class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                <ul>
                                <li><a href="{{ route('admin.pengumuman.create') }}" class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Tambah Baru</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <!-- 
                    WRAPPER TABLE DENGAN ALPINE DRAG LOGIC 
                -->
                <div
                    x-data="{
                        isDragging: false,
                        isTextHover: false,
                        isInteractive: false, // State baru untuk area interaktif (Action Col)
                        startX: 0,
                        scrollLeft: 0,

                        startDrag(e) {
                            // 1. Jangan drag jika klik tombol/link/input (Interactive Elements)
                            if (e.target.closest('button, a, input, select, .popper-box')) return;
                            
                            // 2. Jangan drag jika cursor terdeteksi di dekat teks ATAU area interaktif
                            if (this.isTextHover || this.isInteractive) return;

                            e.preventDefault();
                            this.isDragging = true;
                            this.startX = e.pageX - this.$refs.container.offsetLeft;
                            this.scrollLeft = this.$refs.container.scrollLeft;
                        },

                        handleDrag(e) {
                            if (!this.isDragging) return;
                            e.preventDefault();
                            const x = e.pageX - this.$refs.container.offsetLeft;
                            const walk = (x - this.startX) * 1.5; 
                            this.$refs.container.scrollLeft = this.scrollLeft - walk;
                        },

                        stopDrag() {
                            this.isDragging = false;
                        },

                        checkHoverStatus(e) {
                            if (this.isDragging) return;
                            
                            // A. LOGIC BARU: Jika di kolom action, set Interactive Mode (Pointer Normal)
                            if (e.target.closest('.action-col')) {
                                this.isInteractive = true;
                                this.isTextHover = false;
                                return;
                            }
                            this.isInteractive = false;

                            const x = e.clientX;
                            const y = e.clientY;
                            let foundText = false;

                            // B. Logic deteksi teks standar
                            if (document.caretRangeFromPoint) {
                                const range = document.caretRangeFromPoint(x, y);
                                if (range && range.startContainer.nodeType === 3) {
                                    if (this.isPointInsideChar(range.startContainer, range.startOffset, x, y)) foundText = true;
                                    else if (range.startOffset > 0 && this.isPointInsideChar(range.startContainer, range.startOffset - 1, x, y)) foundText = true;
                                }
                            } else if (document.caretPositionFromPoint) {
                                const pos = document.caretPositionFromPoint(x, y);
                                if (pos && pos.offsetNode.nodeType === 3) {
                                    if (this.isPointInsideChar(pos.offsetNode, pos.offset, x, y)) foundText = true;
                                    else if (pos.offset > 0 && this.isPointInsideChar(pos.offsetNode, pos.offset - 1, x, y)) foundText = true;
                                }
                            }
                            this.isTextHover = foundText;
                        },

                        isPointInsideChar(textNode, offset, mouseX, mouseY) {
                            try {
                                if (offset >= textNode.length) return false;
                                const range = document.createRange();
                                range.setStart(textNode, offset);
                                range.setEnd(textNode, offset + 1);
                                const rects = range.getClientRects();
                                const buffer = 15; // Toleransi area 15px

                                for (const rect of rects) {
                                    if (mouseX >= rect.left - buffer && mouseX <= rect.right + buffer &&
                                        mouseY >= rect.top - buffer && mouseY <= rect.bottom + buffer) {
                                        return true;
                                    }
                                }
                            } catch (e) { return false; }
                            return false;
                        }
                    }"
                    x-ref="container"
                    class="is-scrollbar-hidden min-w-full overflow-x-auto inherit-cursor transition-colors"
                    :class="{
                        'cursor-text select-text': isTextHover && !isDragging,
                        'cursor-grabbing select-none': isDragging,
                        'cursor-default': isInteractive && !isDragging, /* Pointer normal (default) */
                        'cursor-grab select-none': !isDragging && !isTextHover && !isInteractive
                    }"
                    @mousedown="startDrag($event)"
                    @mousemove.window="handleDrag($event)"
                    @mouseup.window="stopDrag()"
                    @mousemove="checkHoverStatus($event)"
                    @mouseleave="isTextHover = false; isInteractive = false;"
                >
                    <table class="is-hoverable w-full text-left">
                        <thead>
                        <tr>
                            <th class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">#</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Judul</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Kategori</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Prioritas</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Status</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Tanggal Mulai</th>
                            <th class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Tanggal Akhir</th>
                            <th class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($this->pengumumans as $index => $pengumuman)
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $index + 1 }}</td>
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
                            <!-- 
                                Class 'action-col' disini memicu isInteractive = true
                            -->
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 action-col">
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 010 2zm7 0a1 1 0 11-2 0 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                                <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                    <div class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                    <ul>
                                        <li><a href="{{ route('admin.pengumuman.edit', ['id' => $pengumuman->id]) }}" class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Edit</a></li>
                                        <li><button @click="isShowPopper = false" wire:click="confim({{$pengumuman->id}})" class="flex h-8 w-full items-center px-3 pr-8 font-medium tracking-wide outline-hidden text-error transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">Hapus</button></li>
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

                <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                    <div class="text-xs-plus">Menampilkan {{ $this->pengumumans->count() }} dari {{ $this->pengumumans->count() }} entri</div>
                </div>
            </div>
        </div> 
    </div>

    <div 
        x-data="{showModal:false}"
        x-on:delete-announcement-confirmation.window="showModal = true"
        x-on:delete-announcement-confirmated.window="showModal = false"
    >
    
    <template x-teleport="#x-teleport-target">
      <div
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-show="showModal"
        role="dialog"
        @keydown.window.escape="showModal = false"
      >
        <div
          class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
          @click="showModal = false"
          x-show="showModal"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        ></div>
        <div
          class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
          x-show="showModal"
          x-transition:enter="easy-out"
          x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
          x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
          x-transition:leave="easy-in"
          x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
          x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]"
        >
          <div class="avatar size-20">
            <img
              class="rounded-full"
              src="images/200x200.png"
              alt="avatar"
            />
            <div
              class="absolute right-0 m-1 size-4 rounded-full border-2 border-white bg-primary dark:border-navy-700 dark:bg-accent"
            ></div>
          </div>
          <div class="mt-4 px-4 sm:px-12">
            <h3 class="text-lg text-slate-800 dark:text-navy-50">
              Konfirmasi Penghapusan
            </h3>
            <p class="mt-1 text-slate-500 dark:text-navy-200">
              Pengumuman ini akan dihapus. Apakah Anda yakin ingin menghapus pengumuman ini?
            </p>
          </div>
          <div class="my-4 mt-16 h-px bg-slate-200 dark:bg-navy-500"></div>

          <div class="space-x-3">
            <button
              @click="showModal = false"
              class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
            >
              Cancel
            </button>
            <button
              wire:click="delete"
              class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
            >
              Apply
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>


    <div 
        x-data="{showModal:false}"
        x-on:delete-announcement-confirmated.window="showModal = true"
    >
    
    <template x-teleport="#x-teleport-target">
      <div
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        x-show="showModal"
        role="dialog"
        @keydown.window.escape="showModal = false"
      >
        <div
          class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
          @click="showModal = false"
          x-show="showModal"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        ></div>
        <div
          class="relative max-w-lg rounded-lg bg-white px-4 py-10 text-center transition-opacity duration-300 dark:bg-navy-700 sm:px-5"
          x-show="showModal"
          x-transition:enter="ease-out"
          x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100"
          x-transition:leave="ease-in"
          x-transition:leave-start="opacity-100"
          x-transition:leave-end="opacity-0"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="inline size-28 text-success"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            ></path>
          </svg>

          <div class="mt-4">
            <h2 class="text-2xl text-slate-700 dark:text-navy-100">
              Pengumuman berhasil dihapus
            </h2>
            <p class="mt-2">
              Pengumuman ini telah dihapus.
            </p>
            <button
              @click="showModal = false"
              class="btn mt-6 bg-success font-medium text-white hover:bg-success-focus focus:bg-success-focus active:bg-success-focus/90"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </template>
    </div>

        <!-- Success Modal for Create/General Messages -->
        @if (session()->has('message'))
            <x-success-modal 
                :title="session('status') ?? 'Berhasil'"
                :message="session('message')" 
            />
        @endif
        <!-- Announcement Table -->
</div>