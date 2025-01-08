<x-app-layout title="Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div>
            <form action="{{ route('dashboard') }}" method="get">
                <select id="period" name="period" onchange="this.form.submit()" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-7 font-medium text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-gray-600 sm:text-sm sm:leading-6">
                    <option value="today">Day view</option>
                    <option value="week" selected>Week view</option>
                    <option value="month">Month view</option>
                    <option value="year">Year view</option>
                </select>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <dl class="grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:divide-x md:divide-y-0">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 capitalize">Count. {{ $selectedPeriod }} Orders</dt>
                        <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-gray-600">
                                {{ $thisPeriodOrdersCount }}
                                <span class="ml-2 text-sm font-medium text-gray-500">from {{ $previousPeriodOrdersCount }}</span>
                            </div>
                            <x-trend :percentage="$thisPeriodOrdersPercentage" :trend="$orderTrend" />
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 capitalize">Sum. {{ $selectedPeriod }} Income</dt>
                        <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-gray-600">
                                {{ Number::currency($thisPeriodTotalIncome, 'LKR') }}
                                <span class="ml-2 text-sm font-medium text-gray-500">from {{ Number::currency($previousPeriodTotalIncome, 'LKR') }}</span>
                            </div>

                            <x-trend :percentage="$incomePercentageChange" :trend="$incomeTrend" />
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900 capitalize">Count. New Users</dt>
                        <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-gray-600">
                                {{ $thisPeriodUsers }}
                                <span class="ml-2 text-sm font-medium text-gray-500">from {{ $previousPeriodUsers }}</span>
                            </div>

                            <x-trend :percentage="$thisPeriodUserPercentage" :trend="$userTrend" />
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- This chart is not implemented in the updated controller, so I've commented it out --}}
            {{-- <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <canvas id="chart" class="!max-h-[400px]"></canvas>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- This script is not needed for the updated implementation, so I've commented it out --}}
    {{-- @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = JSON.parse(`{!! $labels !!}`);
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '# of Orders (Year 1)',
                        borderColor: 'rgb(67, 56, 202)',
                        data: {{ Js::from($lastYearOrders) }},
                        borderWidth: 1,
                    },
                    {
                        label: '# of Orders (Year 2)',
                        borderColor: 'rgb(34, 197, 94)',
                        data: [],
                        borderWidth: 1
                    }
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush --}}
</x-app-layout>