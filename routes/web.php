<?php

use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

Route::get('/', function (){
    return redirect()->route('home');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('admin', HomeController::class)->names([
    'index' => 'admin.index',
    'create' => 'admin.create',
    'store' => 'admin.store',
    'show' => 'admin.show',
    'edit' => 'admin.edit',
    'update' => 'admin.update',
    'destroy' => 'admin.destroy'
]);


Route::post('/imageUpload', [ImageController::class, 'upload'])->name('image.upload');
Route::prefix('member')->group(function(){
    Route::get('/', [App\Http\Controllers\Member\HomeController::class, 'index'])->name('member.index');
});
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');