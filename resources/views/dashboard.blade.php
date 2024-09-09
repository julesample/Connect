<x-app-layout>
    <x-slot name="header">
      <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Dashboard') }}
      </h2>
      <div x-data="{ showModal: false }">
        <!-- Trigger Button -->
        <button @click="showModal = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mx-4 rounded">
            Add Note
        </button>
    
        <!-- Modal Background -->
        <div x-show="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
            <!-- Modal Content -->
            <div @click.away="showModal = false" class="flex flex-col bg-gray-800 text-white shadow-md rounded-lg w-full max-w-md">
                <form action="{{ route('main.add_note') }}" method="POST">
                    @csrf
    
                    <div class="p-4 border-b border-gray-700">
                        <label for="title" class="block text-gray-300 text-sm font-medium">Title</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Enter title">
                    </div>
    
                    <div class="p-4 border-b border-gray-700">
                        <label for="description" class="block text-gray-300 text-sm font-medium">Description</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-700 bg-gray-700 text-white rounded-md shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Enter description"></textarea>
                    </div>
    
                    <div class="p-4 flex justify-end">
                        <button @click="showModal = false" type="button" class="mr-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </form>
            </div>
        </div>
    </div>
    
      </div>
        
    </x-slot>
 
<div class="max-w-4xl mx-auto p-4">
    <div class="swiper-container max-w-lg mx-auto mt-10 p-4">
      <div class="swiper-wrapper">
          @foreach($users as $user)     
          <div class="swiper-slide flex flex-col bg-gray-800 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between w-full">
              <div class="flex flex-col items-center">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full mb-2">
                <div class="text-lg font-semibold mb-2">{{$user->name}}</div>
             <div x-data="friendRequestHandler({{ $user->id }}, {{ $isFriend ? 'true' : 'false' }})">
    <button 
        @click="toggleFriendRequest" 
        :class="isFriend ? 'bg-gray-500 hover:bg-gray-700' : 'bg-blue-500 hover:bg-blue-700'"
        class="text-white py-2 px-4 rounded"
    >
        <span x-text="isFriend ? 'Cancel' : 'Add Friend'"></span>
    </button>
</div>
<script>
  function friendRequestHandler(recipientId, isFriendInitial) {
      return {
          isFriend: isFriendInitial, // Initialize based on the server's current state
  
          toggleFriendRequest() {
              if (this.isFriend) {
                  axios.post('{{ route('friend-request.cancel') }}', {
                      receiver_id: recipientId,
                  }, {
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                      }
                  }).then(response => {
                      this.isFriend = false;
                      console.log(response.data.status);
                  }).catch(error => {
                      console.error('Error canceling friend request:', error.response.data);
                  });
              } else {
                  axios.post('{{ route('friend-request.send') }}', {
                      receiver_id: recipientId,
                  }, {
                      headers: {
                          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                      }
                  }).then(response => {
                      this.isFriend = true;
                      console.log(response.data.status);
                  }).catch(error => {
                      console.error('Error sending friend request:', error.response.data);
                  });
              }
          }
      };
  }
  </script>
  
              
              </div>
              <div class="ml-4 flex-1">
                <p class="text-sm text-gray-400">{{$user->bio}}</p>
              </div>
            </div>
            <div class="flex justify-between mt-4 w-full">
              <div class="flex flex-col items-center">
                <span class="text-sm text-gray-400">Friends</span>
                <span class="text-lg font-semibold">12</span>
              </div>
              <div class="flex flex-col items-center">
                <span class="text-sm text-gray-400">Likes</span>
                <span class="text-lg font-semibold">120</span>
              </div>
              <div class="flex flex-col items-center">
                <span class="text-sm text-gray-400">Notes</span>
                <span class="text-lg font-semibold">{{ $user->notes->count() }}</span>
              </div>
            </div>
          </div>
          @endforeach
      </div>

      <!-- Add Pagination -->
      <div class="swiper-pagination mt-4"></div>

      <!-- Add Navigation -->
      <div class="swiper-button-next text-white"></div>
      <div class="swiper-button-prev text-white"></div>
  </div>

