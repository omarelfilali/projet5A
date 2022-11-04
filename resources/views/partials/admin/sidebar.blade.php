<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary sidebar-ensim elevation-4">
	<a href="{{route('administration.index')}}" class="brand-link">
		<img src="{{asset('dist/img/logo-administration.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
			style="opacity: .8">
		<span class="brand-text font-weight-light">Administration</span>
	</a>

	<div class="sidebar">

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
				data-accordion="false">
				{{-- <li class="nav-header">MODULES</li> --}}

				<!------------------------------------------------------------
				💻 Catégories liées à l'administration du module Informatique
				------------------------------------------------------------->

				@can("administration.informatique")
					<li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'administration.informatique') ? ' menu-open' : '' }}">
						<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.informatique') ? ' active' : '' }}">
							<i class="fas fa-laptop nav-icon"></i>
							<p>
								Informatique
								<div class="right" style="margin-top: -2px;">
									<span class="badge badge-secondary mr-2" >
									{{-- {{ $notifications_informatique }}</span> --}}
									<i class="fas fa-angle-left right"></i>
								</div>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{route('administration.informatique.wifi')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.informatique.wifi') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Demandes WIFI</p>
									{{-- <span class="badge badge-danger right">{{ $notifications_informatique }}</span> --}}
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.informatique.parametres')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.informatique.parametres') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Paramètres</p>
								</a>
							</li>
						</ul>
					</li>
				@endcan

				<!------------------------------------------------------------
				✈️ Catégories liées à l'administration du module International
				------------------------------------------------------------->

				@can("administration.international")
					<li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'administration.international') ? ' menu-open' : '' }}">
						<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international') ? ' active' : '' }}">
							<i class="nav-icon fas fa-plane"></i>
							<p>
								International
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{route('administration.international.dashboard')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international.dashboard') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Dashboard</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.international.sejours')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international.sejours') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Tous les séjours</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.international.dispenses')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international.dispenses') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Dispenses</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.international.bourses')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international.bourses') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Gestion des bourses</p>
								</a>
							</li>
							{{-- <li class="nav-item">
								<a href="#" class="nav-link ">
									<i class="far fa-circle nav-icon"></i>
									<p>FAQ</p>
								</a>
							</li> --}}
							<li class="nav-item">
								<a href="{{route('administration.international.parametres')}}" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.international.parametres') ? ' active' : '' }}">
									<i class="far fa-circle nav-icon"></i>
									<p>Paramètres</p>
								</a>
							</li>
						</ul>
					</li>
				@endcan

				<!------------------------------------------------------------
				🛒 Catégories liées à l'administration du module Matériel
				------------------------------------------------------------->

				@can("administration.materiel")
					<li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'administration.materiel') ? ' menu-open' : '' }}">
						<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.materiel') ? ' active' : '' }}">
							<i class="nav-icon fas fa-shopping-basket"></i>
							<p>
								Matériel
								<div class="right" style="margin-top: -2px;">
									<span class="badge badge-secondary mr-2" >
									{{-- {{ $demandes_attente }}</span> --}}
									<i class="fas fa-angle-left right"></i>
								</div>
							</p>
						</a>
						<ul class="nav nav-treeview">

							<li class="nav-item ">
								<a href="{{route('administration.materiel.requests.index')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.requests.index' || Route::currentRouteName() == 'administration.materiel.requests.show' || Route::currentRouteName() == 'administration.materiel.requests.products.edit' ? ' active' : '' !!}">
									<i class="fa fa-shopping-cart"></i>
									<p>
										{{ trans_choice('msg.loan_request', 2) }}
										{{-- <span class="badge badge-danger right">{{ $demandes_attente }} </span> --}}
									</p>
								</a>
							</li>


							{{-- @if(Auth::guard('personnel')->user()->isTechnicien()) --}}
							@can("materiel.acces.technicien")
								<li class="nav-header">{{ __('msg.technician_space') }}</li>

								<li class="nav-item" >
									<a href="{{route('administration.materiel.categories.index')}}" class="nav-link {!! Str::startsWith(Route::currentRouteName(), 'administration.materiel.categories') ? 'active' : '' !!}">
										<i class="fa fa-sitemap"></i>
										<p>{{ trans_choice('msg.category', 2) }}</p>
									</a>
								</li>

								<li class="nav-item treeview">
									<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.materiel.types') ? ' active' : '' }}">
										<i class="fa fa-cubes"></i>
										<p>
											{{ trans_choice('msg.product_type', 2) }}
											<i class="fa fa-angle-left right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item" >
											<a href="{{route('administration.materiel.types.add_type')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.types.add_type' ? 'active' : '' !!}">
												{{ __('msg.add_type') }}
											</a>
										</li>
										<li class="nav-item" >
											<a href="{{route('administration.materiel.types.index')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.types.index'  || Route::currentRouteName() == 'administration.materiel.types.show_type'  || Route::currentRouteName() == 'administration.materiel.types.show_filter' ? 'active' : '' !!}">
												{{ __('msg.manage_types') }}
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-item treeview">
									<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.materiel.products') ? ' active' : '' }}">
										<i class="fa fa-list-ul"></i>
										<p>
											{{ trans_choice('msg.product', 2) }}
											<i class="fa fa-angle-left right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item" >
											<a href="{{route('administration.materiel.products.add_product')}}"  class="nav-link {!! Route::currentRouteName() == 'administration.materiel.products.add_product' ? 'active' : '' !!}">
											{{ __('msg.add_product') }}
											</a>
										</li>
										<li class="nav-item" >
											<a href="{{route('administration.materiel.products.index')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.products.index' || Route::currentRouteName() == 'administration.materiel.products.show_ref' || Route::currentRouteName() == 'administration.materiel.products.show' ||  Route::currentRouteName() == 'administration.materiel.products.stocks' || Route::currentRouteName() == 'products.history' ? 'active' : '' !!}">
											{{ __('msg.manage_products') }}
											</a>
										</li>
									</ul>
								</li>
							@endcan
							{{-- @if(Auth::guard('personnel')->user()->isRespMateriel()) --}}
							@can('materiel.acces.respmateriel')

								<li class="nav-header">{{ __('msg.mat_resp_space') }}</li>

								<li class="nav-item" >
									<a href="{{route('administration.materiel.respmateriel.create')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.respmateriel.create' ? 'active' : '' !!}">
										<i class="fa fa-plus"></i>
										<p>{{ __('msg.create_loan') }}</p>
									</a>
								</li>

								<li class="nav-item" >
									<a href="{{route('administration.materiel.respmateriel.emprunts')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.respmateriel.emprunts' || Route::currentRouteName() == 'administration.materiel.respmateriel.emprunts.show' ? 'active' : '' !!}">
										<i class="fa fa-eye"></i>
										<p>{{ __('msg.see_loans') }}</p>
									</a>
								</li>

								<li class="nav-item">
									<a href="{{route('administration.materiel.respmateriel.stocks')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.respmateriel.stocks' ? 'active' : '' !!}">
										<i class="fa fa-box-open"></i>
										<p>{{ __('msg.see_stocks') }}</p>
									</a>
								</li>
							@endcan
							
							{{-- @if(Auth::guard('personnel')->user()->isRespAdministratif()) --}}
							@can('materiel.acces.respadmin')
								<li class="nav-header">{{ __('msg.resp_admin_space') }}</li>

								<li class="nav-item">
									<a href="{{route('administration.materiel.insurances.index')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.insurances.index' ? 'active' : '' !!}">
										<i class="fa fa-file-invoice"></i>
										<p>{{ __('msg.insurance') }}</p>
									</a>
								</li>
							@endcan

							{{-- @if(Auth::guard('personnel')->user()->admin()) --}}
							@can('materiel.acces.admin')
								<li class="nav-header">{{ __('msg.admin_space') }}</li>

								<li class="nav-item" >
								<a href="{{route('administration.materiel.requests.admin')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.requests.admin' ? 'active' : '' !!}">
									<i class="fa fa-shopping-cart"></i>
									<p>{{ __('msg.all_requests') }}</p>
								</a>
								</li>

								<li class="nav-item ">
									<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.materiel.staff') ? ' active' : '' }}">
										<i class="fa fa-users"></i>
											<p>{{ trans_choice('msg.staff', 2) }}
											<i class="fa fa-angle-left right"></i>
										</p>
									</a>
									<ul class="nav nav-treeview">
										<li class="nav-item" >
											<a href="{{route('administration.materiel.staff.techniciens')}}" class="nav-link {!! Str::startsWith(Route::currentRouteName(), 'administration.materiel.staff.techniciens') ? 'active' : '' !!}">
												<p>{{ trans_choice('msg.technician', 2) }}</p>
											</a>
										</li>
										<li class="nav-item" >
											<a href="{{route('administration.materiel.staff.respadministratifs')}}" class="nav-link {!! Str::startsWith(Route::currentRouteName(), 'administration.materiel.staff.respadministratifs') ? 'active' : '' !!}">
												<p>{{ trans_choice('msg.admin_resp', 2) }}</p>
											</a>
										</li>
										<li class="nav-item">
											<a href="{{route('administration.materiel.staff.respmateriels')}}" class="nav-link {!! Str::startsWith(Route::currentRouteName(), 'administration.materiel.staff.respmateriels') ? 'active' : '' !!}">
												<p>{{ trans_choice('msg.mat_resp', 2) }}</p>
											</a>
										</li>
									</ul>
								</li>

								<li class="nav-item">
									<a href="{{route('administration.materiel.options.index')}}" class="nav-link {!! Route::currentRouteName() == 'administration.materiel.options.index' ? ' active"' : '' !!}">
										<i class="fas fa-cogs"></i>
										<p>{{ __('msg.options') }}</p>
									</a>
								</li>
							@endcan


						</ul>
					</li>
				@endcan

				<!------------------------------------------------------------
				🧩 Catégories liées à l'administration du module Projets
				------------------------------------------------------------->

				@can("administration.projets")
					<li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'administration.projets') ? ' menu-open' : '' }}">
						<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.projets') ? ' active' : '' }}">
							<i class="nav-icon fas fa-lightbulb"></i>
							<p>
								Projets
								<i class="fas fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="{{route('administration.projets.dashboard')}}" class="nav-link {!! Route::currentRouteName() == 'administration.projets.dashboard' ? 'active' : '' !!}">
									<i class="far fa-circle nav-icon"></i>
									<p>Tous les projets</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.projets.prop_proj')}}" class="nav-link {!! Route::currentRouteName() == 'administration.projets.prop_proj' ? 'active' : '' !!}">
									<i class="far fa-circle nav-icon"></i>
									<p>Dépôt de projet</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.projets.affectation')}}" class="nav-link {!! Route::currentRouteName() == 'administration.projets.affectation' ? 'active' : '' !!}">
									<i class="far fa-circle nav-icon"></i>
									<p>Affectation</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{route('administration.projets.parametres')}}" class="nav-link {!! Route::currentRouteName() == 'administration.projets.parametres' ? 'active' : '' !!}">
									<i class="far fa-circle nav-icon"></i>
									<p>Paramètres</p>
								</a>
							</li>
						</ul>
					</li>
				@endcan

				<!------------------------------------------------------------
				🔃 Catégories liées à l'administration du module Droits
				------------------------------------------------------------->

                <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'administration.droits') ? ' menu-open' : '' }}">
					<a href="#" class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'administration.droits') ? ' active' : '' }}">
						<i class="nav-icon fa-solid fa-ghost"></i>
						<p>
							Gestion des droits
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="{{route('administration.droits.utilisateurs')}}" class="nav-link {!! Route::currentRouteName() == 'administration.droits.utilisateurs' ? 'active' : '' !!}">
								<i class="far fa-circle nav-icon"></i>
								<p>Droits par utilisateurs</p>
							</a>
						</li>
                        <li class="nav-item">
							<a href="{{route('administration.droits.roles')}}" class="nav-link {!! Route::currentRouteName() == 'administration.droits.roles' ? 'active' : '' !!}">
								<i class="far fa-circle nav-icon"></i>
								<p>Droits par roles</p>
							</a>
						</li>
					</ul>
				</li>

			</ul>
		</nav>
	</div>

	<div class="sidebar-custom center">
		<a href="http://e-www3-t1.univ-lemans.fr/" class="btn btn-light hide-on-collapse text-center">Retour accueil</a>
	</div>
</aside>
