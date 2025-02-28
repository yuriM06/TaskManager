@extends('layouts.app')

@section('content')
    <h2>個別課題 - ガントチャート</h2>

    <!-- ガントチャート表示エリア -->
    <div id="gantt_here" style="width: 100%; height: 500px;"></div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.css" integrity="sha512-57KPd8WI3U+HC1LxsxWPL2NKbW82g0BH+0PuktNNSgY1E50mnIc0F0cmWxdnvrWx09l8+PU2Kj+Vz33I+0WApw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js" integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <svg id="gantt"></svg>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
    var tasks = @json($tasks);
    var today = @json($today);

    // Frappe Gantt 用データ変換
    var ganttData = tasks.map(function(task) {
        let start = task.start_date ? new Date(task.start_date).toISOString().split("T")[0] : null;
        let end = task.due_date ? new Date(task.due_date).toISOString().split("T")[0] : null;

        return {
            id: task.id,
            name: task.title,
            start: start,
            end: end,
            progress: task.progress || 0,
            dependencies: task.parent_id ? task.parent_id : ""
        };
    });

    console.log("Gantt Data:", ganttData); // データ確認用

    if (ganttData.length === 0) {
        console.warn("No tasks available for Gantt chart.");
        return;
    }

    var gantt = new Gantt("#gantt_here", ganttData, {
        header_height: 50,
        column_width: 30,
        step: "day",
        view_modes: ["Quarter Day", "Half Day", "Day", "Week", "Month"],
        bar_height: 20,
        padding: 18,
        view_mode: "Day",
        date_format: "YYYY-MM-DD",
        today: today,
        on_date_change: function(task, start, end) {
            console.log("Task updated:", task, start, end);
            fetch(`/tasks/${task.id}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    start_date: start,
                    due_date: end
                })
            }).then(response => response.json())
              .then(data => console.log("Task successfully updated:", data))
              .catch(error => console.error("Error updating task:", error));
        }
    });

    gantt.render();
});

    </script>
@endsection
