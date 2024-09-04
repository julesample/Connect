<div x-data="{ open: false }">
    <!-- Trigger Button -->
    <button @click="open = true" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 sm:px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm sm:text-base">
        Add Comment
    </button>
    <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="open = false" class="flex flex-col bg-gray-800 text-white shadow-md rounded-lg w-full max-w-md">
            <div class="p-4 border-gray-700">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <div class="border-none border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Commenting to {{ $note->user->name }}</h2>
                    </div>
                    <textarea name="content" class="w-full bg-gray-700 text-white border-none focus:outline-none p-2 mt-2" placeholder="Add a comment"></textarea>
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="note_id" value="{{ $note->id }}">
                    <div class="py-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Comment</button>
                        <button @click="open = false" type="button" class="mx-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
