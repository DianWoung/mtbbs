<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'MTBBS') - 梦途科技内部论坛</title>
    <meta name="description" content="@yield('description','MTBBS')" />
    <!-- Styles -->
    <link href="https://cdn.bootcss.com/github-markdown-css/2.10.0/github-markdown.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.css" rel="stylesheet">
   <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="{{ route_class() }}-page">

        <div id="wrapper">
            <div class="overlay">
            </div>
            @include('layouts._header')
        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container">
            @include('layouts._message')
            @yield('content')
            </div>
        </div>
            @include('layouts._footer')
        </div>
    </div>
    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.bootcss.com/highlight.js/9.13.1/highlight.min.js"></script>
<script src="https://cdn.bootcss.com/simplemde/1.11.2/simplemde.min.js"></script>
<script type="text/javascript">
        @yield('scripts')
</script>

</body>
</html>