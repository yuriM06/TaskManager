<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);

// メニュー
Route::view('/', 'home')->name('home');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::view('/my_task', 'my_task')->name('my_task');

// ヘッダー
Route::view('/create', 'tasks.create')->name('create');
// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
// Route::get('/alarms', [AlarmController::class, 'index'])->name('alarms');
