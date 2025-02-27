<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\View;
// use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Carbon\Carbon;

class TaskController extends Controller
{
    // 一覧表示
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    // 新規作成フォーム
    public function create()
    {
        return view('tasks.create');
    }

    // 新規作成処理
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('success', 'タスクが作成されました');
    }

    // 詳細表示
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    // 編集フォーム
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    // 編集処理
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'タスクが更新されました');
    }

    // 削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクが削除されました');
    }

    // 期限が当日~過ぎたものを取得
    public function alarms()
    {
        $today = Carbon::today();
        $tasks = Task::whereDate('due_date', '<', $today)
            ->where('status', '!=', 'completed')
            ->get();
        $tasksCount = $tasks->count();

        return view('alarms', compact('tasks', 'tasksCount'));
    }
}
