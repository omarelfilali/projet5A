<header>
	<nav>
		<i class="fas fa-bars" id="navBurger"></i>
		<a href="http://e-www3-t1.univ-lemans.fr"><img class="logo" src="http://e-www3-t1.univ-lemans.fr/ressources/logos/myensim.png" alt="logo-myENSIM"></a>

		<div class="notif-materiels">
		@can("materiel.acces.personnel")
			<a href="{{ route('administration.materiel.requests.index') }}" class="mobile-only" style="position: absolute; right: 10px; top: 13px; font-size: 24px; color: white;">
				<i class="fas fa-user-cog"></i>
				<span class='badge' id='lblRequestsCount'> 
					{{-- {{ $demandes_attente }}  --}}
				</span>
			</a>
		@endcan
		</div>
		<div class="espace_user">
			<div id="connexion">
				<p>{{Auth::user()->nomprenom }}</p>
				<div id="ssMenuConnexion">
					<ul>
						{{-- @if(Auth::guard('etudiant')->check()) --}}
						@if(Auth::user()->role == 4)
							<li><a href="http://e-www3-t1.univ-lemans.fr/ensim-etudiants_fiche.html?id={{Auth::user()->id}}"><i class="fas fa-user"></i> Mon compte</a></li>
						{{-- @elseif(Auth::guard('personnel')->check()) --}}
						@elseif(Auth::user()->role == 3)
							<li><a href="http://e-www3-t1.univ-lemans.fr/ensim-personnels_edit.html?id_perso={{Auth::user()->id}}"><i class="fas fa-user"></i> Mon compte</a></li>
						@endif
						<li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Me déconnecter</a></li>
					</ul>
				</div>
				<div id="profilIndex">
					@if(Auth::user()->role == 4)
						<img onclick="window.open('http://e-www3-t1.univ-lemans.fr/ensim-etudiants_fiche.html?id={{Auth::user()->id}}', '_self')" src="{{"http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/" . Auth::user()->photo }}">
					@elseif(Auth::user()->role == 3)
						<img onclick="window.open('http://e-www3-t1.univ-lemans.fr/ensim-personnels_edit.html?id_perso={{Auth::user()->id}}', '_self')" src="{{ asset('http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/' . Auth::user()->photo) }}">
					@endif
				</div>
			</div>
		</div>
	</nav>
</header>
<div id="menuBurger">
	<div id="liensBurger">
		<div class="flex flexcol flexaligncenter">
			<div id="profilIndex">
				@if(Auth::user()->role == 4)
					<img onclick="window.open('http://e-www3-t1.univ-lemans.fr/ensim-etudiants_fiche.html?id={{Auth::user()->id}}', '_self')" src="{{"http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/" . Auth::user()->photo }}">
				@elseif(Auth::user()->role == 3)
					<img onclick="window.open('http://e-www3-t1.univ-lemans.fr/ensim-personnels_edit.html?id_perso={{Auth::user()->id}}', '_self')" src="{{ asset('http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/' . Auth::user()->photo) }}">
				@endif
			</div>
			<h4>{{ Auth::user()->nomprenom }}</h4>
			<hr style="height:2px; background: white; width:50%; margin: 0px 0 20px 0;">
		</div>
		<ul>
			@if(Auth::user()->role == 4)
				<li><a href="http://e-www3-t1.univ-lemans.fr/ensim-etudiants_fiche.html?id={{Auth::user()->id}}"><i class="fas fa-user"></i> Mon compte</a></li>
			@elseif(Auth::user()->role == 3)
				<li><a href="http://e-www3-t1.univ-lemans.fr/ensim-personnels_edit.html?id_perso={{Auth::user()->id}}"><i class="fas fa-user"></i> Mon compte</a></li>
			@endif
			<li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Me déconnecter</a></li>
		</ul>
	</div>
</div>
