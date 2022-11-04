<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets</title>

    <script type="text/javascript" src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <link rel="icon" href="favicon.ico">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="https://cdn-ensim.univ-lemans.fr/css/font-awesome/5.3.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script type="text/javascript" async="" defer="" src="http://e-www3-t1.univ-lemans.fr/statistiques/matomo.js"></script>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- <link rel="stylesheet" href="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/css/mdb.min.css">
    <link rel="stylesheet" href="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/docs-app/css/compiled-addons-4.20.0.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <!-- <link rel="stylesheet" href="http://e-www3-t1.univ-lemans.fr/style.css" media="all" type="text/css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/plugins/datatables/datatables.min.js')}}"></script>  
    <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <script src="http://e-www3-t1.univ-lemans.fr/include/navTable.js"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <!-- <link rel="stylesheet" href="{{ asset('/css/semantic.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/transition.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn-ensim.univ-lemans.fr/css/font-awesome/6.1.1/css/all.css">
    <link rel="stylesheet" href="http://e-www3-t1.univ-lemans.fr/print.css" media="print" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" media="all" type="text/css">

    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">

</head>
<body>
    @include('partials.header')
    @yield('content')
    @include('partials.footer') 
</body>
</html>