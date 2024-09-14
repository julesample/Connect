<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Friend Requests') }}
    </h2>
  </x-slot>

  <div class="max-w-4xl mx-auto p-4 ">
    <div class="swiper-container max-w-lg mx-auto mt-10">
      <div class="swiper-wrapper">
        @foreach($users as $user)     
        <div class="swiper-slide flex flex-col bg-gray-800 p-4 rounded-lg text-white">
          <div class="flex items-center justify-between w-full">
            <div class="flex flex-col items-center">
              <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full mb-2">
              <div class="text-lg font-semibold mb-2">{{$user->name}}</div>

              <!-- Real-time friend request handling -->
              <div x-data="friendRequestHandler({{ $user->id }}, {{ $friendStatuses[$user->id] ? 'true' : 'false' }})">
                <button 
                  @click="toggleFriendRequest" 
                  :class="isFriend ? 'bg-gray-500 hover:bg-gray-700' : 'bg-blue-500 hover:bg-blue-700'"
                  class="text-white py-2 px-4 rounded"
                >
                  <span x-text="isFriend ? 'Cancel' : 'Add Friend'"></span>
                </button>
              </div>
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

    </div>
  </div>

  <div class="max-w-4xl mx-auto p-4 pb-10 text-white">
    <!-- Incoming Friend Requests -->
    <div class="mb-6">
      <h3 class="text-xl font-semibold mb-4">Incoming Requests</h3>
      @forelse ($incomingRequests as $request)
        <div id="request-{{ $request->id }}" class="flex items-center justify-between p-4 bg-gray-800 rounded-lg mb-4">
          <div>
            <p class="font-semibold">{{ $request->sender->name }}</p>
            <p class="text-gray-400 text-sm">{{ $request->sender->email }}</p>
          </div>
          <div x-data="toggleRequest({{ $request->id }})">
            <button @click="handleFriendRequest('accept')" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded mr-2">
              Accept
            </button>
            <button @click="handleFriendRequest('decline')" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded">
              Decline
            </button>
          </div>
        </div>
      @empty
        <p class="mt-2 text-gray-400">No incoming friend requests.</p>
      @endforelse
    </div>

    <!-- Outgoing Friend Requests -->
    <div>
      <h3 class="text-xl font-semibold mb-4">Outgoing Requests</h3>
      @forelse ($outgoingRequests as $request)
        <div id="request-{{ $request->id }}" class="flex items-center justify-between p-4 bg-gray-800 rounded-lg mb-4">
          <div>
            <p class="font-semibold">{{ $request->receiver->name }}</p>
            <p class="text-gray-400 text-sm">{{ $request->receiver->email }}</p>
          </div>
          <div x-data="toggleRequest({{ $request->id }})">
            <button @click="handleFriendRequest('cancel')" class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded">
              Cancel
            </button>
          </div>
        </div>
      @empty
        <p class="mt-2 text-gray-400">No outgoing friend requests.</p>
      @endforelse
    </div>
  </div>

  <script>
    function friendRequestHandler(recipientId, isFriendInitial) {
      return {
        isFriend: isFriendInitial,

        toggleFriendRequest() {
          const url = this.isFriend
            ? '{{ route('friend-request.cancel') }}'
            : '{{ route('friend-request.send') }}';

          axios.post(url, {
            receiver_id: recipientId,
          }, {
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          }).then(response => {
            this.isFriend = !this.isFriend; // Toggle friend status
          }).catch(error => {
            console.error(error.response.data);
          });
        }
      };
    }

    function toggleRequest(requestId) {
      return {
        handleFriendRequest(action) {
          const url = `/friend-request/${action}/${requestId}`;

          axios.post(url, {}, {
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          }).then(response => {
            document.getElementById(`request-${requestId}`).remove(); // Remove the request from the DOM
          }).catch(error => {
            console.error('Error:', error.response ? error.response.data : error.message);
          });
        }
      };
    }
  </script>
</x-app-layout>
