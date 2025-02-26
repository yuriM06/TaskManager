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
        <x-status-select name="status" :selected="$task->status" />

        <label for="due_date">期日:</label>
        <input type="date" name="due_date" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">

        <button type="submit">保存</button>
    </form>
@endsection
