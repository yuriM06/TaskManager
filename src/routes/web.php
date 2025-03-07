<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GanttChartController;

Route::resource('tasks', TaskController::class);
// Route::resource('my_task', GanttChartController::class);

// メニュー
Route::view('/', 'home')->name('home');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::put('/tasks/{id}', [TaskController::class, 'update']);

// ガントチャート
Route::get('/my_task', [GanttChartController::class, 'getTasksForGanttChart'])->name('my_task');
Route::put('/gantt_chart', [GanttChartController::class, 'update'])->name('my_task.update');

// ヘッダー
Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
Route::view('notifications', 'notifications')->name('notifications');
// Route::get('/notifications', [NotificationController::class, ''])->name('notifications');
Route::get('/alarms', [TaskController::class, 'alarms'])->name('alarms');
