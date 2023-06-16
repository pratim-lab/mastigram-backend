<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - Administration</title>

    <!-- Scripts -->
    <script src="{{ asset('js/admin/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/admin/off-canvas.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/admin/bootstrap-maxlength.min.js') }}"></script>
	<script src="{{ asset('js/simply-toast.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css') }}">
    <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
    <!-- Styles -->
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('css/simply-toast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/materialdesignicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet">
    <!--<link href="{{ asset('css/admin/fontawesome-all.min.css') }}" rel="stylesheet">-->
	<link rel="stylesheet" href="{{ asset('js/admin/vendors/chartist/chartist.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
</head>
<body>
    @include('admin.partials._navbar')
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            @include('admin.partials._sidebar')
        </div>
    </div>
        @yield('content')
    @include('admin.partials._footer')
</body>
</html>
