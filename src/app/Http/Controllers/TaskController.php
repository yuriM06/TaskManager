<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

/**
 * タスク管理に関する操作用コントローラー
 * 一覧表示・新規作成・更新・削除・検索・アラーム通知
 */
class TaskController extends Controller
{
    /**
     * [GET]タスク一覧表示
     * タスク情報を取得、一覧表示
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Task::with('parent')->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * [GET]新規タスク作成フォーム表示
     * 新規タスク作成画面を表示する
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tasks = Task::all();

        return view('tasks.create', compact('tasks'));
    }

    /**
     * [POST]新規タスク登録処理
     * タスク登録後一覧画面へとリダイレクト
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return to_route('tasks.index')->with('success', 'タスクが作成されました');
    }

    /**
     * [GET]タスク詳細表示
     * 指定されたIDのタスク情報を取得し、編集画面を表示
     *
     * @param  int  $id  タスクID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    /**
     * [GET]タスク編集フォーム表示
     * 既存の指定されたIDのタスクをを取得し、編集画面を表示
     *
     * @param  int  $id  タスクID
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $tasks = Task::all();
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('tasks', 'task'));
    }

    /**
     * [PUT]タスク更新処理
     * 既存の指定されたIDのタスクを更新し、一覧画面へとリダイレクト
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  int  $id  タスクID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());

        return to_route('tasks.index')->with('success', 'タスクが更新されました');
    }

    /**
     * [DELETE]タスク削除処理
     * 既存の指定されたIDのタスクを削除して、一覧画面へリダイレクト
     *
     * @param  int  $id  タスクID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return to_route('tasks.index')->with('success', 'タスクが削除されました');
    }

    /**
     * [GET]アラーム通知
     * タスク期日が当日または期日切れのものを取得し、アラームを表示
     *
     * @return \Illuminate\View\View
     */
    public function alarms()
    {
        $tasks = Task::alertTasks()->get();
        $tasksCount = $tasks->count();

        return view('alarms', compact('tasks', 'tasksCount'));
    }

    /**
     * [GET]タスク検索
     * 検索フォームに入力されたキーワードをもとに、タイトルを部分一致検索を行い表示する
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $searchWord = $request->input('search_task');

        $tasks = Task::when($searchWord, function ($taskQuery) use ($searchWord) {
            return $taskQuery->where('title', 'LIKE', "%{$searchWord}%");
        })->get();

        return view('tasks.search', compact('tasks', 'searchWord'));
    }
}
