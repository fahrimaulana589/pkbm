@props(['disabled' => false, 'error' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->class([
    'form-select mt-1.5 w-full rounded-lg bg-transparent px-3 py-2',
    'border border-slate-300 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent' => !$error,
    'border border-error' => $error,
]) !!}>
    {{ $slot }}
</select>
