<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 一覧表示
    public function index()
    {
        $tasks = Task::with('parent')->get();

        return view('tasks.index', compact('tasks'));
    }

    // 新規作成フォーム
    public function create()
    {
        $tasks = Task::all();

        return view('tasks.create', compact('tasks'));
    }

    // 新規作成処理
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return to_route('tasks.index')->with('success', 'タスクが作成されました');
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
        $tasks = Task::all();
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('tasks', 'task'));
    }

    // 編集処理
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());

        return to_route('tasks.index')->with('success', 'タスクが更新されました');
    }

    // 削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return to_route('tasks.index')->with('success', 'タスクが削除されました');
    }

    // 期限が当日~過ぎたものを取得
    public function alarms()
    {
        $tasks = Task::alertTasks()->get();
        $tasksCount = $tasks->count();

        return view('alarms', compact('tasks', 'tasksCount'));
    }

    // タスク検索
    public function search(Request $request)
    {
        $query = $request->input('search_task');

        $tasks = Task::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('title', 'LIKE', "%{$query}%");
        })->get();

        return view('tasks.search', compact('tasks', 'query'));
    }
}
