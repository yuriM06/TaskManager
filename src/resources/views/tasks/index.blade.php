@extends('layouts.app')

@section('content')
    <h2>タスク一覧</h2>
    <a href="{{ route('tasks.create') }}">新規作成</a>
    <ul>
        @forelse($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
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
