<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script
			  src="https://code.jquery.com/jquery-3.6.0.min.js"
			  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<form method="POST" action="{{route('administration.projets.encadrants_post')}}" enctype="multipart/form-data">
    @csrf
    <select class="select2"  data-placeholder="Sélection des étudiants" style="width: 100%;">
        <option>Test</option>
        <option>Testire</option>
        <option>Testons</option>
    </select>

    <select class="select" id="test" name="test" id="">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>

    <select class="select" id="test2" name="test2" id="">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>

    <button type="submit">Envoyer</button>
</form>

<script>
    // On pourrait faire une fonction qui passe en paramètre le nom de la classe du select comme ça on peut vérouiller à souhait n'importe quel select
    function disabledSelectedOptions() {
        $options = $('.select option:selected');
        $('.select option').prop("disabled", false);

        jQuery.map($options, function(n) {
            $(`.select option[value='${n.value}']`).prop("disabled", true);
        });
    }

    $('.select').change(function (e) {
        disabledSelectedOptions();
    });

    disabledSelectedOptions();

    $('.select2').select2({
        placeholder: 'Select an option',
        tags: true
    });
</script>
