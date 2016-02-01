<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type='image/x-icon' href="{{ asset('/img/favicon.ico') }}"/>

    <title>{{ $teamData->name }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('/libs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <link href="{{ asset('/css/frontend/agency.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/frontend/style.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body id="page-top" class="index">
    @include('frontend.partitions.navbar')

    @yield('content')

    @include('frontend.partitions.footer')
    <script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/libs/sweetalert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('/js/frontend/script.js') }}"></script>

    @yield('footer')
</body>
</html>