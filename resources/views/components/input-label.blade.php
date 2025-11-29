@props(['value'])

<label {{ $attributes->merge(['class' => 'block']) }}>
    <span>{{ $value ?? $slot }}</span>
</label>
