<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary sidebar-ensim elevation-4">
  
  <a href="{{route('administration.index')}}" class="brand-link">
		<img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
			style="opacity: .8">
		<span class="brand-text font-weight-light">MATERIELS</span>
	</a>

  <div class="sidebar">
    
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-basket"></i>
            <p>
              Matériel
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item" {!! Route::currentRouteName() == 'panel.requests.index' || Route::currentRouteName() == 'panel.requests.show' || Route::currentRouteName() == 'panel.requests.products.edit' ? ' class="active"' : '' !!}>
              <a href="{{route('panel.requests.index')}}" class="nav-link">
                <i class="fa fa-shopping-cart"></i> 
                <p>
                  {{ trans_choice('msg.loan_request', 2) }}
                  <span class="badge badge-danger right">{{ $demandes_attente }}
                </p>
              </a>
            </li>

            @if(Auth::guard('personnel')->user()->isTechnicien())
            <li class="nav-header">{{ __('msg.technician_space') }}</li>

            <li class="nav-item" {!! Str::startsWith(Route::currentRouteName(), 'panel.categories') ? ' class="active"' : '' !!}>
              <a href="{{route('panel.categories.index')}}" class="nav-link">
                <i class="fa fa-sitemap"></i> 
                <p>{{ trans_choice('msg.category', 2) }}</p>
              </a>
            </li>

            <li class="nav-item treeview{{ Str::startsWith(Route::currentRouteName(), 'panel.types') ? ' active' : '' }}">
              <a href="#" class="nav-link">
                <i class="fa fa-cubes"></i> 
                <p>
                  {{ trans_choice('msg.product_type', 2) }}
                  <i class="fa fa-angle-left right"></i>
                </p> 
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" {!! Route::currentRouteName() == 'panel.types.add_type' ? ' class="active"' : '' !!}>
                  <a href="{{route('panel.types.add_type')}}" class="nav-link">{{ __('msg.add_type') }}</a>
                </li>
                <li class="nav-item" {!! Route::currentRouteName() == 'panel.types.index'  || Route::currentRouteName() == 'panel.types.show_type'  || Route::currentRouteName() == 'panel.types.show_filter' ? ' class="active"' : '' !!}>
                  <a href="{{route('panel.types.index')}}" class="nav-link">{{ __('msg.manage_types') }}</a>
                </li>
              </ul>
            </li>

            <li class="nav-item treeview{{ Str::startsWith(Route::currentRouteName(), 'panel.products') ? ' active' : '' }}">
              <a href="#" class="nav-link">
                <i class="fa fa-list-ul"></i> 
                <p>
                  {{ trans_choice('msg.product', 2) }} 
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item" {!! Route::currentRouteName() == 'panel.products.add_product' ? ' class="active"' : '' !!}>
                  <a href="{{route('panel.products.add_product')}}"  class="nav-link">
                    {{ __('msg.add_product') }}
                  </a>
                </li>
                <li class="nav-item" {!! Route::currentRouteName() == 'panel.products.index' || Route::currentRouteName() == 'panel.products.show_ref' || Route::currentRouteName() == 'panel.products.show' ||  Route::currentRouteName() == 'panel.products.stocks' || Route::currentRouteName() == 'products.history' ? ' class="active"' : '' !!}>
                  <a href="{{route('panel.products.index')}}" class="nav-link">
                    {{ __('msg.manage_products') }}
                  </a>
                </li>                
              </ul>
            </li>
            @endif
            @if(Auth::guard('personnel')->user()->isRespMateriel())

            <li class="nav-header">{{ __('msg.mat_resp_space') }}</li>

            <li class="nav-item" {!! Route::currentRouteName() == 'panel.respmateriel.create' ? ' class="active"' : '' !!}>
              <a href="{{route('panel.respmateriel.create')}}" class="nav-link">
                <i class="fa fa-plus"></i> 
                <p>{{ __('msg.create_loan') }}</p>
              </a>
            </li>

            <li class="nav-item" {!! Route::currentRouteName() == 'panel.respmateriel.emprunts' || Route::currentRouteName() == 'panel.respmateriel.emprunts.show' ? ' class="active"' : '' !!}>
              <a href="{{route('panel.respmateriel.emprunts')}}" class="nav-link">
                <i class="fa fa-eye"></i> 
                <p>{{ __('msg.see_loans') }}</p>
              </a>
            </li>

            <li {!! Route::currentRouteName() == 'panel.respmateriel.stocks' ? ' class="active"' : '' !!}>
              <a href="{{route('panel.respmateriel.stocks')}}" class="nav-link">
                <i class="fa fa-box-open"></i> 
                <p>{{ __('msg.see_stocks') }}</p>
              </a>
            </li>
            @endif
            @if(Auth::guard('personnel')->user()->isRespAdministratif())

                <li class="nav-header">{{ __('msg.resp_admin_space') }}</li>

                <li {!! Route::currentRouteName() == 'panel.insurances.index' ? ' class="active"' : '' !!}>
                  <a href="{{route('panel.insurances.index')}}" class="nav-link">
                    <i class="fa fa-file-invoice"></i> 
                    <p>{{ __('msg.insurance') }}</p>
                  </a>
                </li>
            @endif
            @if(Auth::guard('personnel')->user()->admin())
              <li class="nav-header">{{ __('msg.admin_space') }}</li>

              <li{!! Route::currentRouteName() == 'panel.requests.admin' ? ' class="active"' : '' !!}>
                <a href="{{route('panel.requests.admin')}}" class="nav-link">
                  <i class="fa fa-shopping-cart"></i> 
                  <p>{{ __('msg.all_requests') }}</p>
                </a>
              </li>

              <li class="nav-item {{ Str::startsWith(Route::currentRouteName(), 'panel.staff') ? ' active' : '' }}">
                <a href="#" class="nav-link">
                  <i class="fa fa-users"></i> 
                  <p>{{ trans_choice('msg.staff', 2) }}
                    <i class="fa fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item" {!! Str::startsWith(Route::currentRouteName(), 'panel.staff.techniciens') ? ' class="active"' : '' !!}>
                    <a href="{{route('panel.staff.techniciens')}}" class="nav-link">
                      <p>{{ trans_choice('msg.technician', 2) }}</p>
                    </a>
                  </li>
                  <li class="nav-item" {!! Str::startsWith(Route::currentRouteName(), 'panel.staff.respadministratifs') ? ' class="active"' : '' !!}>
                    <a href="{{route('panel.staff.respadministratifs')}}" class="nav-link">
                      <p>{{ trans_choice('msg.admin_resp', 2) }}</p>
                    </a>
                  </li>
                  <li class="nav-item" {!! Str::startsWith(Route::currentRouteName(), 'panel.staff.respmateriels') ? ' class="active"' : '' !!}>
                    <a href="{{route('panel.staff.respmateriels')}}" class="nav-link">
                      <p>{{ trans_choice('msg.mat_resp', 2) }}</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item" {!! Route::currentRouteName() == 'panel.options.index' ? ' class="active"' : '' !!}>
                <a href="{{route('panel.options.index')}}" class="nav-link">
                  <i class="fas fa-cogs"></i> 
                  <p>{{ __('msg.options') }}</p>
                </a>
              </li>
            @endif
            
            
          </ul>
        </li>
        
      </ul>
    </nav>
  </div>

  <div class="sidebar-custom center">
		<a href="{{route('products.index')}}" class="btn btn-light hide-on-collapse text-center">Retour accueil</a>
	</div>
</aside>
