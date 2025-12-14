<?php

use App\Models\InfoPpdb;
use function Livewire\Volt\{state, computed, uses};
use Livewire\WithPagination;

uses([WithPagination::class]);

state('idToDelete', null);
state('search', '');

$infos = computed(function () {
    return InfoPpdb::with('penulis')
        ->where('judul', 'like', '%' . $this->search . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
});

$getDateDisplay = fn($date) => !$date ? '-' : \Carbon\Carbon::parse($date)->format('d M Y');

$confirmDelete = function ($id) {
    $this->idToDelete = $id;
    $this->dispatch('delete-info-confirmation');
};

$delete = function () {
    $info = InfoPpdb::find($this->idToDelete);
    if ($info) {
        $info->delete();
        $this->dispatch('delete-info-confirmated');
    }
};

?>

<div>
    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Info PPDB
        </h2>
        <div class="hidden h-full py-1 sm:flex">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
        </div>
    </div>

    <!-- STYLE TAMBAHAN UNTUK DRAG LOGIC -->
    <style>
        /* Memaksa elemen anak mewarisi cursor parent agar transisi mulus */
        .inherit-cursor * {
            cursor: inherit !important;
        }

        /* PENTING: Kembalikan cursor pointer untuk elemen interaktif (tombol/link) */
        .inherit-cursor button,
        .inherit-cursor a,
        .inherit-cursor [role="button"],
        .inherit-cursor input,
        .inherit-cursor select {
            cursor: pointer !important;
        }

        .cursor-grab {
            cursor: grab;
        }

        .cursor-grabbing {
            cursor: grabbing;
        }

        .cursor-text {
            cursor: text;
        }

        .cursor-default {
            cursor: default;
        }

        /* Sembunyikan scrollbar native tapi tetap bisa discroll */
        .is-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .is-scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    Tabel Info PPDB
                </h2>
                <div class="flex">
                    <div class="flex items-center" x-data="{isInputActive:false}">
                        <label class="block">
                            <input wire:model.live.debounce.250ms="search"
                                x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                                placeholder="Cari Info PPDB..." type="text" />
                        </label>
                        <button @click="isInputActive = !isInputActive"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                    <!-- Menu Popper Atas -->
                    <div x-data="usePopper({placement:'bottom-end',offset:4})"
                        @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                        <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </button>
                        <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                            <div
                                class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                <ul>
                                    <li><a wire:navigate.hover href="{{ route('ppdb.info.create') }}"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Tambah
                                            Baru</a></li>
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
                <div x-data="{
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
                    }" x-ref="container"
                    class="is-scrollbar-hidden min-w-full overflow-x-auto inherit-cursor transition-colors" :class="{
                        'cursor-text select-text': isTextHover && !isDragging,
                        'cursor-grabbing select-none': isDragging,
                        'cursor-default': isInteractive && !isDragging, /* Pointer normal (default) */
                        'cursor-grab select-none': !isDragging && !isTextHover && !isInteractive
                    }" @mousedown="startDrag($event)" @mousemove.window="handleDrag($event)"
                    @mouseup.window="stopDrag()" @mousemove="checkHoverStatus($event)"
                    @mouseleave="isTextHover = false; isInteractive = false;">
                    <table class="is-hoverable w-full text-left">
                        <thead>
                            <tr>
                                <th
                                    class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    #</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Judul</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Pembuat</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Tanggal Dibuat</th>
                                <th
                                    class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->infos as $index => $info)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $info->judul }}
                                        </div>
                                        <div class="text-xs text-slate-500 dark:text-navy-300 mt-1">
                                            {{ \Illuminate\Support\Str::limit($info->deskripsi, 60) }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="text-slate-700 dark:text-navy-100">
                                            {{ $info->penulis->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="text-slate-700 dark:text-navy-100">
                                            {{ $this->getDateDisplay($info->created_at) }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 action-col">
                                        <div x-data="usePopper({placement:'bottom-end',offset:4})"
                                            @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                                            <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 010 2zm7 0a1 1 0 11-2 0 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                            <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                                <div
                                                    class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                                    <ul>
                                                        <li><a wire:navigate.hover
                                                                href="{{ route('ppdb.info.edit', ['id' => $info->id]) }}"
                                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Edit</a>
                                                        </li>
                                                        <li><button @click="isShowPopper = false"
                                                                wire:click="confirmDelete({{ $info->id }})"
                                                                class="flex h-8 w-full items-center px-3 pr-8 font-medium tracking-wide outline-hidden text-error transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">Hapus</button>
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

                <div class="px-4 py-4 sm:px-5">
                    {{ $this->infos->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-confirm-modal :trigger="'delete-info-confirmation'" :title="'Konfirmasi Penghapusan'" :message="'Info PPDB ini akan dihapus. Apakah Anda yakin ingin menghapus Info PPDB ini?'" :action="'delete'" />

    <x-success-modal :trigger="'delete-info-confirmated'" :title="'Info PPDB berhasil dihapus'" :message="'Info PPDB ini telah dihapus.'" />

    @if (session()->has('message'))
        <x-success-modal :title="session('status') ?? 'Berhasil'" :message="session('message')" />
    @endif
</div>