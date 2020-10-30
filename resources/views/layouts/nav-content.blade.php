@if(Request::is('items/index') || Request::is('items/index/*'))
<nav class="navbar navbar-dark bg-dark">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link text-light" href="{{ route('items.index') }}">All</a>
    </li>
    @foreach($genre_for_nav as $genre)
    <li class="nav-item">
      <a class="nav-link text-light" href="/items/index/{{ $genre }}">{{ $genre }}</a>
    </li>
    @endforeach
  </ul>
  <form class="form-inline" method="GET" action="{{ route('items.create') }}">
    <button class="btn btn-sm btn-outline-secondary">新規アイテム登録</button>
  </form>
</nav>
@endif
