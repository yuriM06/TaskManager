@extends('layouts.app')

@section('content')
    <h2>タスク一覧</h2>
    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('tasks.create') }}">新規作成</a>
    <ul>
        @forelse($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>

                <p>
                    <strong>ステータス:</strong>
                    <x-status-select :selected="$task->status" />
                </p>

                <p>作成日: {{ $task->created_at->format('Y-m-d') }}</p>
                <p>期日: {{ $task->due_date ? $task->due_date->format('Y-m-d') : '未設定' }}</p>

                <a href="{{ route('tasks.edit', $task->id) }}">編集</a>

                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </li>
        @empty
            <li>タスクはありません。</li>
        @endforelse
    </ul>
@endsection
