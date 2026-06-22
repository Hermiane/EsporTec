<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'EsporTec')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body{
            background:#f5f7fb;
        }

        .main-content{
            margin-left:260px;
            padding:25px;
        }

        .sidebar{
            width:260px;
            position:fixed;
            left:0;
            top:0;
            height:100vh;
            background:#212529;
            overflow-y:auto;
        }

        .sidebar a{
            color:white;
            text-decoration:none;
        }

        .sidebar .nav-link{
            padding:12px 20px;
        }

        .sidebar .nav-link:hover{
            background:#343a40;
        }

        @media(max-width:768px){

            .main-content{
                margin-left:0;
            }

            .sidebar{
                display:none;
            }

        }
    </style>

    @stack('styles')

</head>

<body>

    @yield('sidebar')

    <div class="main-content">

        @include('partials.navbar')

        @yield('content')

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/esportec-ui.js"></script>

@stack('scripts')

</body>
</html>