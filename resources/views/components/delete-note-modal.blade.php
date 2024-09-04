<div x-data="{ openDeleteModal: false }">
    <!-- Delete Button -->
    <button @click="openDeleteModal = true" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 sm:px-4 rounded focus:outline-none focus:ring-2 focus:ring-red-300 text-sm sm:text-base">
        Delete
    </button>
    <div x-show="openDeleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="openDeleteModal = false" class="bg-gray-800 text-white shadow-md rounded-lg p-6 w-full max-w-sm">
            <h2 class="text-xl font-semibold text-gray-200">Confirm Deletion</h2>
            <p class="mt-2 text-gray-400">Are you sure you want to delete this note?</p>
            <div class="mt-6 flex justify-end">
                <button type="button" @click="openDeleteModal = false" class="mr-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</button>
                <form action="{{ route('note.delete', $note->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
