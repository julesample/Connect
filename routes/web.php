<?php

use App\Http\Controllers\ViewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FriendRequestController;


Route::get('/', function(){
return view(view: 'auth.login');
});
    


Route::middleware(['auth','verified'])->group(function () {
//     Route::get('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'show'])
//     ->name('two-factor.show');
// Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store']);
// Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy']);
    Route::get('/dashboard', [ViewsController::class, 'index' ])->name('dashboard');
    Route::get('/friend-request', [ViewsController::class, 'FriendRequestView'])->name('request.view');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/view', [ViewsController::class,'ProfileView'])->name('profile.view');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    route::delete('/sessions/{id}', [ProfileController::class, 'delete_sessions'])->name('sessions.delete');
    Route::post('/dashboard/add_note', [NotesController::class, 'store'])->name('main.add_note');
    Route::post('/comments', [CommentsController::class, 'store'])->name('comments.store');  
    Route::delete('/comments/deleting', [CommentsController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/dashboard/delete_note/{id}',[NotesController::class,'destroy'])->name('note.delete');
    Route::patch('/dashboard/update_note/{id}',[NotesController::class,'update'])->name('note.update');
    Route::post('/friend-request/send', [FriendRequestController::class, 'sendRequest'])->name('friend-request.send');
    Route::post('/friend-request/cancel', [FriendRequestController::class, 'cancel'])->name('friend-request.cancel');

    Route::post('/friend-request/cancel/{id}', [FriendRequestController::class, 'friendRequestCancel'])->name('friend-request.cancel.page');
    Route::post('/friend-request/accept/{id}', [FriendRequestController::class, 'accept'])->name('friend-request.accept');
    Route::post('/friend-request/decline/{id}', [FriendRequestController::class, 'decline'])->name('friend-request.decline');



});




require __DIR__.'/auth.php';
