<?php

use App\Models\Schedule;
use function Livewire\Volt\{state, computed, mount, rules, validate, on, uses};

use Livewire\WithPagination;

uses([WithPagination::class]);

state('id', null);
state('search', '');

$schedules = computed(function () {
    return Schedule::with('classGroup')
        ->where('materi', 'like', '%' . $this->search . '%')
        ->orWhere('hari', 'like', '%' . $this->search . '%')
        ->orWhereHas('classGroup', function ($query) {
            $query->where('nama_rombel', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
});

$confirmDelete = function ($id) {
    $this->id = $id;
    $this->dispatch('delete-schedule-confirmation');
};

$delete = function () {
    Schedule::find($this->id)->delete();
    $this->dispatch('delete-schedule-confirmed');
};

?>

<div>
    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Jadwal Belajar
        </h2>
        <div class="hidden h-full py-1 sm:flex">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
        </div>
    </div>

    <!-- STYLE TAMBAHAN UNTUK DRAG LOGIC -->
    <style>
        .inherit-cursor * {
            cursor: inherit !important;
        }

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

        .is-scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .is-scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

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
        <!-- Schedule Table -->
        <div>
            <!-- Header Tools (Search, dll) -->
            <div class="flex items-center justify-between">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    Tabel Jadwal
                </h2>
                <div class="flex">
                    <div class="flex items-center" x-data="{isInputActive:false}">
                        <label class="block">
                            <input wire:model.live.debounce.250ms="search"
                                x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                                placeholder="Cari Jadwal..." type="text" />
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
                                    <li><a wire:navigate.hover href="{{ route('admin.jadwal.create') }}"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Tambah
                                            Baru</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div x-data="{
                        isDragging: false,
                        isTextHover: false,
                        isInteractive: false,
                        startX: 0,
                        scrollLeft: 0,
                        startDrag(e) {
                            if (e.target.closest('button, a, input, select, .popper-box')) return;
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
                            if (e.target.closest('.action-col')) {
                                this.isInteractive = true;
                                this.isTextHover = false;
                                return;
                            }
                            this.isInteractive = false;
                            const x = e.clientX;
                            const y = e.clientY;
                            let foundText = false;
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
                                const buffer = 15;
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
                        'cursor-default': isInteractive && !isDragging,
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
                                    Hari</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Jam</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Materi</th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Rombel</th>
                                <th
                                    class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->schedules as $index => $schedule)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $index + 1 }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $schedule->hari }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="text-slate-700 dark:text-navy-100">
                                            {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="text-slate-700 dark:text-navy-100">
                                            {{ $schedule->materi }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="text-slate-700 dark:text-navy-100">
                                            {{ $schedule->classGroup->nama_rombel ?? '-' }}
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
                                                                href="{{ route('admin.jadwal.edit', ['id' => $schedule->id]) }}"
                                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-hidden transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Edit</a>
                                                        </li>
                                                        <li><button @click="isShowPopper = false"
                                                                wire:click="confirmDelete('{{$schedule->id}}')"
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
                    {{ $this->schedules->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-confirm-modal :trigger="'delete-schedule-confirmation'" :title="'Konfirmasi Penghapusan'" :message="'Jadwal ini akan dihapus. Apakah Anda yakin ingin menghapus data ini?'" :action="'delete'" />

    <x-success-modal :trigger="'delete-schedule-confirmed'" :title="'Jadwal berhasil dihapus'" :message="'Data jadwal telah dihapus.'" />

    @if (session()->has('message'))
        <x-success-modal :title="session('status') ?? 'Berhasil'" :message="session('message')" />
    @endif
</div>