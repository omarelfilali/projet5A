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
  {{-- <script type="module">
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
</script> --}}

</html>
