@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">課題一覧</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">新規作成</a>

        @if ($tasks->isEmpty())
            <p class="text-muted">タスクはありません。</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>タイトル</th>
                            <th>ステータス</th>
                            <th>開始日</th>
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
        @endif
    </div>
@endsection
