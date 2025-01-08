@extends('layouts.dashboard')
@section('title', 'Activity')

@section('content')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6">
        <div class="flex justify-start items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Activity log') }}
            </h2>
        </div>
    </div>
</header>
<div class="max-w-7xl mx-auto py-6">
    <div class="mt-4 bg-white rounded-lg shadow-sm border">
        <div class="max-w-7xl mx-auto px-6 py-3">
            @foreach($groupedActivities as $month => $activities)
            <div>
                <div class="ps-2 my-3">
                    <h3 class="font-medium uppercase text-gray-500">
                        {{ Carbon\Carbon::parse($month)->format('d M Y') }}
                    </h3>
                </div>
                @foreach($activities as $activity)
                <div class="flex gap-x-3">
                    <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200">
                        <div class="relative z-10 size-7 flex justify-center items-center">
                            <div class="size-2 rounded-full bg-gray-400"></div>
                        </div>
                    </div>
                    <div class="grow pt-0.5 pb-3">
                        <h3 class="flex gap-x-1.5 font-semibold text-gray-800">
                            {{ $activity->description }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            @if ($activity->properties->has('attributes') && $activity->properties->has('old'))
                            @php
                            $changes = $activity->properties->toArray();
                            @endphp
                        <ul>
                            @foreach ($changes['attributes'] as $key => $value)
                            @if ($key !== 'updated_at' && isset($changes['old'][$key]) && $changes['old'][$key] != $value)
                            <li>
                            {{ class_basename($activity->subject_type) }} {{ str_replace('_', ' ', $key) }} "{{ $changes['old'][$key] }}" changed to "{{ $value }}"
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                        </p>
                        <button type="button" class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none">
                            {{ $activity->causer->name ?? 'N/A' }}
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection