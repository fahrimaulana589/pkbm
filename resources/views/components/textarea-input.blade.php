@props(['disabled' => false, 'error' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->class([
    'form-textarea mt-1.5 w-full rounded-lg bg-transparent p-2.5 placeholder:text-slate-400/70',
    'border border-slate-300 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent' => !$error,
    'border border-error' => $error,
]) !!}>{{ $slot }}</textarea>
