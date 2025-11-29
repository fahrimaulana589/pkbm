@props(['messages'])

@if ($messages)
    <span {{ $attributes->merge(['class' => 'text-tiny+ text-error']) }}>
        @foreach ((array) $messages as $message)
            {{ $message }}
        @endforeach
    </span>
@endif
