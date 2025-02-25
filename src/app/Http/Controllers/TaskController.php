<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 一覧表示
    public function index()
    {
        $tasks = Task::all(); // すべてのタスクを取得
        return view('tasks.index', compact('tasks')); // ビューに渡す
    }

    // 新規作成フォーム
    public function create()
    {
        return view('tasks.create');
    }

    // 新規作成処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.task_all')->with('success', 'タスクが作成されました');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.task_all')->with('success', 'タスクが更新されました');
    }

    // 削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.task_all')->with('success', 'タスクが削除されました');
    }
}
