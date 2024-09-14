<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */



    public function edit(Request $request): View
    {
        // Retrieve the user's sessions
        $sessions = DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->get();
    
        return view('profile.edit', [
            'user' => $request->user(),
            'sessions' => $sessions, // Pass the sessions to the view
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

    public function delete_sessions(Request $request, $id){
        DB::table('sessions')->where('id',$id)->delete();
        return redirect()->back();

    }
}
