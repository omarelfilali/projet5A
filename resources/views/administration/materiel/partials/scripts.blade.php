<script>
    $(function () {
        $(".select2").select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style'
        });

        // $('#datepicker').datepicker({
        //     autoclose: true,
        //     format: 'dd/mm/yyyy',
        //     language: 'fr'
        // })

        $(".date-picker").flatpickr({
            mode: "range",
            locale: "fr",
            allowInput: true,
        });

        //Date range picker
        //$('#reservation').daterangepicker();

        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });

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
