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
        <input type="text" name="status" required>

        <button type="submit">保存</button>
    </form>
@endsection
