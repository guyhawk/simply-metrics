<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="/css/app.css">

    </head>
    <body>
        <div class="layout">
          <x-sidebar/>
            <div class="content">
                @yield('content')
            </div>
        </div>

         @stack('js')
    </body>
</html>
