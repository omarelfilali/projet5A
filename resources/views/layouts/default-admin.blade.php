<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>MYENSIM | Administration</title>
        {{-- Styles  --}}
        {{-- <link rel="stylesheet" type="text/css"href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}

        @vite(['resources/css/admin.css', 'resources/css/module_materiel.css', 'resources/js/admin.js'])

        @toastr_css
        @toastr_js

    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">



            @include('partials.admin.header')

            @include('partials.admin.sidebar')

            <div class="content-wrapper">

                @section('breadcrumbs')
                    {{-- {{ Breadcrumbs::render()}} --}}
                @endsection
                
                @isset($datatable)
                  @include('partials.admin.datatable')
      		      @endisset

      		      @isset($search_bar)
                  @include('partials.admin.searchbar')
      		      @endisset

                @include('partials.admin.modal')

                @yield('content')
            </div>

            @include('partials.admin.footer')

            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>

    </body>


</html>
