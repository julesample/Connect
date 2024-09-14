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
