@props(['percentage', 'trend'])

<div class="inline-flex items-baseline rounded-full px-2.5 py-0.5 text-sm font-medium md:mt-2 lg:mt-0
    {{ $trend === 'increased' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
    <span class="sr-only">{{ ucfirst($trend) }} by</span>
    {{ Number::percentage($percentage) }}
</div>