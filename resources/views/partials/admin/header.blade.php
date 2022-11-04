<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar profil -->
    <ul class="navbar-nav ml-auto">

		<li class="nav-item dropdown user-menu">
			<a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="{{ asset('http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/' . Auth::user()->photo) }}" class="user-image img-circle elevation-2" style="object-fit: cover" alt="User Image">
				<span class="d-none d-md-inline">
					{{ Auth::user()->nomprenom }}
				</span>
			</a>
  
			<ul class="dropdown-menu-end dropdown-menu " aria-labelledby="dropdownMenuButton1">
				<!-- User image -->
				<li class="user-header bg-primary">
					<img src="{{ asset('http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/' . Auth::user()->photo) }}" class="img-circle elevation-2" style="object-fit: cover" alt="User Image">
	
					<p>
						{{ Auth::user()->nomprenom }} - Web Developer
						<small>Member since Nov. 2012</small>
					</p>
				</li>
				<!-- Menu Body -->
				{{-- <li class="user-body">
					<div class="row">
						<div class="col-4 text-center">
							<a href="#">Blabla 1</a>
						</div>
						<div class="col-4 text-center">
							<a href="#">Blabla 2</a>
						</div>
						<div class="col-4 text-center">
							<a href="#">Blabla 3</a>
						</div>
					</div>
				</li> --}}
				<!-- Menu Footer-->
				<li class="user-footer">
					<a href="http://e-www3-t1.univ-lemans.fr/ensim-personnels_edit.html?id_perso={{Auth::user()->id}}" class="btn btn-default btn-flat">Profil</a>
					<a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right">Déconnexion</a>
				</li>
		  </ul>
		</li>
    </ul>
  </nav>
  <!-- /.navbar -->