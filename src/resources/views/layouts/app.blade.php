<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TaskManager</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>





<header>
  <div class="header-container">
    <h1>タスク管理</h1>
    <nav class="header-nav">
      <ul>
        <li><a href="{{ route('create') }}">新規作成</a></li>
        {{-- <li><a href="{{ route('notifications') }}">お知らせ</a></li> --}}
        <li>
          <a href="{{ route('alarms') }}" class="alarm-link">
            アラーム
            @if (isset($taskCount) && $taskCount > 0)
                <span class="badge">{{ $taskCount }}</span>
            @endif
          </a>
        </li>
      </ul>
    </nav>
  </div>
</header>





<div class="container">
  <nav class="menu">
    <ul>
      <li><a href="{{ route('home') }}">ホーム</a></li>
      <li><a href="{{ route('tasks.index') }}">課題一覧</a></li>
      <li><a href="{{ route('my_task') }}">個別課題</a></li>
    </ul>
  </nav>

  <main class="content">
    @yield('content')
  </main>
</div>





</body>
</html>
