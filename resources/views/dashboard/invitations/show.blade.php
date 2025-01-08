<x-app-layout title="Invitatin Details">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invitation') }}
        </h2>
        <div class="flex items-baseline gap-4">
            @if ($invitation->isExpired() && ! $invitation->isAccepted())
            <x-primary-button type="button" id="resendBtn">Resend</x-primary-button>
            @endif

            @if ($invitation->isPending() && ! $invitation->isExpired())
            <x-primary-button type="button" id="cancelBtn">Cancel</x-primary-button>
            @endif
            <a href="{{ route('dashboard.invitations.index') }}">
                <x-secondary-button>Back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <x-alert :message="session('message')" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('User Details') }}
                                </h2>
                                <div class="mt-4 flex items-start justify-between">
                                    <div>
                                        <p class="block text-sm text-gray-700 pt-1">
                                            Invitation sent at: <span class="text-gray-900">{{ $invitation->created_at->toFormattedDateString() }}</span>
                                        </p>
                                        <p class="block text-sm text-gray-700 pt-1">
                                            Invitation expired at: <span class="text-gray-900">{{ $invitation->expires_at->toDayDateTimeString() }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="{{ $invitation->isAccepted() ? 'badge-success' : 'badge-warning' }}">{{ $invitation->status }}</span>
                                        @if (! $invitation->isAccepted() && $invitation->status == 'pending')
                                        <span class="{{ ! $invitation->isExpired() ? 'badge-success' : 'badge-warning' }}">{{ $invitation->isExpired() ? 'Expired' : 'Not expired' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div>
                                    <div>
                                        <p class="block text-sm text-gray-700">Name</p>
                                        <p class="mt-1 block font-medium text-sm text-gray-900">{{ $invitation->name }}</p>
                                    </div>
                                    <div class="mt-4">
                                        <p class="block text-sm text-gray-700">Email</p>
                                        <p class="mt-1 block font-medium text-sm text-gray-900">{{ $invitation->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('User Roles & Permissions') }}
                                </h2>
                                <div class="mt-4">
                                    <ul>
                                        @foreach ($invitation->roles as $role)
                                        <li class="mt-1 ml-5 capitalize text-sm text-gray-700 list-disc list-item">
                                            {{ $role }} management
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                {{ __('Invited by') }}
                            </h2>
                            <div class="mt-4">
                                <div>
                                    <p class="block text-sm text-gray-700">Name</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $invitation->sender->name }}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Email</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $invitation->sender->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        if (document.getElementById('resendBtn')) {
            document.getElementById('resendBtn').addEventListener('click', function() {
                axios.put("{{ route('dashboard.invitations.resend', $invitation) }}", {})
                    .then(response => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        }

        if (document.getElementById('cancelBtn')) {
            document.getElementById('cancelBtn').addEventListener('click', function() {
                axios.put("{{ route('dashboard.invitations.cancel', $invitation) }}", {})
                    .then(response => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        }
    </script>
    @endpush
</x-app-layout>