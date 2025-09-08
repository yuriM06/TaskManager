<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class GanttChartController extends Controller
{
    /**
     * [POST]ガントチャートの日付更新処理
     * リクエストから受け取ったmodifiedTasksをデコードし、各タスクの開始日・期限をを更新する
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
