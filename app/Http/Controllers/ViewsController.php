<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notes;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class ViewsController extends Controller
{
    //
    public function index()
    {
        $userId = Auth::id();
    
        // Fetch all friends of the authenticated user
        $friends = FriendRequest::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->where('status', 'friends') // Only accepted friend requests
        ->get();
    
        // Collect the IDs of the friends
        $friendIds = $friends->map(function ($friend) use ($userId) {
            return $friend->sender_id === $userId ? $friend->receiver_id : $friend->sender_id;
        });
    
        // Include the authenticated user's own ID
        $friendIds->push($userId);
    
        // Fetch notes of friends and the authenticated user, ordered by creation date
        $notes = Notes::whereIn('user_id', $friendIds)->orderBy('created_at', 'desc')->get();
    
  
    
        return view('dashboard', [
            'notes' => $notes          // Pass the notes collection to the view
  
       
        ]);
    }
    
    

    public function FriendRequestView()
    {
        $userId = Auth::id();
        
        // Fetch incoming and outgoing pending friend requests
        $incomingRequests = FriendRequest::where('receiver_id', $userId)->where('status', 'pending')->get();
        $outgoingRequests = FriendRequest::where('sender_id', $userId)->where('status', 'pending')->get();
        
        // Fetch all accepted friends of the authenticated user
        $friends = FriendRequest::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->where('status', 'friends') // Only accepted friend requests
        ->get();
    
        // Collect the IDs of the friends
        $friendIds = $friends->map(function ($friend) use ($userId) {
            return $friend->sender_id === $userId ? $friend->receiver_id : $friend->sender_id;
        });
    
        // Include the authenticated user's own ID to exclude themselves from the results
        $friendIds->push($userId);
    
        // Fetch users that are NOT friends (excluding friends and self)
        $users = User::with('notes')
            ->whereNotIn('id', $friendIds)
            ->get();
    
        // Prepare friend request statuses for the view (based on pending requests)
        $friendStatuses = [];
        foreach ($users as $user) {
            $friendRequest = FriendRequest::where(function ($query) use ($userId, $user) {
                $query->where('sender_id', $userId)->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($userId, $user) {
                $query->where('sender_id', $user->id)->where('receiver_id', $userId);
            })->first();
    
            $friendStatuses[$user->id] = $friendRequest && $friendRequest->status === 'pending';
        }
    
        return view('requests', compact('incomingRequests', 'outgoingRequests', 'users', 'friendStatuses'));
    }
    
    public function ProfileView(){

        $notes = Notes::with('user','comments')->get();
        $notes = Auth::user()->notes;
        $notesCount=$notes->count();
        return view('profile.view', [
        'notes' => $notes,
        'notesCount'=>$notesCount
    ]);
        
    }
}
