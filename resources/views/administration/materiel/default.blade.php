<!DOCTYPE html>
<html>

<head>
    <title>MyEnsim | Inventaire</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('css/materiel/AdminLTE.css') }}" type="text/css">
    
    <script type="text/javascript" src="{{ asset('js/import.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/import-admin.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/import.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/import-admin.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" type="text/css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/materiel/_all-skins.min.css') }}" /> --}}


    @yield('css')
    @toastr_css
    <style>
        #toast-container>div {
            opacity: 1;
            -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
            filter: alpha(opacity=100);
        }

        @media screen and (min-width: 767px) {
            #olbreadcrumb {
                display: inline-flex;
            }
        }

        @media screen and (max-width: 767px) {
            #olbreadcrumb {
                display: block;
            }
        }

    </style>
    @toastr_js
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('partials.admin.header')

        @include('partials.admin.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    {{ isset($title) ? " $title" : "" }}
                    <small class="desktop-only">{{ isset($small_title) ? " $small_title" : "" }}</small>
                </h1>
                @isset($datatable)
                <ol class="breadcrumb" id="olbreadcrumb">
                    <div style="display: inline-block;top: -10px;position: relative;height: 28px;">
                        @yield('content_header')
                    </div>
                    <div class="box-tools" style="">
                        <div>
                            <select class="form-control select2" id="pageamount_datatable">
                                <option value="10">10 éléments</option>
                                <option value="25">25 éléments</option>
                                <option value="50">50 éléments</option>
                                <option value="100">100 éléments</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-tools" style="margin-left: 5px">
                        <div class="input-group" style="width: 200px;">
                            <input type="text" id="search_bar_datatable" name="search_bar_datatable" class="form-control input-sm pull-right" placeholder="Rechercher">
                        </div>
                    </div>
                </ol>
                @endisset
                @isset($search_bar)
                <ol class="breadcrumb" style="display: inline-flex;">
                    <div style="">
                        @yield('content_header')
                    </div>
                    <div class="box-tools" style="margin-left: 5px">
                        <div class="input-group" style="width: 200px;">
                            <input type="text" id="search_bar" name="search_bar"
                                class="form-control input-sm pull-right" placeholder="Rechercher">
                        </div>
                    </div>
                </ol>
                @endisset
            </section>
            <section class="content">
                @include('flash::message')
                @toastr_render
                @include('panel.partials.modal')
                @yield('content')
            </section>
        </div>
        @include('partials.admin.footer')
    </div>
</body>

@include('panel.partials.scripts')
@isset($search_bar)
<script>
    var search_bar = document.getElementById("search_bar");
    var search_bar_btn = document.getElementById("search_bar_btn");
    var elements = document.getElementsByClassName("elem-row");

    search_bar.addEventListener('input', function (event) {
        var value = search_bar.value;
        onSearch(value);
    });

</script>
@endisset

@isset($datatable)
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            "bInfo": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
            "initComplete": function (settings, json) {
                var paginate = document.getElementById('datatable_paginate');
                paginate.parentElement.style.width = "100%";

                document.getElementById('datatable_length').style.display = "none";
                document.getElementById('datatable_filter').style.display = "none";

                $("#search_bar_datatable").bind("input", function () {
                    var table = $('#datatable').DataTable();
                    table.search($("#search_bar_datatable").val());
                    table.draw();
                });

                $('#pageamount_datatable').on('change', function () {
                    var table = $('#datatable').DataTable();
                    table.page.len(this.value).draw();
                });

                $('#pageamount_datatable').select2({
                    minimumResultsForSearch: -1
                });
            }
        });
    });

</script>
@endisset
@yield('js')

</html>
