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
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
