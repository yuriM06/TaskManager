<?php

namespace App\Http\Controllers;

use App\Http\Requests\GanttChartRequest;
use App\Models\Task;
use Carbon\Carbon;

class GanttChartController extends Controller
{
    public function update(GanttChartRequest $request)
    {
        // 受け取ったmodifiedTasksをデコード
        $modifiedTasks = json_decode($request->input('modifiedTasks'), true);

        foreach ($modifiedTasks as $modifiedTask) {
            $task = Task::find($modifiedTask['id']);
            if ($task) {
                $task->start_date = Carbon::parse($modifiedTask['start'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');
                $task->due_date = Carbon::parse($modifiedTask['end'])->setTimezone('Asia/Tokyo')->format('Y-m-d H:i:s');
                $task->save();
            }
        }

        return redirect()->route('my_task')->with('success', 'タスクが更新されました');
    }

    // ガントチャート
    public function ganttChart()
    {
        $tasks = Task::orderBy('due_date', 'asc')->get();

        return view('my_task', compact('tasks'));
    }
}
