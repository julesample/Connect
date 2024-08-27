<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Notes;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */


    public function view(){

        $notes = Notes::with('user','comments')->get();
        $notes = Auth::user()->notes;
        $notesCount=$notes->count();
        return view('profile.view', [
        'notes' => $notes,
        'notesCount'=>$notesCount
    ]);
        
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        // Validate and fill user data
        $user->fill($request->validated());
    
        // Handle email changes
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Store the uploaded file and get the path
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
    
            // Update the user's avatar field
            $user->avatar = $avatarPath;
        }
    
        // Save the user data
        $user->save();
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
