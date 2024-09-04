<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    //
    public function sendRequest(Request $request)
    {
        // Logic to send a friend request
 
        $receiver_id = $request->input('receiver_id');

        // Validate the recipient_id
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);
        FriendRequest::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
        ]);

        return response()->json(['status' => 'Friend request sent']);
    }

    public function cancelRequest(Request $request)
    {
        $userId = Auth::id();
        $receiver_id = $request->input('receiver_id');

        // Validate the recipient_id
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        // Find and delete the friend request
        FriendRequest::where('sender_id', $userId)
            ->where('receiver_id', $receiver_id)
            ->orWhere(function ($query) use ($userId, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                    ->where('receiver_id', $userId);
            })
            ->delete();

        return response()->json(['status' => 'Friend request canceled']);
    }
}
