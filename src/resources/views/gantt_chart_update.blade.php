@extends('layouts.gantt_chart')

@section('ganttChart')
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
                  dependencies: task.parent_id ? [task.parent_id] : []
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
                end.setDate(end.getDate() + 1); // FrappeGunttでのendは前日の23:59:59を表すため
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