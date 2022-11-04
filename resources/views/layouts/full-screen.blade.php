<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MYENSIM | Administration</title>
        {{-- Styles  --}}
        {{-- <link rel="stylesheet" type="text/css"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/import.css') }}" type="text/css">
        <script type="text/javascript" src="{{ asset('js/import.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('css/import-admin.css') }}" type="text/css">
        <script type="text/javascript" src="{{ asset('js/import-admin.js') }}"></script>

        <!-- Importations des scripts et css liés à la page -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/admin.css') }}">
        <script type="text/javascript" src="{{ asset('js/verifiPropProj.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/app.js') }}"></script> --}}

        @vite(['resources/css/admin.css', 'resources/js/admin.js'])

        @toastr_css
        @toastr_js

    </head>

    <body>
        <div>
            
            @yield('content')

        </div>
        
    </body>

    

</html>
