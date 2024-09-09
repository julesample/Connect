<div class="p-6 bg-gray-800 ">
    <h2 class="text-lg font-medium text-white mb-4">Manage Sessions</h2>

    @foreach ($sessions as $session)
        <div class="flex items-center justify-between bg-gray-700 p-4 rounded-lg mb-4">
            <div>
                <p class="text-white font-semibold">
                    {{ $session->user_agent }}
                </p>
                <p class="text-gray-400 text-sm">
                    {{ $session->ip_address }} - Last active {{ \Carbon\Carbon::parse($session->last_activity)->diffForHumans() }}
                </p>
            </div>
            @if ($session->id !== session()->getId())
                <form method="POST" action="{{ route('sessions.delete', $session->id) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button class="ms-3">
                        {{ __('Delete Session') }}
                    </x-danger-button>
                </form>
            @endif
        </div>
    @endforeach
</div>
