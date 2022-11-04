$(document).ready(function () {

    /////////////////////////////////////////
    // Cette partie ci-dessous concerne la selection et l'ajout des encadrants d'un projet
    /////////////////////////////////////////

    var nbAjoutEncadrant = 1;

    // Encadrant interne par défaut pour le select .type-encadrant
    // $(".box-encadrants .type-encadrant").val("interne");

    // Permet d'ajouter le bloc html template défini dans le php lors de l'appui sur le +
    $(".bouton-ajout-encadrant").click(function(e){
        nbAjoutEncadrant++;
        let newEncadrant = $("#new-encadrant").html().replaceAll('§', nbAjoutEncadrant);
        $(".ajouter-encadrant").before(newEncadrant);
    });

    // Permet de supprimer un bloc d'assignation de nouvel encadrant (en cliquant sur la petite croix)
    $(".box-encadrants").on("click", ".bouton-supp-encadrant", function(e){
        $(this).closest(".encadrant-bloc").remove();
    });

    // Si le .type-encadrant (select) change alors on fait apparaître / disparaître certains inputs
    // On utilise .on("change"...) au lieu de .click(function()...) car cela permet
    // aux éléments ajoutés dynamiquement en javascript de bénéficier de l'écoute des évènements
    $(".box-encadrants").on("change", ".type-encadrant", function(e) {
        let type = $(this).find(":selected").data("type");
        let clickedBloc = $(this).closest(".encadrant-bloc");

        let formInterne = clickedBloc.find(".encadrant-interne");
        let formExterieur = clickedBloc.find(".encadrant-exterieur");

        // Si interne alors on cache et on désactive les réponses du formulaire extérieur
        if (type.includes("interne")){
            formInterne.find('*').prop("disabled", false);
            formInterne.show();

            formExterieur.find('*').prop("disabled", true);
            formExterieur.hide();

        // Inversement de la procédure du dessus
        }else{
            formExterieur.find('*').prop("disabled", false);
            formExterieur.show();

            formInterne.find('*').prop("disabled", true);
            formInterne.hide();
        }
    });

    // Création d'un nouvel extérieur si il n'existe pas
    $(".box-encadrants").on("click", ".create-new-exterieur", function(e){
        // On met en variable le bloc auquel appartient l'élément sur lequel on a cliqué (imporant pour la suite)
        let clickedBloc = $(this).closest(".encadrant-bloc");

        // On met également en variable le select qui est juste après (correspond au select de l'utilisateur)
        let selectEncadrant = clickedBloc.find(".selection-encadrant");

        // On lance la fenêtre sweetalert2 permettant de renseigner les infos d'un nouvel extérieur
        Swal.fire({
            // On utilise le <template id="new-exterieur"> (html) pour pouvoir mettre en forme un formulaire à plusieurs inputs comme on le souhaite
            template: '#new-exterieur',
            focusConfirm: false,
            // preConfirm est une fonction qui s'éxecute une fois le bouton Confirmer appuyé.
            // On utilise preConfirm dans le cas où on utilise un template html personnalisé, ce qui est notre cas
            preConfirm: () => {
                let data = [];

                // On met en array toutes les données récupérées via les inputs de notre fenetre sweetalert2
                $("#create-new-ext input").each(function (index, element) {
                    data[index] = element.value;
                });

                // On clone le <template id="new-user-data"> (html)  test_creation en remplaçant les variables suivantes par les valeurs récupérées via sweetalert2
                let newUserData = $("#new-user-data").html().replaceAll('§', clickedBloc.data("id")).replace('%prenom%', data[0]).replace('%nom%', data[1]).replace('%mail%', data[2]);

                // On efface au cas où les données d'un nouvel extérieur créé (pour éviter des conflits de données si l'utilisateur essaye de créer 2 fois un nouvel extérieur dans le même bloc)
                clickedBloc.find(".new-exterieur-created").remove();

                // On append nos données du nouvel utilisateur à l'intérieur du bloc dans lequel on a souhaité créer le nouvel extérieur (les inputs de données sont en hidden)
                clickedBloc.append(newUserData);

                // Puis on ajoute l'option dans le select utilisateur (en hidden et sélectionné par défaut)
                selectEncadrant.append(`<option selected=selected hidden value="new">${data[0] + ' ' + data[1]}</option>`)
            }
            });
    });

    // Si un des inputs change alors on annule la création d'un nouvel extérieur
    $(".box-encadrants").on("change", ".encadrant-bloc select", function(e){
        let clickedBloc = $(this).closest(".encadrant-bloc");
        clickedBloc.find(".new-exterieur-created").remove();
        if($(this).hasClass("type-encadrant")){
            clickedBloc.find(".selection-encadrant").prop('selectedIndex',0);
        }
    });

    /////////////////////////////////////////
    // Cette partie ci-dessous concerne les spécialités
    /////////////////////////////////////////

    // On décoche par défaut toutes les filières et options
    $(".filiere input:radio").prop('checked', false);
    $(".option input:checkbox").prop('checked', false);

    // Lors d'un clic sur une filière
    $(".filiere input:radio").click(function(e){

        // On cache et on décoche les options
        $(".option").hide();
        $(".option input:checkbox").prop('checked', false);

        // Puis, en fonction de la filière cliquée, on va afficher et cocher par défaut les différentes options correspondantes
        if ($(this).val() == "Transversal"){
            $(".option").css('display', 'flex');
            $(".option input:checkbox").prop('checked', true);
        }else{
            $(`.option[data-filiere='${$(this).val()}']`).css('display', 'flex');
            $(`.option[data-filiere='${$(this).val()}'] input:checkbox`).prop('checked', true);
        }
    });

    /////////////////////////////////////////
    // Cette partie ci-dessous concerne les mots-clés
    /////////////////////////////////////////



    /////////////////////////////////////////
    // Cette partie ci-dessous concerne les boutons toggles (prioritaire, retribution..)
    /////////////////////////////////////////

    $("input[name='achat']").click(function(){
        if($(this).is(':checked')){
            $(".budget_box").show();
        }else{
            $(".budget_box").hide();
        }
    });

    // J'aime pas trop cette méthode

    // function loaded(selector, callback) {
    //     //trigger after page load.
    //     jQuery(function () {
    //         callback(jQuery(selector));
    //     });
    //     var parentSelector = "* > " + selector;
    //     //trigger after page update eg ajax event or jquery insert.
    //     jQuery(document).on('DOMNodeInserted', parentSelector, function (e) {
    //         callback(jQuery(this).find(selector));
    //     });
    // }

    // loaded("form", function(){
    //     $("select[name^='encadrants']").filter('select[name$="[id]"]').each(function(){
    //         $(this).rules("add", {
    //             required: true,
    //         });
    //     });
    // })

});
