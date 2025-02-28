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

        <label for="due_date">期日:</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : now()->addWeek()->format('Y-m-d')) }}">

        <button type="submit">更新</button>
    </form>
@endsection
