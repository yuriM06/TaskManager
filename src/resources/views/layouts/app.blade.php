<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>TaskManager</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>





<header>
  <nav class="header-menu">
    <div class="d-flex justify-content-between align-items-center container-fluid header-color">
      <a class="navbar-brand fs-3" href="/">タスク管理</a>
      <ul class="header-nav">
        <li>
          <a href="{{ route('tasks.create') }}">新規作成</a>
        </li>
        <li>
          <a href="{{ route('notifications') }}">お知らせ</a>
        </li>
        <li>
          <a href="{{ route('alarms') }}" class="alarm-link">
            アラーム
            @if (isset($taskCount) && $taskCount > 0)
              <span class="badge">{{ $taskCount }}</span>
            @endif
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>





<div class="row">
  <ul class="col-1 nav flex-column menu">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('home') }}">ホーム</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('tasks.index') }}">課題一覧</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('my_task') }}">個別課題</a>
    </li>
  </ul>

  <main class="col-11 content">
    @yield('content')
  </main>

</div>





</body>
</html>
