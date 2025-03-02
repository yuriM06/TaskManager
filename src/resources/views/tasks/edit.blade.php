@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">編集</h2>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">タイトル:</label>
                <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">説明:</label>
                <textarea name="description" class="form-control" required>{{ $task->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">ステータス:</label>
                <x-status-select name="status" class="form-control" :selected="$task->status" />
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">開始日:</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">期日:</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : now()->addWeek()->format('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="progress" class="form-label">進捗:</label>
                <input type="number" name="progress" class="form-control" step="0.01" min="0" max="100" value="{{ old('progress', $task->progress ?? 0) }}" placeholder="進捗 (0〜100)">
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">親タスク:</label>
                <select name="parent_id" class="form-select">
                    <option value="">親タスクなし</option>
                    @foreach($tasks as $t)
                        <option value="{{ $t->id }}" {{ $task->parent_id == $t->id ? 'selected' : '' }}>
                            {{ $t->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">更新</button>
        </form>
    </div>
@endsection
