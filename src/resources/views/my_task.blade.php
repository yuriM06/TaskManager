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
            // Laravelから渡されたタスクデータを取得
            var tasks = @json($tasks);
            var today = @json($today);

            // Frappe Gantt 用にタスクデータを変換
            var ganttData = tasks.map(function(task) {
                return {
                    id: task.id,
                    name: task.title, // タスク名
                    start: task.start_date, // 開始日
                    end: task.due_date, // 終了日
                    progress: task.progress || 0, // 進捗
                    dependencies: task.parent_id ? task.parent_id : "" // 親タスク（もしあれば）
                };
            });

            // ガントチャートの設定
            var gantt = new Gantt("#gantt_here", ganttData, {
                header_height: 50,
                column_width: 30,
                step: "day",
                view_modes: ["Quarter Day", "Half Day", "Day", "Week", "Month"],
                bar_height: 20,
                padding: 18,
                view_mode: "Day", // 初期表示のスケールを「日」に設定
                date_format: "YYYY-MM-DD", // 日付フォーマット
                today: today, // 今日の日付を強調表示
            });

            // ガントチャートの描画
            gantt.render();
        });
    </script>
@endsection
