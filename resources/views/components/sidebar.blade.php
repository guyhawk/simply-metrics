<div class="sidebar">
    <div class="app-name">
        {{ config('app.name') }}
    </div>
    <div class="add-block">
        <a href="{{ route('dashboard.create') }}" class="btn btn-primary">{{__('Add')}}</a>
    </div>

    <nav class="nav">
        @foreach ($counters_list as $item)
            <a href="{{ route("dashboard.show", $item->id ) }}" class="nav__item">{{ $item->site_name }} </a>
         @endforeach
    </nav>
    <div class="sidebar-footer">
        <a href="{{ route('login.logout') }}" class="">{{__('Logout')}}</a>
    </div>
</div>
