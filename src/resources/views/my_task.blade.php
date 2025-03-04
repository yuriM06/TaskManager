@extends('layouts.app')

@section('content')
    <h2>個別課題 - ガントチャート</h2>

    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt/dist/frappe-gantt.css">

    <form id="updateForm" action="{{ route('my_task.update') }}" method="POST" onSubmit="return checkTask()">
        @csrf
        @method('PUT')
        <input type="hidden" name="modifiedTasks" id="modifiedTasks">
        <button type="submit" id="updateBtn" class="btn btn-sm btn-primary">更新</button>
    </form>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <svg id="gantt"></svg>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {

            var tasksData = @json($tasks);
            var modifiedTasks = [];

            // タスクがない場合、update処理に使用する変数にnullを渡さないため
            window.checkTask = function() {
                if (tasksData.length === 0) {
                    alert("タスクがありません");
                    return false;
                } else {
                    return true;
                }
            }

            // FrappeGantt用データ変換
            var ganttData = tasksData.map(function(task) {
                var start = task.start_date ? new Date(task.start_date).toISOString().split("T")[0] : null;
                var end = task.due_date ? new Date(task.due_date).toISOString().split("T")[0] : null;

                return {
                    id: task.id,
                    name: task.title,
                    start: start,
                    end: end,
                    progress: parseFloat(task.progress) || 0,
                    dependencies: task.parent_id ? task.parent_id : ""
                };
            });

            if (ganttData.length === 0) {
                console.warn("No tasks available for Gantt chart.");
                return;
            }

            var gantt = new Gantt("#gantt", ganttData, {
                header_height: 50,
                column_width: 30,
                step: "day",
                bar_height: 20,
                padding: 18,
                view_mode: "Day",
                date_format: "YYYY-MM-DD",
                // タスク日付変更時
                on_date_change: function(task, start, end) {
                    var modifiedTask = modifiedTasks.find(t => t.id === task.id);
                    if (modifiedTask) {
                        modifiedTask.start = start;
                        modifiedTask.end = end;
                    } else {
                        modifiedTasks.push({
                            id: task.id,
                            start: start,
                            end: end
                        });
                    }
                },
                // on_progress_change: (task, progress) => {
                //     var modifiedTask = modifiedTasks.find(t => t.id === task.id);
                //     if (modifiedTask) {
                //         modifiedTask.progress = progress;
                //     } else {
                //         modifiedTasks.push({
                //             id: task.id,
                //             progress: progress,
                //         });
                //     }
                // },
            });
            // 変更内容送信
            document.getElementById('updateBtn').addEventListener('click', function(event) {

                // modifiedTasksをセット
                document.getElementById('modifiedTasks').value = JSON.stringify(modifiedTasks);

                // フォームの送信
                document.getElementById('updateForm').submit();
                console.log("Before Submit:", modifiedTasks);
            });

            gantt.render();
        });

    </script>
@endsection
