<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UCVME') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:400,600">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
              integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
              crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @stack('styles')
    </head>
    <body>
        <div id="app">
            <div class="flex ">
                <main class="w-full lg:w-1/2 xl:w-1/3 h-full flex items-start sm:items-center justify-center">
                    @yield('content')
                </main>
                <aside class="lg:w-1/2 xl:w-2/3 h-full bg-auth"></aside>
            </div>
        </div>

        @routes
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>