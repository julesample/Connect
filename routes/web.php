<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FriendRequestController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;


Route::get('/', function(){
return view('auth.login');
});
    


Route::middleware(['auth','verified'])->group(function () {
//     Route::get('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'show'])
//     ->name('two-factor.show');
// Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store']);
// Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy']);
    Route::get('/dashboard', [NotesController::class, 'showDashboard' ])->name('dashboard');
    Route::get('/dashboard/data', [NotesController::class, 'index'])->name('dashboard.data');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/view', [ProfileController::class,'view'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::delete('/sessions/{id}', [ProfileController::class, 'delete_sessions'])->name('sessions.delete');
    Route::post('/dashboard/add_note', [NotesController::class, 'store'])->name('main.add_note');
    Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');  
    Route::delete('/comments/deleting', [CommentsController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/dashboard/delete_note/{id}',[NotesController::class,'destroy'])->name('note.delete');
    Route::patch('/dashboard/update_note/{id}',[NotesController::class,'update'])->name('note.update');
    Route::post('/friend-request', [FriendRequestController::class, 'sendRequest'])->name('friend-request.send');
    Route::post('/friend-request/cancel', [FriendRequestController::class, 'cancelRequest'])->name('friend-request.cancel');
});




require __DIR__.'/auth.php';
