@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">新規作成</h2>

        <form action="{{ route('tasks.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">タイトル:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">説明:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">ステータス:</label>
                <x-status-select name="status" class="form-control"/>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">開始日:</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">期日:</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="progress" class="form-label">進捗:</label>
                <input type="number" name="progress" class="form-control" step="0.01" min="0" max="100" value="{{ old('progress', 0) }}" placeholder="進捗 (0〜100)">
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">親タスク:</label>
                <select name="parent_id" class="form-select">
                    <option value="">親タスクなし</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
@endsection
