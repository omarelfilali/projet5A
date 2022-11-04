<header class="main-header">
	<a href="{{route('products.index')}}" class="logo">
	  <span class="logo-mini"></span>
	  <span class="logo-lg"><b>{{ __('msg.myEnsim') }}</b> - {{ __('msg.material') }}</span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
	  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">N</span>
	  </a>
	  <div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
		  <li class="dropdown user user-menu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  <img style="object-fit: cover" src="{{ Auth::guard('personnel')->user()->photoURL }}" class="user-image">
			  <span class="hidden-xs">{{ Auth::guard('personnel')->user()->nomprenom }}</span>
			</a>
			<ul class="dropdown-menu">
			  <li class="user-header" style="height:auto">
				<img style="object-fit: cover" src="{{ Auth::guard('personnel')->user()->photoURL }}" class="img-circle">
				<p>
				  {{ Auth::guard('personnel')->user()->nomprenom }}
				  @if (Auth::guard('personnel')->user()->statuts->count() == 0)
					  	<small>{{ trans_choice('msg.staff', 1) }}</small>
				  @else
					  @foreach (Auth::guard('personnel')->user()->statuts as $s)
					  	<small>{{ $s->type->nom }}</small>
					  @endforeach
				  @endif
				  <small></small>
				</p>
			  </li>
			  <li class="user-footer">
				<div class="pull-right">
				  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">{{ __('msg.logout')}}</a>
				</div>
			  </li>
			</ul>
		  </li>
		</ul>
	  </div>
	</nav>
</header>
