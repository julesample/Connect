<?php

namespace App\Http\Controllers;

use App\Models\Friendships;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    //

    public function accept($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        if ($friendRequest->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        // Accept logic, e.g., creating friendship records
        $friendRequest->status = 'friends';
        $friendRequest->save();
        return response()->json(['message' => 'Friend request accepted']);
    }

    public function decline($id)
    {
        $friendRequest = FriendRequest::findOrFail($id);
        if ($friendRequest->receiver_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        // Decline logic
        $friendRequest->delete();
        
        return response()->json(['message' => 'Friend request declined']);
    }



    public function friendRequestCancel(Request $request)
    {
        $friendRequest = FriendRequest::findOrFail($request->request_id);
        
        if ($friendRequest->sender_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $friendRequest->delete();

        return response()->json(['message' => 'Friend request cancelled']);
    }
  

  

    public function sendRequest(Request $request)
    {
        $currentUser = Auth::id();
        $receiverId = $request->input('receiver_id');

        // Check if there's an existing friend request
        $existingRequest = FriendRequest::where('sender_id', $currentUser)
                                        ->where('receiver_id', $receiverId)
                                        ->first();

        if (!$existingRequest) {
            FriendRequest::create([
                'sender_id' => $currentUser,
                'receiver_id' => $receiverId,
                'status' => 'pending',
            ]);

            return response()->json(['status' => 'pending']);
        }

        return response()->json(['status' => 'already_requested']);
    }

    public function cancel(Request $request)
    {
        $currentUser = Auth::id();
        $receiverId = $request->input('receiver_id');

        // Delete the friend request if it exists
        FriendRequest::where('sender_id', $currentUser)
                     ->where('receiver_id', $receiverId)
                     ->delete();

        return response()->json(['status' => 'canceled']);
    }


 
 


}


