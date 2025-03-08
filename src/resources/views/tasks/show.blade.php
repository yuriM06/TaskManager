@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">タスク詳細</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $task->title }}</h5>
                <p class="card-text"><strong>説明:</strong> {{ $task->description }}</p>

                <p class="card-text">
                    <strong>ステータス:</strong>
                    <x-status-select :selected="$task->status" disabled />
                </p>

                <p class="card-text"><strong>開始日:</strong> {{ $task->start_date->format('Y-m-d') }}</p>
                <p class="card-text"><strong>期日:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : '未設定' }}</p>

                <div class="d-flex">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary me-2">編集</a>

                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
