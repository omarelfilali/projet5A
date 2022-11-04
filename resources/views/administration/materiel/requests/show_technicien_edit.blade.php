<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('msg.possible_modifs') }}</h3>
    </div>
    <div class="panel-body">
        <div class="form-group @error('timerangestart') has-error @enderror @error('timerangeend') has-error @enderror">
            <label>{{ __('msg.period_change') }}</label>
            <form method="POST" action={{ route('administration.materiel.requests.periode.update', ['id' => $demande->id]) }} style="display:flex">
                {{ method_field('PATCH') }}
                @csrf
                <input type="hidden" name="timerangestart" id="timerangestart"/>
                <input type="hidden" name="timerangeend" id="timerangeend"/>
                <input type="text" class="form-control group-edit" id="timerange"/>
                <button style="margin-left: 3px;" type="submit" class="btn btn-primary btn-flat btn-edit">{{ __('msg.apply') }}</button>
            </form>
            @error('timerangestart')
            <span class="help-block">{{ $message }}</span>
            @enderror
            @error('timerangeend')
            <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="panel-body">
        <div class="form-group @error('add_encadrant') has-error @enderror">
            <label>{{ __('msg.add_supervisor') }}</label>
            <form method="POST" action={{ route('administration.materiel.requests.encadrants.add', ['id' => $demande->id]) }}>
                {{ method_field('PUT') }}
                @csrf
                <select name="add_encadrant" class="form-control select2 select2-hidden-accessible" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value=''>--{{__('msg.select')}}--</option>
                    @foreach ($personnels as $p)
                    <option value={{ $p->uid }}>{{$p->nomprenom}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-flat btn-edit">{{ __('msg.add') }}</button>
            </form>
            @error('add_encadrant')
                <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    @if ($demande->encadrants->count() > 1)
        <div class="panel-body">
            <div class="form-group @error('delete_encadrant') has-error @enderror">
                <label>{{ __('msg.remove_supervisor') }}</label>
                <form method="POST" action={{ route('administration.materiel.requests.encadrants.delete', ['id' => $demande->id]) }}>
                    {{ method_field('DELETE')}}
                    @csrf
                    <select name="delete_encadrant" class="form-control select2 select2-hidden-accessible" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                        <option value=''>--{{__('msg.select')}}--</option>
                        @foreach ($demande->encadrants as $p)
                        <option value={{ $p->personnel->uid }}>{{$p->personnel->nomprenom}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-danger btn-flat btn-edit">{{ __('msg.remove') }}</button>
                </form>
                @error('delete_encadrant')
                    <span class="help-block">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endif

    <div class="panel-body">
        <div class="form-group  @error('edit_technicien') has-error @enderror">
            <label>{{ __('msg.technician_change') }}</label>
            <form method="POST" action={{ route('administration.materiel.requests.technicien.update', ['id' => $demande->id]) }}>
                {{ method_field('PATCH')}}
                @csrf
                <select name="edit_technicien" class="form-control select2 select2-hidden-accessible" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                    <option value=''>--{{__('msg.select')}}--</option>
                    @foreach ($techniciens as $t)
                    <option @if ($t->id == $demande->technicien->id) selected @endif value={{ $t->uid }}>{{$t->nomprenom}}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-flat btn-edit">{{ __('msg.apply') }}</button>
            </form>
            @error('edit_technicien')
                <span class="help-block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="panel-body">
        <strong><li style="margin-bottom: 3px">{{ __('msg.others_actions') }}</li></strong>
        <div class="form-group">
            <form method="POST" action={{ route('administration.materiel.requests.action', ['id' => $demande->id]) }} style="display:flex">
                {{ method_field('PATCH') }}
                @csrf
                <button style="width: 100%; margin-top: 5px" onclick="confirmerAnnulationEmprunt()" type="button" class="btn btn-danger btn-flat">Annuler la demande d'emprunt</button>
                <button style="display:none" id="confirmerAnnulationEmpruntBtn" name="action" value="refuse" type="submit"></button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmerAnnulationEmprunt(){
        setModalTitle("Êtes-vous sûr de confirmer l'annulation de la demande d'emprunt ?");
        setModalContent("");
        showModal("confirmerAnnulationEmpruntBtn");
    }
</script>
