<div x-data="{ openEditModal: false }">
    <!-- Edit Button -->
    <button @click="openEditModal = true" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 sm:px-4 rounded focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm sm:text-base">
        Edit
    </button>
    <div x-show="openEditModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="openEditModal = false" class="bg-gray-800 text-white shadow-md rounded-lg p-6 w-full max-w-sm">
            <h2 class="text-xl font-semibold text-gray-200">Edit Note</h2>
            <form action="{{ route('note.update', $note->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mt-4">
                    <label for="title" class="block text-sm font-medium text-gray-400">Title</label>
                    <input type="text" name="title" id="title" value="{{ $note->title }}" class="mt-1 block w-full border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-400">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 sm:text-sm">{{ $note->description }}</textarea>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" @click="openEditModal = false" class="mr-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
