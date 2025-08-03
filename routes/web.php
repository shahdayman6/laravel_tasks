<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello',function ()  {
    return"HELLO";
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/notes/live-search', [NoteController::class, 'liveSearch'])->name('notes.liveSearch');
Route::post('/notes/restore-all', [NoteController::class, 'restoreAll'])->name('notes.restoreAll');
Route::get('/notes/trash', [NoteController::class, 'trash'])->name('notes.trash');
Route::post('/notes/restore/{id}', [NoteController::class, 'restore'])->name('notes.restore');
Route::delete('/notes/force-delete/{id}', [NoteController::class, 'forceDelete'])->name('notes.forceDelete');
Route::resource('notes', NoteController::class);