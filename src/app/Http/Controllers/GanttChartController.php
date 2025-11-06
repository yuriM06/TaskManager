<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GanttChartController extends Controller
{
    /**
     * [POST]ガントチャートの日付更新処理
     * リクエストから渡されたJSON形式の変更後のタスクをデコードし、各タスクの開始日・期限を更新する
     * 更新後ガントチャート画面へリダイレクト
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $modifiedTasks = json_decode($request->input('modifiedTasks'), true);

        foreach ($modifiedTasks as $modifiedTask) {
            $task = Task::find($modifiedTask['id']);
            $task->start_date = Carbon::parse($modifiedTask['start']);
            $task->due_date = Carbon::parse($modifiedTask['end']);
            $task->save();
        }

        return to_route('gantt_chart')->with('success', 'タスクが更新されました');
    }

    /**
     * ガントチャートライブラリ用のタスクデータを取得
     *
     * データベースからタスクを昇順で取得し、viewに渡す
     * @return \Illuminate\View\View
     */
    public function getTasksForGanttChart()
    {
        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('gantt_chart_update', compact('tasks'));
    }
}
