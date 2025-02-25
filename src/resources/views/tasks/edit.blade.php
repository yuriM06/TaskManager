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
        <input type="text" name="status" value="{{ $task->status }}" required>

        <button type="submit">更新</button>
    </form>
@endsection
