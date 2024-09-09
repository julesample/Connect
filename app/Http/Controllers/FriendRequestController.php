<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    //

    public function checkStatus(Request $request, $userId)
    {
        $currentUser = Auth::id();

        // Check if there is an existing friend request
        $friendRequest = FriendRequest::where(function ($query) use ($currentUser, $userId) {
                $query->where('sender_id', $currentUser)
                      ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($currentUser, $userId) {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', $currentUser);
            })
            ->first();

        if ($friendRequest) {
            if ($friendRequest->status == 'pending') {
                return response()->json(['status' => 'pending']);
            } elseif ($friendRequest->status == 'accepted') {
                return response()->json(['status' => 'accepted']);
            }
        }

        return response()->json(['status' => 'none']);
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

    public function cancelRequest(Request $request)
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
