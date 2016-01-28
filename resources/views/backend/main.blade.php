<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MightyDucks Admin</title>

    <link href="{{ asset('/libs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/libs/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/backend/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/backend/timeline.css') }}" rel="stylesheet">

    <link href="{{ asset('/css/backend/style.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        @include('backend.partitions.navbar_header')
        @include('backend.partitions.navbar')
        @include('backend.partitions.sidebar')
    </nav>
    <div id="page-wrapper">
        @yield('content')
    </div>
</div>
<script src="{{ asset('/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/libs/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/libs/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/libs/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('/js/backend/sb-admin-2.js') }}"></script>

@yield('footer')
</body>
</html>