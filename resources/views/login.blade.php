<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
        <title>myENSIM</title>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.ui.min.js"></script>
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>

<body id="login-page">
    <div id="login-background"></div>
    <div id="register-background"></div>
    <main>
        <div id="login-fenetre">
            
                <div class="logo">
                    <img src="http://e-www3-t1.univ-lemans.fr/ressources/logos/myensim.png">
                </div>

                {{-- Profils de connexion des utilisateurs --}}
                <div id="login-profils">
                    <div data-pos="1"></div>
                    <div data-pos="2" class="active"></div>
                    <div data-pos="3"></div>
                </div>

                {{-- Lien qui permet d'intervertir entre formulaires de connexion / inscription (géré via le script js login.js) --}}
                <div id="authSwitch">
                    <p class="m-0">Ou : <span>Je souhaite m'inscrire</span></p>
                </div>

            {{-- Classe gérant plusieurs formulaires pouvant s'afficher les uns à la suite des autres  --}}
            <div class="multiple-forms">
                <div class="form-container" id="formExterieurs">
                    <h3>Extérieurs & Alumni</h3>
                    <form method="POST" action="{{route('login.ensim')}}">
                        @csrf
                        <input type="hidden" name="logType" value="exterieur">
                        <div class="col-12">
                            <label for="identifiant" class="form-label">Adresse mail :</label>
                            <input required type="text" class="form-control" id="identifiant" name="identifiant">
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input required type="password" class="form-control" id="password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>

                <div class="form-container active" id="formEnsim">
                <h3>Étudiants & Personnel</h3>
                    <a href="{{route('login.cas')}}">Utiliser le CAS</a>

                    <form method="POST" action="{{route('login.ensim')}}">
                        @csrf
                        <div class="col-12">
                            <label for="identifiant" class="form-label">Login :</label>
                            <input required type="text" class="form-control" id="identifiant" name="id">
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input required type="password" class="form-control" id="password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>

                <div class="form-container" id="formCandidats">
                <h3>Candidats</h3>
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="logType" value="candidat">
                        <div class="col-12">
                            <label for="identifiant" class="form-label">Adresse mail :</label>
                            <input required type="text" class="form-control" id="identifiant" name="identifiant">
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Mot de passe :</label>
                            <input required type="password" class="form-control" id="password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>

                <div class="form-container" id="formInscription">
                    
                        <form method="POST" action="">
                            @csrf

                            <div id="typeInscription">
                        
                                <h3>Inscription : </h3>
        
                                <div class="text-center">
                                    <label for="inscriptionType">M'inscrire en tant que </label>
                                    <select required type="text" name="inscriptionType">
                                        <option value="Candidat">Candidat</option>
                                        <option value="Exterieur">Extérieur</option>
                                    </select>
                                </div>
        
                            </div>

                                <div class="row">
                                    <div class="col p-0 me-2">
                                    <label for="prenom" class="form-label">Prénom :</label>
                                      <input type="text" class="form-control" name="prenom" required aria-label="prénom">
                                    </div>
                                    <div class="col p-0 ms-2">
                                    <label for="nom" class="form-label">Nom :</label>
                                      <input type="text" class="form-control" name="nom" required aria-label="nom">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="mail" class="form-label">Adresse mail :</label>
                                    <input required type="email" class="form-control" id="mail" name="mail">
                                </div>

                                <div class="col-12">
                                    <label for="password" class="form-label">Mot de passe :</label>
                                    <input required type="password" class="form-control" id="password" name="password">
                                </div>

                            <button type="submit" class="btn btn-primary mb-3">S'inscrire</button>
                        </form>
                    </div>
            </div>
            <div class="footer"><p class="m-0">Mentions légales</p></div>
</div>
    </main>
    <script type="module">
        // Variable flag pour savoir si on est en formulaire d'inscription ou non (0 = non | par défaut)
let inscription = 0;

// Lorsqu'on clique sur un des profils Utilisateurs
$("#login-profils>div").click(function(){

    // Si le profil sur lequel on clique n'est pas déjà celui affiché
    if ($(this).hasClass("active") != true){

        // Alors on efface la classe "active" qui permet de montrer que le profil cliqué est celui sélectionné (les non "active" ont une opacité réduite et sont plus petits)
        $("#login-profils>div").removeClass("active");
        // Puis on met notre profil actual en "selectionné"
        $(this).addClass("active");

        // Si on clique le premier profil
        if($(this).data("pos") == 1){
            // Alors on efface la classe "active" qui permet d'afficher le formulaire à tous les formulaires de connexion
            $(".multiple-forms .form-container").removeClass("active");
            // Puis on met notre formulaire correspondant au profil cliqué en "actif"
            $("#formExterieurs").addClass("active");
        }
    
        // Si on clique le second profil...
        if($(this).data("pos") == 2){
            $(".multiple-forms .form-container").removeClass("active");
            $("#formEnsim").addClass("active");
        }
    
        if($(this).data("pos") == 3){
            $(".multiple-forms .form-container").removeClass("active");
            $("#formCandidats").addClass("active");
        } 
    }
});

// Si on clique sur le lien pour accéder au formulaire d'inscription / ou inversement de connexion
$("#authSwitch span").click(function(){

    // Si les formulaires de connexion sont affichés alors :
    if (inscription == 0){
        // Le formulaire de connexion actuel va disparaître progressivement
        $(".multiple-forms .active").velocity("fadeOut", {delay: 0, duration: 10}).velocity({display: "none"});
        // Le formulaire d'inscription va apparaître progressivement
        $("#formInscription").velocity({display: "inherit"}).velocity("fadeIn", {delay: 300, duration: 400});
        // On adapte la phrase de "switch" pour retourner aux formulaires de connexion
        $("#authSwitch span").text("Je souhaite me connecter");
        // On signale qu'on est désormais sur le formulaire d'inscription
        inscription++;

    // Effet inverse de la condition décrite précedemment
    }else{
        $("#formInscription").velocity("fadeOut", {delay: 0, duration: 10}).velocity({display: "none"});
        $(".multiple-forms .active").velocity({display: "inherit"}).velocity("fadeIn", {delay: 300, duration: 400});
        $("#authSwitch span").text("Je souhaite m'inscrire");
        inscription--;
    }

    // On active/désactive la classe "register" à notre élément afin que la fenêtre avec les formulaires se déplace vers la gauche de l'écran    
    $("#login-fenetre").toggleClass("register");
    // On active/désactive la classe "disabled" à notre élément afin que l'opacité du premier fond d'écran disparaisse ou réaparaisse
    $("#login-background").toggleClass("disabled");
    // On active la bannière de sélection de type de profil
    $("#login-profils").slideToggle(600);
});
    </script> 
</body>

</html>
