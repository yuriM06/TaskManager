@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">新規作成</h2>

        <form action="{{ route('tasks.store') }}" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">タイトル:</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">説明:</label>
                <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">ステータス:</label>
                <x-status-select name="status" class="form-control"/>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">開始日:</label>
                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', now()->format('Y-m-d')) }}">
                @error('start_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">期日:</label>
                <input type="date" name="due_date" class="form-control" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">
                @error('due_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="progress" class="form-label">進捗:</label>
                <input type="number" name="progress" class="form-control" step="1" min="0" max="100" value="{{ old('progress', 0) }}" placeholder="進捗 (0〜100)">
                @error('progress')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">親タスク:</label>
                <select name="parent_id" class="form-select">
                    <option value="">親タスクなし</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}" {{ old('parent_id') == $task->id ? 'selected' : '' }}>{{ $task->title }}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
@endsection
