<div class="sidebar">
    <div class="app-name">
        <a href="/"> {{ config('app.name') }}</a>
    </div>
    <div class="add-block">
        <a href="{{ route('dashboard.counter.create') }}" class="btn btn-primary">{{__('Add')}}</a>
    </div>

    <nav class="nav">
        @foreach ($counters_list as $item)
            <a href="{{ route("dashboard.counter.show", $item->id ) }}" class="nav__item {{  request()->is("dashboard/counter/{$item->id}") ? 'nav__item_active':''}}">{{ $item->site_name }} </a>
         @endforeach
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-footer__user-name">{{ Auth::user()->name }}</div>
        <a href="{{ route('login.logout') }}" class="sidebar-footer__logout">{{__('Logout')}}</a>
    </div>
</div>
