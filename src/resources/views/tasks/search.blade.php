@extends('layouts.app')

@section('content')
<div class="container">
    <h2>タスク検索結果</h2>

    <form action="{{ route('tasks.search') }}" method="GET" class="mb-3">
        <input type="text" name="search_task" value="{{ old('search_task', $query) }}" placeholder="タスク名で検索">
        <input type="submit" value="検索">
    </form>

    @if(isset($tasks))
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>タイトル</th>
                        <th>ステータス</th>
                        <th>開始日</th>
                        <th>親タスク</th>
                        <th>期日</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td>
                                <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                            </td>
                            <td>
                                <x-status-select :selected="$task->status" disabled />
                            </td>
                            <td>{{ $task->start_date->format('Y-m-d') }}</td>
                            <td>
                                {{ $task->parent?->title ?? 'なし' }}
                            </td>
                            <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '未設定' }}</td>
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">編集</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('本当に削除しますか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">削除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>該当するタスクがありません。</p>
    @endif
</div>
@endsection
