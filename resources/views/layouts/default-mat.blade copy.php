<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initital-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <meta http-equiv="Content-Language" content="fr"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="author" content="ENSIM"/>
        <meta name="description" content="ENSIM Ecole Nationale Supérieure d'Ingénieurs du Mans forme en trois ans
        des ingénieurs dans deux spécialités : L'acoustique, les vibrations, les capteurs, l'instrumentation optique et
        les microtechnologies d'une part; et d'autre part en informatique, selon deux options : Architecture des
        Systèmes Temps Réel Embarqués (ASTRE); et Intéractions Personne - Systèmes (IPS) (IHM)."/>
        <title>Inventaire Matériel</title>

        <link rel="icon" href="favicon.ico">
        <link rel="icon" type="image/png" href="favicon.png">   
           

        {{-- <!-- Importation des fichiers css utilisés par Matériel -->

        // NORMALEMENT C OK :

        <link rel="stylesheet" href="{{ asset('/css/materiel/semantic.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/materiel/menu.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/materiel/dropdown.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/materiel/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/materiel/transition.css') }}">

        <script type="text/javascript" src="{{ asset('plugins/jquery-3.6.0/jquery.min.js') }}"></script>
      
        <link rel="stylesheet" href="{{ asset('plugins/jquery-ui-1.13.1/jquery-ui.min.css') }}">
        <script type="text/javascript" src="{{ asset('plugins/jquery-ui-1.13.1/jquery-ui.min.js') }}"></script>

        <!-- <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn-ensim.univ-lemans.fr/js/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://cdn-ensim.univ-lemans.fr/css/jqueryui/1.11.4/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->

        <!-- Importation de datatables 1.12.1 -->
        <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables+extensions/datatables.min.css') }}"/>
        <script type="text/javascript" src="{{ asset('plugins/datatables+extensions/datatables.min.js') }}"></script>
        <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="{{ asset('/js/jquery.dataTables.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script> -->

        <!-- Importation de select2 4.0.13 -->
        <link rel="stylesheet" href="{{ asset('plugins/select2-4.0.13/css/select2.min.css') }}">
        <script type="text/javascript" src="{{ asset('plugins/select2-4.0.13/js/select2.full.min.js') }}"></script>
        <!-- <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script> -->

        <!-- Importation de sweetalert2 11.4.16 -->
        <script type="text/javascript" src="{{ asset('plugins/sweetalert2-11.4.16/sweetalert2.all.min.js')}}"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script> -->

        <!-- Importation de fancybox 4.0 -->
        <link rel="stylesheet" href="{{ asset('plugins/fancybox-4.0/fancybox.css') }}">
        <script type="text/javascript" src="{{ asset('plugins/fancybox-4.0/fancybox.umd.js') }}"></script>
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" media="all" type="text/css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script> -->

        <!-- Importation de Ajax (a vérifier si on peut remplacer par fetch api) -->
        <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

        <!-- Importation des fonts  -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap">
    	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <!-- Importations css pour des icônes -->
        <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn-ensim.univ-lemans.fr/css/font-awesome/6.1.1/css/all.css">
        <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css"> -->

        <!-- Importation de mdbootstrap (A vérifier si c'est utilisé) -->
        <link rel="stylesheet" href="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/css/mdb.min.css">
        <link rel="stylesheet" href="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/docs-app/css/compiled-addons-4.20.0.min.css">
        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/js/popper.min.js"></script>
        <script type="text/javascript" src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/docs-app/js/bundles/4.20.0/compiled-addons.min.js"></script>
        <script type="text/javascript" src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/mdb-plugins-gathered.min.js"></script>
        <script type="text/javascript" src="https://mdbootstrap.com/api/snippets/static/download/MDB-Pro_4.20.0/js/mdb.min.js"></script>

        <!-- Importation de nos propres fichiers CSS et JS -->
        <link rel="stylesheet" href="http://e-www3-t1.univ-lemans.fr/style.css" media="all" type="text/css">
        <link rel="stylesheet" href="http://e-www3-t1.univ-lemans.fr/print.css" media="print" type="text/css">
        <script src="http://e-www3-t1.univ-lemans.fr/include/navTable.js"></script>
        <script src="{{ asset('js/materiel/semantic.js') }}"></script>
        <script src="{{ asset('js/materiel/transition.js') }}"></script>
        <script src="{{ asset('js/materiel/dropdown.js') }}"></script>
        <script src="{{ asset('js/materiel/header.js') }}"></script>
        <script src="http://e-www3-t1.univ-lemans.fr/include/newIndex.js"></script>

        <!-- Importation de plugins utilisés uniquement par Matériel (a trier) -->
        <link rel="stylesheet" href="{{ asset('plugins/materiel/daterangepicker/daterangepicker-bs3.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/materiel/datepicker/datepicker3.css') }}">
        <script src="{{ asset('plugins/materiel/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('plugins/materiel/datepicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('plugins/materiel/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
        <script src="{{ asset('plugins/materiel/timepicker/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/materiel/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('plugins/materiel/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ asset('plugins/materiel/input-mask/jquery.inputmask.extensions.js') }}"></script>
        <script src="{{ asset('plugins/materiel/daterangepicker/moment.js') }}"></script>
        <script src="{{ asset('plugins/materiel/daterangepicker/daterangepicker.js') }}"></script>
        <script src="{{ asset('plugins/materiel/datepicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('plugins/materiel/timepicker/bootstrap-timepicker.min.js') }}"></script>
        <script src="{{ asset('plugins/materiel/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('plugins/materiel/iCheck/icheck.min.js') }}"></script>
        <script src="{{ asset('plugins/materiel/fastclick/fastclick.min.js') }}"></script> --}}

        @vite(['resources/css/app.css','resources/js/app.js', 'resources/css/module_materiel.css'])

    </head>

	@yield('css')
    @toastr_css
    <style>
    #toast-container > div {
        opacity: 1;
        -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
        filter: alpha(opacity=100);
    }
    </style>
    @toastr_js
  </head>

  <body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
      @include('partials.header')
      <div class="content-wrapper">
        <section class="content-header">
        </section>
        <section class="content">
        @include('flash::message')
        @toastr_render
        @yield('content')
		</section>
      </div>
    </div>
  </body>
  @include('partials.footer')
  

 
  @yield('js')
  <script type="module">
  $(function () {
    
	$(".select2").select2({
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style'
  });

    $('#datepicker').datepicker({
      autoclose: true,
	  format: 'dd/mm/yyyy',
	  language: 'fr'
    })

	//Date range picker
	$('#reservation').daterangepicker();

	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
	  checkboxClass: 'icheckbox_minimal-blue',
	  radioClass: 'iradio_minimal-blue'
	});

	$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
	  checkboxClass: 'icheckbox_minimal-red',
	  radioClass: 'iradio_minimal-red'
	});

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	  checkboxClass: 'icheckbox_flat-green',
	  radioClass: 'iradio_flat-green'
	});

	$(".timepicker").timepicker({
	  showInputs: false
	});
  });
</script>

</html>
