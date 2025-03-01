@extends('layouts.app')

@section('content')
    <h2>編集</h2>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="title">タイトル:</label>
        <input type="text" name="title" value="{{ $task->title }}" required>

        <label for="description">説明:</label>
        <textarea name="description" required>{{ $task->description }}</textarea>

        <label for="status">ステータス:</label>
        <x-status-select name="status" :selected="$task->status" />

        <label for="start_date">開始日:</label>
        <input type="date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}">

        <label for="due_date">期日:</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : now()->addWeek()->format('Y-m-d')) }}">

        <label for="progress">進捗:</label>
        <input type="number" name="progress" step="0.01" min="0" max="100" value="{{ old('progress', 0) }}" placeholder="進捗 (0〜100)">

        <label for="parent_id">親タスク:</label>
        <select name="parent_id">
            <option value="">親タスクなし</option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>

        <button type="submit">更新</button>
    </form>
@endsection
