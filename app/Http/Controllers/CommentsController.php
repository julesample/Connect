<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'content' => ['required', 'string', 'min:5', 'max:150'],
          
        ]);
    
        Comment::create([
            'content' => $validatedData['content'],
            'user_id' => $request->user_id,
            'note_id' => $request['note_id'],
        ]);
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request){
        
       $comment =Comment::find($request->note_id);
       $comment->delete();
       return redirect()->back()->with('status', 'Comment deleted successfully.');
    }

}
