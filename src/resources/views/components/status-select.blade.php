@props(['name' => 'status', 'selected' => ''])
@php
    $statusOptions = [
        '' => '-',
        'not_started' => '未着手',
        'planned' => '着手予定',
        'in_progress' => '着手中',
        'review' => 'レビュー中',
        'testing' => 'テスト中',
        'completed' => '完了',
    ];
@endphp

{{-- プルダウンのステータス --}}
@if(request()->routeIs('tasks.show'))
    {{ $statusOptions[$selected] ?? '未設定' }}
@else
    <select name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
        @foreach ($statusOptions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
@endif