<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('msg.operations_history') }}</h3>
    </div>
    <div class="box-body table-responsive no-padding">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th style="width:20%">{{ __('msg.user') }}</th>
                    <th>{{ __('msg.description') }}</th>
                    <th style="width:20%">{{ __('msg.date') }}</th>
                </tr>
                @foreach ($demande->operations->sortByDesc("created_at") as $operation)
                <tr>
                    <td>{{ $operation->personnel->nomprenom }} (<i>{{$operation->role}}</i>)</td>
                    <td><b>{{ $operation->titre }} :</b></br>
                        @if (Str::length($operation->commentaire) == 0)
                        <i>{{ __('msg.no_comment') }}</i>
                        @else
                        <li>{{$operation->commentaire }}</li>
                        @endif
                    </td>
                    <td>{{ $operation->created_at->format('d/m/Y à H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
