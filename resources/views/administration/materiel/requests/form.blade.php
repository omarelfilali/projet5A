@extends('layouts/default-admin')

@section('content')

<section class="content">
  <div class="container-fluid">
    <form method="POST" action="{{ route('administration.materiel.respmateriel.emprunts.create') }}" autocomplete="off">
        {{ method_field('PUT') }}
        @csrf
        <div class="card card-info">
          <div class="card-header with-border">
            <h3 class="card-title">{{ trans_choice('msg.product', 1) }}</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group @error('produit') has-error @enderror">
                      <label>{{ __('msg.product_name') }}</label>
                      <select id="produits" name="produit" class="form-control" style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                          <option value=''>--{{__('msg.select')}}--</option>
                          @foreach ($produits as $p)
                          <option value={{ $p->id }}>{{$p->nom}}</option>
                          @endforeach
                      </select>
                      @error('produit')
                      <span class="help-block">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group @error('numero_serie') has-error @enderror">
                      <label>{{ __('msg.serial_nb') }}</label>
                      <select id="numero_series" name="numero_serie" class="form-control" style="width: 100%;" data-placeholder='--Sélectionner--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                          <option value=''>--{{__('msg.select')}}--</option>
                      </select>
                      @error('numero_serie')
                      <span class="help-block">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-primary">
          <div class="card-header with-border">
            <h3 class="card-title">{{ trans_choice('msg.information', 2) }}</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card-profile">
                  <ul class="nav nav-stacked">
                    <div class="form-group @error('etudiant') has-error @enderror w-100">
                      {{-- <label>{{ trans_choice('msg.student', 1) }} et {{ trans_choice('msg.staff', 1) }}</label> --}}
                      <label>Emprunteur</label>
                      <select id="etudiant" name="etudiant" class="form-control" style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                        <option value=''>--{{__('msg.select')}}--</option>
                        @foreach ($etudiants as $e)
                          <option value={{ $e->id }}>{{$e->nomprenom}}</option>
                        @endforeach
                        @foreach ($personnels as $p)
                          <option value={{ $p->id }}>{{$p->nomprenom}}</option>
                        @endforeach
                      </select>
                      @error('etudiant')
                        <span class="help-block">{{ $message }}</span>
                      @enderror
                    </div>
                  </ul>

                  <div id="etudiant_div" class="d-flex flex-column align-items-center" style="display:none">
                    <img id="etudiant_img" style="object-fit: cover; height:100px;" class="profile-user-img img-responsive img-circle" src="">
                    <h3 class="profile-username text-center mb-2" id="etudiant_nom"></h3>
                    <p class="text-muted text-center" id="etudiant_promo"></p>
                  </div>

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group @error('timerangeend') has-error @enderror">
                  <label>{{ __('msg.reservation_endtime') }}</label>
                  <div class="input-group">
                    <span class="input-group-text">
                      <i class="fa fa fa-calendar"></i>
                    </span>
                    <input class="form-control form-group flatpickr-input active" id="dateRetour" name="timerangeend" type="text" placeholder="Merci de sélectionner une date de retour" readonly="readonly">
                    {{-- <input type="text" name="timerangeend" class="form-control form-group pull-right" id="datepicker"/> --}}
                  </div>
                  @error('timerangeend')
                    <span class="help-block">{{ $message }}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label>{{ trans_choice('msg.information', 2) }}</label>
                  <textarea class="form-control" name="description" rows="6" placeholder="Facultatif"></textarea>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div style="text-align: center;">
          <button type="submit" class="btn btn-primary">{{ __('msg.add') }}</button>
        </div>
      </form>
  </div>
</section>

<script type="module">

    $(document).ready(function() {
      @if (count($errors) > 0)
        display_selected_product();
        display_selected_ref();
        display_selected_student();
        display_selected_period();
      @endif
    });

    $('.select2').select2();

    $("#dateRetour").flatpickr({
      dateFormat: "d/m/Y",
      minDate: "today"
    });

    $('#etudiant').on('change', function (e) {
      // loadStudentPicture(e.params.data.id);
      loadStudentPicture($(this).find(":selected").val(), false);
    });

    $('#produits').on('change', function (e) {
      // loadReferences(e.params.data.id, false);
      loadReferences(parseInt($(this).find(":selected").val()), false);
    });

    function display_selected_product() {
      @if (old('produit', null) != null)
        var product_id = "{{ old('produit') }}";
        $('#produits').val(product_id);
        $('#produits').trigger('change');
        loadReferences(product_id, true);
      @endif
    }

    function display_selected_ref() {
      @if (old('numero_serie', null) != null)
        $('#numero_series').val("{{ old('numero_serie') }}")
        $('#numero_series').trigger('change');
      @endif
    }

    function display_selected_student() {
      @if (old('etudiant', null) != null)
        var student_id = "{{ old('etudiant') }}";
        $('#etudiant').val(student_id);
        $('#etudiant').trigger('change');
        loadStudentPicture(student_id);
      @endif
    }

    // function display_selected_period() {
    //   @if (old('timerangestart', null) != null)
    //     $('#timerangestart').val("{{ old('timerangestart') }}")
    //     $('#timerangestart').trigger('change');
    //   @endif
    //   @if (old('timerangeend', null) != null)
    //     $('#timerangeend').val("{{ old('timerangeend') }}")
    //     $('#timerangeend').trigger('change');
    //   @endif
    // }

    function loadStudentPicture(etudiant_id) {
        var etudiant_content = document.getElementById('etudiant_div');
        etudiant_content.style="display: none";
        $.ajax({
            type: "POST",
            url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/etudiant') : url('api/etudiant') }}",
            data: {
                id: etudiant_id
            },
            success: function(data) {
                document.getElementById('etudiant_nom').innerHTML = data["prenom"]+" "+data["nom"];
                document.getElementById('etudiant_img').src = data["photo"];
                document.getElementById('etudiant_promo').innerHTML = "Etudiant en "+data["promo"];
                etudiant_content.style="display: block";
            }
        });
    }

    function loadReferences(produit_id, loadOldRef) {
        $('#numero_series').empty();
        // $("#numero_series").select2().val(0).trigger('change');
        $("#numero_series").val(0).trigger('change');
        $.ajax({
            type: "POST",
			      url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/produits/references') : url('api/produits/references') }}",
            data: {
                id: produit_id
            },
            success: function(data) {
                data.sort(function(a, b){
                    return ((b.dispo ? 100000 : 0) + b.id) - ((a.dispo ? 100000 : 0) + a.id);
                });
                $('#numero_series').empty();
                // $("#numero_series").select2().val(0).trigger('change');
                $("#numero_series").val(0).trigger('change');

                var series = document.getElementById('numero_series');
                var optionDefault = document.createElement("option");
                optionDefault.value = '';
                optionDefault.innerHTML = "--{{__('msg.select')}}--";
                series.append(optionDefault);

                data.forEach(function(f) {
                    var option = document.createElement("option");
                    option.setAttribute('value', f["id"]);
                    option.innerHTML = f["numero_serie"];
                    if (f["dispo"] == false){
                        option.setAttribute('disabled', '');
                    }
                    series.append(option);
                });

                if (loadOldRef) {
                  display_selected_ref();
                }
            }
        });
    }

</script>
@endsection
