@extends('layouts.app')

@section('content')
    <h2>新規作成</h2>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <label for="title">タイトル:</label>
        <input type="text" name="title" required>

        <label for="description">説明:</label>
        <textarea name="description" required></textarea>

        <label for="status">ステータス:</label>
        <x-status-select name="status" class="form-control" />

        <label for="start_date">開始日:</label>
        <input type="date" name="start_date" value="{{ old('start_date', now()->format('Y-m-d')) }}">

        <label for="due_date">期日:</label>
        <input type="date" name="due_date" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">

        <label for="progress">進捗:</label>
        <input type="number" name="progress" step="0.01" min="0" max="100" value="{{ old('progress', 0) }}" placeholder="進捗 (0〜100)">

        <label for="parent_id">親タスク:</label>
        <select name="parent_id">
            <option value="">親タスクなし</option>
            @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
            @endforeach
        </select>

        <button type="submit">保存</button>
    </form>
@endsection
