<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);

// メニュー
Route::view('/', 'home')->name('home');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/my_task', [TaskController::class, 'ganttChart'])->name('my_task');

// ヘッダー
Route::view('/create', 'tasks.create')->name('create');
// Route::get('/notifications', [NotificationController::class, ''])->name('notifications');
Route::view('/alarms', 'alarms')->name('alarms');
Route::get('/alarms', [TaskController::class, 'alarms'])->name('alarms');
