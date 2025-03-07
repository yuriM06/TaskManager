<?php

namespace App\Http\Controllers;

use App\Http\Requests\GanttChartRequest;
use App\Models\Task;
use Carbon\Carbon;

class GanttChartController extends Controller
{
    // ガントチャートの日程更新処理
    public function update(GanttChartRequest $request)
    {
        // 受け取ったmodifiedTasksをデコード
        $modifiedTasks = json_decode($request->input('modifiedTasks'), true);

        foreach ($modifiedTasks as $modifiedTask) {
            $task = Task::find($modifiedTask['id']);
            $task->start_date = Carbon::parse($modifiedTask['start'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');
            $task->due_date = Carbon::parse($modifiedTask['end'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');
            $task->save();
        }

        return to_route('my_task')->with('success', 'タスクが更新されました');
    }

    // ガントチャートライブラリで使用するデータの取得
    public function getTasksForGanttChart()
    {
        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('gantt_chart', compact('tasks'));
    }
}
