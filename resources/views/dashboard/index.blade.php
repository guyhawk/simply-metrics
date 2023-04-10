@extends('layouts.base')

@section('content')


    <div class="cards-grid">
        @foreach ($counters as $counter)
            <div class="card">
                <div class="card__site-name">
                    {{ $counter->site_name }}
                </div>
                <div class="card__site-id">
                    {{ __('ID') }}: {{ $counter->counter }}
                </div>
                <div class="card__site-url">
                    {{ __('Url') }}: {{ $counter->site_url }}
                </div>
                <a href="{{ route('dashboard.counter.show', $counter->id )}}" class="card__site-link">{{ __('More >> ')}}</a>
            </div>
        @endforeach
    </div>
@endsection
