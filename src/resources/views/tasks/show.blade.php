@extends('layouts.app')

@section('content')
    <h2>タスク詳細</h2>
    <p><strong>タイトル:</strong> {{ $task->title }}</p>
    <p><strong>説明:</strong> {{ $task->description }}</p>

    <p><strong>ステータス:</strong><x-status-select :selected="$task->status" /></p>

    <p>作成日: {{ $task->created_at->format('Y-m-d') }}</p>
    <p>期日: {{ $task->due_date ? $task->due_date->format('Y-m-d') : '未設定' }}</p>

    <a href="{{ route('tasks.edit', $task->id) }}">編集</a>

    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
@endsection
