<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('Meta')

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('res/bootstrap/bootstrap-4.6.2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('StyleSheet')
</head>
<body>

<section class="bg-light">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-md">
            <div>
                <button class="navbar-toggler" type="button"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand" href="#">
                    <img src="{{ asset('logo.png') }}" alt="">
                </a>
            </div>
            @section('Nav')
                @include('component.nav')
            @show
        </nav>
    </div>
</section>

@yield('PreContent')
<section id="content" class="container-fluid">
    @yield('Content')
</section>
@yield('AfterContent')

@section('Footer')
    <section id="footer" class="bg-dark">
        Footer
    </section>
@show

</body>

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('res/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('res/bootstrap/bootstrap-4.6.2.min.js') }}"></script>
@yield('Script')

</html>
