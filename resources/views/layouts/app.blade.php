<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Catalog</title>

    <link rel="stylesheet" type="text/css" href="{!! asset('css/app.css') !!}">
</head>
<body>
    <div class="container-fluid">
        <div class="row flex-xl-nowrap">
            <div class="col-12 col-md-3 col-xl-2">
                @include('layouts.navigation')
            </div>
            <div class="col-12 col-md-9 col-xl-10 py-md-3 pl-md-5">
                @yield('content')
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
