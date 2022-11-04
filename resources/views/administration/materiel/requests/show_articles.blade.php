<div class="card card-primary card-outline">
            <div class="card-header with-border">
                <h3 class="card-title">{{ $type == "RESPM" ? __('msg.loan_details') : __('msg.request_details') }}</h3>
            </div>
            <div class="card-body table-responsive no-padding">
                <table class="table table-striped">
                    <tbody>
                    @if (auth()->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
                        <tr>
                            <th style="width:30%">{{ __('msg.article') }}</th>
                            <th style="width:25%">{{ trans_choice('msg.type', 1) }}</th>
                            <th style="width:30%">{{ __('msg.serial_nb') }}</th>
                            <th style="width:15%">{{ trans_choice('msg.action', 2) }}</th>
                        </tr>
                    @else
                        <tr>
                            <th style="width:40%">{{ __('msg.article') }}</th>
                            <th style="width:30%">{{ trans_choice('msg.type', 1) }}</th>
                            <th style="width:40%">{{ __('msg.serial_nb') }}</th>
                        </tr>
                    @endif
                    @foreach ($demande->articles as $article)
                    <tr>
                        @isset ($article_edit)
                            @if ($article_edit == $article->reference->id && Auth::guard('personnel')->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
                                <form method="POST" action={{ route('administration.materiel.requests.products.update', ['id' => $demande->id, 'article' => $article->reference->id]) }}>
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <td>{{$article->reference->produit->nom}}</td>
                                    <td>{{$article->reference->produit->type->nom}}</td>
                                    <td>
                                        <select name="update_product" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
                                            <option value=''>--{{__('msg.select')}}--</option>
                                            @foreach ($article->reference->produit->referencesdisponibles as $r)
                                            <option value={{ $r->id }}>{{$r->numero_serie}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><button type="submit" class="btn btn-primary btn-flat">{{ __('msg.apply') }}</button></td>
                                </form>
                            @else
                                <td>{{$article->reference->produit->nom}}</td>
                                <td>{{$article->reference->produit->type->nom}}</td>
                                <td>{{$article->reference->numero_serie}}</td>
                                @if (auth()->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
                                    <td><a href="{{ route('administration.materiel.requests.products.edit', ['id' => $demande->id, 'article' => $article->reference->id]) }}">{{ __('msg.replace') }}</a></td>
                                @endif
                            @endif
                        @endisset

                        @empty($article_edit)
                            <td>{{$article->reference->produit->nom}}</td>
                            <td>{{$article->reference->produit->type->nom}}</td>
                            <td>{{$article->reference->numero_serie}}</td>
                            @if (auth()->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
                                <td><a href="{{ route('administration.materiel.requests.products.edit', ['id' => $demande->id, 'article' => $article->reference->id]) }}">{{ __('msg.replace') }}</a></td>
                            @endif
                        @endempty
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
