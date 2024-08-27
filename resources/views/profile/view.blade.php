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
                            <div class="space-x-2">
                                <!-- Update Button -->
                                <a href="#" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                    Update
                                </a>
                                <!-- Delete Button -->
                                {{-- <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE') --}}
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this note?');">
                                        Delete
                                    </button>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
    </div>
    


</x-app-layout>