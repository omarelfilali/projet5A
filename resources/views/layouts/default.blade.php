<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyENSIM</title>

    <link rel="icon" href="favicon.ico">
    <link rel="icon" type="image/png" href="favicon.png">

    {{-- <link rel="stylesheet" href="{{ asset('css/import.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css"> -->
    <script type="text/javascript" src="{{ asset('js/import.js') }}"></script>

    <!-- Importation de fancybox 4.0 -->
    <link rel="stylesheet" href="{{ asset('plugins/fancybox-4.0/fancybox.css') }}">
    <script type="text/javascript" src="{{ asset('plugins/fancybox-4.0/fancybox.umd.js') }}"></script>
    
    <!-- Importation de nos propres fichiers CSS et JS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript" src="{{asset('js/choix_proj.js')}}"></script> --}}

    @vite(['resources/css/app.css','resources/js/app.js','resources/js/choix_proj.js'])

</head>
<body>
    @include('partials.header')
    @yield('content')
    @include('partials.footer') 
</body>
</html>