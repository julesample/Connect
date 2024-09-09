<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-4">
        <!-- Profile Header -->
        
        <div class="bg-gray-800 text-white rounded-lg p-6 flex flex-col sm:flex-row items-center">
            <img src="{{asset('storage/' . Auth::user()->avatar)}}" class="w-20 h-20 rounded-full m-2">
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                <p class="text-gray-400">{{ "@" . Auth::user()->email }}</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-6">
                <p class="text-gray-300">{{ Auth::user()->bio }}</p>
                <a href="{{ route('profile.edit') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Profile
                </a>
            </div>
        </div>
        
        <!-- Profile Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <div class="bg-gray-800 text-white rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold">24</h3>
                <p class="text-gray-400">Likes</p>
            </div>
            <div class="bg-gray-800 text-white rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold">5</h3>
                <p class="text-gray-400">Friends</p>
            </div>
            <div class="bg-gray-800 text-white rounded-lg p-4 text-center">
                <h3 class="text-xl font-bold">
                    {{$notesCount}}
                </h3>
                <p class="text-gray-400">Notes</p>
            </div>
        </div>
    
        <!-- Notes Timeline -->
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-700 dark:text-white mb-4">Notes</h3>
            <div class="space-y-4">
                @foreach($notes as $note)
                    <div class="bg-gray-800 text-white rounded-lg p-4">
                        <h4 class="text-lg font-medium">{{$note->title}}</h4>
                        <p class="text-gray-300">{{$note->description}}</p>
                        <div class="flex justify-between items-center mt-4">
                            <div class="text-gray-400 text-sm">
                                {{$note->created_at->diffForHumans()}}
                            </div>
                            <div class="flex flex-col sm:flex-row justify-evenly sm:space-x-4">
                                <!-- Update Button -->
                                     <!-- Edit Modal -->
                <div x-data="{ openEditModal: false }">
                    <!-- Edit Button -->
                    <button 
                    @click="openEditModal = true" 
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 sm:px-4 rounded focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm sm:text-base">
                    Edit
                </button>
                
                   <div x-show="openEditModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                       <div @click.away="openEditModal = false" class="bg-gray-800 text-white shadow-md rounded-lg p-6 w-full max-w-sm">
                           <h2 class="text-xl font-semibold text-gray-200">Edit Note</h2>
                           <form action="{{route('note.update', $note->id)}}" method="POST">
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

                                <!-- Delete Button -->
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
                                             <form action="{{route('note.delete', $note->id)}}" method="POST">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete</button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>
    


</x-app-layout>