</div>
    


      @foreach($notes as $note)
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
              <div  class="flex flex-col sm:flex-row justify-evenly px-2 sm:px-4 space-y-2 sm:space-y-0 sm:space-x-4">
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

  <div x-data="{ showError: true }" 
  x-init="setTimeout(() => showError = false, 2000)" 
  x-show="showError" 
  x-transition:leave="transition-opacity ease-linear duration-500" 
  x-transition:leave-start="opacity-100" 
  x-transition:leave-end="opacity-0">
  <x-input-error class="mt-2" :messages="$errors->get('content')" />
  </div>
          
            <div class="p-4">
              <p class="text-lg font-medium">{{$note->title}}</p>
              <p class="text-gray-300">{{$note->description}}</p>
            </div>
            <div class="flex justify-between p-4 border-t border-gray-700">
              <div class="flex items-center">
                <button class="text-blue-400 hover:text-blue-300">Like</button>
                <span class="ml-2 text-gray-300">{{$note->likes}} Likes</span>
              </div>

              <div x-data="{ open: false }">
                <!-- Trigger Button -->
                <button @click="open = true" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 sm:px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 text-sm sm:text-base">
                    Add Comment
                </button>
            
                <!-- Modal Background -->
                <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <!-- Modal Content -->
                    <div @click.away="open = false" class="flex flex-col bg-gray-800 text-white shadow-md rounded-lg w-full max-w-md">
                        <div class="p-4 border-gray-700">

                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf
                                <div class="border-none border-gray-700">
                                  <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Commenting to {{$note->user->name}}</h2>

                                </div>
                                <textarea name="content" class="w-full bg-gray-700 text-white border-none focus:outline-none p-2 mt-2" placeholder="Add a comment"></textarea>
                                <!-- Hidden Input to Capture User ID -->
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <!-- Hidden Input to Capture Note ID -->
                                <input type="hidden" name="note_id" value="{{ $note->id }}">
                                <div class="py-4">                            
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Comment
                                    </button>
                                    <button @click="open = false" type="button" class="mx-2 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                      Cancel
                                  </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>
            <div class="flex justify-between p-4 text-gray-400 text-sm">
              
              <div>
                   {{($note->updated_at != $note->created_at)?"Edited ".$note->updated_at->diffForHumans():''}}
              </div>
              <div>
                  {{$note->created_at->diffForHumans()}}
              </div>
          </div>
          
          </div>
     
          <div class="relative p-4 bg-gray-700 rounded-b-lg max-h-32 overflow-y-auto">
            <div class="top-0 bg-gray-700 text-lg mb-2 z-10">
              <h4>Comments</h4>
            </div>
            
            @forelse($note->comments as $comment)
            <div class="mb-4 p-4 bg-gray-800 rounded-lg">
              
                  <div class="mb-2">
                      <p class="text-lg font-semibold text-gray-400">{{ $comment->user->name }}</p>
                      <p class="text-gray-300 mb-2">{{ $comment->content }}</p>
                      <p class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                  </div>
                  <div x-data="{ open: false }">
                    <!-- Delete Button -->
                    <button @click="open = true" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                
                    <!-- Modal Background -->
                    <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                        <!-- Modal Content -->
                        <div @click.away="open = false" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-sm mx-auto">
                            <h2 class="text-xl font-semibold text-gray-700 dark:text-white">Confirm Deletion</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Are you sure you want to delete this comment?</p>
                
                            <!-- Action Buttons -->
                            <div class="flex justify-end mt-4">
                                <button @click="open = false" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                    Cancel
                                </button>
                                <form action="{{ route('comments.destroy') }}" method="POST">
                                  @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="note_id" value="{{ $comment->id }}">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          
          
            @empty
                <p class="text-gray-500">No comments yet.</p>
            @endforelse
        </div>
        
        
        </div>
      @endforeach
      
    </div>
    



</x-app-layout>

