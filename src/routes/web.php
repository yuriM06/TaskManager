<?php

use App\Http\Controllers\GanttChartController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);

// メニュー
Route::view('/', 'home')->name('home');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::put('/tasks/{id}', [TaskController::class, 'update']);

// ガントチャート
Route::get('/gantt_chart', [GanttChartController::class, 'getTasksForGanttChart'])->name('gantt_chart');
Route::put('/gantt_chart_update', [GanttChartController::class, 'update'])->name('gantt_chart.update');

// ヘッダー
Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
Route::view('notifications', 'notifications')->name('notifications');
Route::get('/alarms', [TaskController::class, 'alarms'])->name('alarms');
Route::get('/search', [TaskController::class, 'search'])->name('tasks.search');
