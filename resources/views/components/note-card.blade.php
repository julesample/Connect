<div class="max-w-4xl mx-auto p-4">
    <div class="flex flex-col bg-gray-800 text-white shadow-md rounded-lg">
        <div class="flex items-center justify-between p-4 bg-gray-800 rounded-lg">
            <div class="flex items-center">
                <img src="{{ asset('storage/' . $note->user->avatar) }}" alt="Avatar" class="w-12 h-12 rounded-full mr-2">
                <div>
                    <h3 class="text-lg font-medium">{{ $note->user->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ "@" . $note->user->email }}</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-evenly px-2 sm:px-4 space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Edit Modal -->
                <x-edit-note-modal :note="$note" />
                <!-- Delete Modal -->
                <x-delete-note-modal :note="$note" />
            </div>
        </div>
        <div class="p-4">
            <p class="text-lg font-medium">{{ $note->title }}</p>
            <p class="text-gray-300">{{ $note->description }}</p>
        </div>
        <div class="flex justify-between p-4 border-t border-gray-700">
            <div class="flex items-center">
                <button class="text-blue-400 hover:text-blue-300">Like</button>
                <span class="ml-2 text-gray-300">{{ $note->likes }} Likes</span>
            </div>
            <x-add-comment-modal :note="$note" />
        </div>
        <div class="relative p-4 bg-gray-700 rounded-b-lg max-h-32 overflow-y-auto">
            <div class="top-0 bg-gray-700 text-lg mb-2 z-10">
                <h4>Comments</h4>
            </div>
            @forelse($note->comments as $comment)
                <x-comment-card :comment="$comment" />
            @empty
                <p class="text-gray-500">No comments yet.</p>
            @endforelse
        </div>
    </div>
</div>
