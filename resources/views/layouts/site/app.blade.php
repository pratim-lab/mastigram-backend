<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (isset($title) && !empty($title)) ? $title : 'Rakhi Worldwide' }}</title>

    @include('partials.head')

</head>
<body>
    <div id="main">
        @include('partials.header')

        <div class="bodypart">
            @yield('content')
        </div>

        @include('partials.footer')
    </div>
</body>
</html>
