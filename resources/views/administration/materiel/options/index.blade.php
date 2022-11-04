@extends('layouts/default-admin')

@section('content')


<section class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">Matériel - Paramètres</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
                <li class="breadcrumb-item active">Paramètres</li>
              </ol>
          </div><!-- /.col -->
      </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-info">
            <form method="POST" action={{ route('administration.materiel.options.update') }} autocomplete="off">
              {{ method_field('PATCH')}}
              @csrf
              <div class="card-header">
                  <h3 class="card-title">{{ __('msg.loan_start_date_default') }}</h3>
              </div>
              <div class="card-body">
                <div class="form-group @error('loan_start_date') has-error @enderror">
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="fa fa fa-calendar"></i>
                                </span>
                                <input type="text" name="loan_start_date" class="form-control form-group pull-right" id="datepicker"/>
                    {{-- {{dd($emprunts_from)}}
                    <input class="date-picker form-control  form-group pull-right" name="loan_start_date" id="periode-voeux" value="{{$emprunts_from->format('d/m/Y')}}"> --}}
                              </div>
                  @error('loan_start_date')
                    <span class="help-block">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="col-md-12">
                  <div style="text-align: center; margin-top: 10px;">
                      <button type="submit" class="btn btn-success">{{ __('msg.apply') }}</button>
                  </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


<script type="module">
$(document).ready(function() {
    $("#datepicker").datepicker({ dateFormat: 'd/m/Y' }).datepicker("setDate", "{{$emprunts_from->format('d/m/Y')}}");
    console.log($("#datepicker"));
});

    // $( document ).ready(function() {
    //     $(".date-picker").flatpickr({
    //         locale: "fr",
    //         allowInput: true,
    //         dateFormat: "d/m/Y",
    //     });
    // });

</script>
@endsection
