---
description: Standard Operating Procedure for creating CRUD modules in this project.
---

# Standard CRUD Generator Workflow

Use this workflow whenever the user asks to "create a CRUD", "make a table", or "add a form".
**Strictly adhere** to the patterns below. Do not deviate to Class-Based Volt or other styles.

## 1. Component Architecture
*   **Architecture**: Livewire Volt **Functional API** (not Class-based).
*   **Structure**: 
    *   `[model]-table.blade.php` (List View)
    *   `[model]-form-create.blade.php` (Create Logic)
    *   `[model]-form-edit.blade.php` (Edit Logic)
*   **Routing**: Laravel Folio.
    *   `resources/views/pages/admin/[module]/index.blade.php` -> Table
    *   `resources/views/pages/admin/[module]/create.blade.php` -> Create Form
    *   `resources/views/pages/admin/[module]/[id].blade.php` -> Edit Form

---

## 2. Table Template (`[model]-table.blade.php`)

```php
<?php
use App\Models\YourModel;
use function Livewire\Volt\{state, computed, uses};
use Livewire\WithPagination;

uses([WithPagination::class]);

state('idToDelete', null);
state('search', '');

$items = computed(function () {
    return YourModel::where('name', 'like', '%' . $this->search . '%')
        ->latest()
        ->paginate(10);
});

// Helper for Status Badge
$getStatusBadge = fn($status) => match($status) {
    'active' => '<div class="badge rounded-full bg-success/10 text-success">Aktif</div>',
    default => '<div class="badge rounded-full bg-slate-100 text-slate-600">'.$status.'</div>',
};

$confirmDelete = function ($id) {
    $this->idToDelete = $id;
    $this->dispatch('delete-confirmation');
};

$delete = function () {
    YourModel::find($this->idToDelete)->delete();
    $this->dispatch('delete-confirmed');
};
?>

<div>
    <!-- PAGE HEADER INSIDE COMPONENT -->
    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">Page Title</h2>
        <div class="hidden h-full py-1 sm:flex"><div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div></div>
    </div>

    <!-- WRAPPER & DRAG LOGIC CSS -->
    <style>
        .inherit-cursor * { cursor: inherit !important; }
        .inherit-cursor button, .inherit-cursor a, .inherit-cursor input, .inherit-cursor select { cursor: pointer !important; }
        .cursor-grab { cursor: grab; }
        .cursor-grabbing { cursor: grabbing; }
        .is-scrollbar-hidden::-webkit-scrollbar { display: none; }
        .is-scrollbar-hidden { -ms-overflow-style: none; scrollbar-width: none; }
        .popper-root { position: absolute; z-index: 100; visibility: hidden; }
        .popper-root.show { visibility: visible; }
    </style>

    <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">Table Title</h2>
                <div class="flex">
                    <!-- SEARCH BAR -->
                    <div class="flex items-center" x-data="{isInputActive:false}">
                        <label class="block">
                            <input wire:model.live.debounce.250ms="search"
                                x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500"
                                placeholder="Search..." type="text" />
                        </label>
                        <button @click="isInputActive = !isInputActive" class="btn size-8 rounded-full p-0 hover:bg-slate-300/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <!-- ALPINE DRAG LOGIC -->
                <div x-data="{ isDragging: false, isTextHover: false, isInteractive: false, startX: 0, scrollLeft: 0, ... }" ...>
                    <table class="is-hoverable w-full text-left">
                        <thead>
                            <tr>
                                <th class="bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">#</th>
                                <th class="bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">Column</th>
                                <th class="rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->items as $index => $item)
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $item->name }}</td>
                                    <!-- ACTION COLUMN -->
                                    <td class="px-4 py-3 action-col">
                                        <div x-data="usePopper...">...</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-4">{{ $this->items->links() }}</div>
            </div>
        </div>
    </div>

    <x-confirm-modal trigger="delete-confirmation" title="Confirm" message="Are you sure?" action="delete" />
    <x-success-modal trigger="delete-confirmed" title="Success" message="Deleted successfully." />
    @if (session()->has('message')) <x-success-modal title="Success" :message="session('message')" /> @endif
</div>
```

---

## 3. Create Form Template (`[model]-form-create.blade.php`)

```php
<?php
use App\Models\YourModel;
use function Livewire\Volt\{state, rules};

state(['name' => '', 'status' => 'active']);

rules(['name' => 'required', 'status' => 'required']);

$save = function () {
    $this->validate();
    YourModel::create(['name' => $this->name, 'status' => $this->status]);
    
    session()->flash('status', 'Success');
    session()->flash('message', 'Created successfully.');
    return $this->redirectRoute('admin.your-route.index', navigate: true);
};
?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <div class="col-span-12 lg:col-span-8">
        <div class="card px-4 pb-4 sm:px-5">
            <div class="my-3 flex h-8 items-center justify-between"><h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">Info</h2></div>
            <div class="max-w-xl">
                <div class="mt-5 flex flex-col gap-4">
                    <x-input-label><span>Name</span><x-text-input wire:model="name" type="text" :error="$errors->has('name')" /><x-input-error :messages="$errors->get('name')" /></x-input-label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 lg:col-span-4">
        <!-- Sidebar settings -->
        <div class="card px-4 pb-4">
            <div class="mt-5"><x-primary-button wire:click="save">Save</x-primary-button></div>
        </div>
    </div>
</div>
```

---

## 4. Edit Form Template (`[model]-form-edit.blade.php`)

```php
<?php
use App\Models\YourModel;
use function Livewire\Volt\{state, rules, mount};

state(['item' => null, 'name' => '', 'status' => '']);

mount(function ($id) {
    $this->item = YourModel::findOrFail($id);
    $this->name = $this->item->name;
    $this->status = $this->item->status;
});

rules(['name' => 'required', 'status' => 'required']);

$save = function () {
    $this->validate();
    $this->item->update(['name' => $this->name, 'status' => $this->status]);
    
    $this->dispatch('item-updated'); // Dispatch Event
    // DO NOT REDIRECT
};
?>

<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
    <!-- Same Layout as Create -->
    <div class="col-span-12 lg:col-span-8">...</div>
    <div class="col-span-12 lg:col-span-4">...</div>

    <!-- Success Modal -->
    <x-success-modal trigger="item-updated" message="Updated successfully." />
</div>
```

---

## 5. UI/UX/Logic Checklist
1.  **Headers**: Always include the Page Title and Breadcrumb Divider *inside* the Component view.
2.  **Wrappers**: Always use `max-w-full` for parent generic layouts, remove `max-w-3xl` constraints.
3.  **Drag**: Copy the Alpine.js drag logic exactly (search for `handleDrag`, `isPointInsideChar`).
4.  **Edit Flow**: Never redirect on Edit save. Always Dispatch Event + Show Modal.
5.  **Create Flow**: Always redirect to Index with Flash Message.
