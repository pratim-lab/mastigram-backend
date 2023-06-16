<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/admin/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="row" id="login-page">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth ">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
