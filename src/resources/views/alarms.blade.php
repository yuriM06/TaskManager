@extends('layouts.app')

@section('content')
    <h2>期限日以前のタスク</h2>
    
    @if ($tasks->isEmpty())
        <p>本日期限のタスクはありません。</p>
    @else
        <ul>
            @foreach ($tasks as $task)
                <li>
                    <a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                    <span>期日: {{ $task->due_date->format('Y-m-d') }}</span>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
