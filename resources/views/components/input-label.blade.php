@props(['value'])

<!-- I change the `text-gray-700` to `text-gray-900` -->
 <!-- Add `leading-6` if needed -->
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
