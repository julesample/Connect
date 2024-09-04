<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Notes;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    //
    public function index(){ 
    
      $userId = Auth::id();
      $profileUserId = $userId; // Replace with the actual user ID you want to check
  
      $notes = Notes::where('user_id', $userId)
          ->with('user', 'comments')
          ->orderBy('created_at', 'desc')
          ->get();
  
      $users = User::with('notes')
          ->where('id', '!=', $userId)
          ->get();
  
      // Check if the current user has sent a friend request to or received a friend request from the profile user
      $isFriend = FriendRequest::where(function ($query) use ($userId, $profileUserId) {
          $query->where('sender_id', $userId)
                ->where('receiver_id', $profileUserId);
      })->orWhere(function ($query) use ($userId, $profileUserId) {
          $query->where('sender_id', $profileUserId)
                ->where('receiver_id', $userId);
      })->exists();
  
      return response()->json([
          'notes' => $notes,
          'users' => $users,
          'isFriend' => $isFriend,
          'profileUserId' => $profileUserId
      ]);

  }


public function showDashboard()
{
    $userId = Auth::id();
    $profileUserId = $userId;

    // Initial data rendering (if needed)
    $notes = Notes::where('user_id', $userId)
        ->with('user', 'comments')
        ->orderBy('created_at', 'desc')
        ->get();

    $users = User::with('notes')
        ->where('id', '!=', $userId)
        ->get();

    $isFriend = FriendRequest::where(function ($query) use ($userId, $profileUserId) {
        $query->where('sender_id', $userId)
              ->where('receiver_id', $profileUserId);
    })->orWhere(function ($query) use ($userId, $profileUserId) {
        $query->where('sender_id', $profileUserId)
              ->where('receiver_id', $userId);
    })->exists();

    return view('dashboard', [
        'notes' => $notes,
        'users' => $users,
        'isFriend' => $isFriend,
        'profileUserId' => $profileUserId
    ]);
}


    public function store(Request $request){
      
      Notes::create([
      'title'=>$request->title,
      'description'=>$request->description,
      'user_id'=>Auth::id(),
      ]);

      session()->flash('message', 'Post added successfully!');
      return redirect()->back();
    }


    public function destroy($id){

        $note = Notes::find($id);
        $note->delete();
        // dd($id);
        return redirect()->back()->with('status', 'Note deleted successfully.');
    }

    public function update(Request $request,$id){

        $notes = Notes::find($id);
        $notes->fill($request->all());
        $notes->save();
        return back();
    }
}
