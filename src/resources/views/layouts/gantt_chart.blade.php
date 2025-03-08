@extends('layouts.app')

@section('content')
    <h2>個別課題 - ガントチャート</h2>

    {{-- @yield('cdn') --}}
    @include('layouts.cdn')

    <form id="updateForm" action="{{ route('gantt_chart.update') }}" method="POST" onSubmit="return checkTask()">
        @csrf
        @method('PUT')
        <input type="hidden" name="modifiedTasks" id="modifiedTasks">
        <button type="submit" id="updateBtn" class="btn btn-sm btn-primary">更新</button>
    </form>

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <svg id="gantt"></svg>
    @yield('ganttChart')

@endsection
