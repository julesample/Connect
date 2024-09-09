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
   

  public function showDashboard()
  {
      $userId = Auth::id();
  
      // Fetch notes for the current user
      $notes = Notes::where('user_id', $userId)
          ->with('user', 'comments')
          ->orderBy('created_at', 'desc')
          ->get();
  
      // Fetch all other users
      $users = User::with('notes')
          ->where('id', '!=', $userId)
          ->get();
  
      // Prepare friend request statuses for each user
      $friendStatuses = [];
      foreach ($users as $user) {
          $isFriend = FriendRequest::where(function ($query) use ($userId, $user) {
              $query->where('sender_id', $userId)
                    ->where('receiver_id', $user->id);
          })->orWhere(function ($query) use ($userId, $user) {
              $query->where('sender_id', $user->id)
                    ->where('receiver_id', $userId);
          })->exists();
  
          $friendStatuses[$user->id] = $isFriend;
      }
  
      return view('dashboard', [
          'notes' => $notes,
          'users' => $users,
          'friendStatuses' => $friendStatuses, // Pass friend statuses array
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
