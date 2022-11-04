/////////////////////////////////////////
// Système de validation des différentes entrées du formulaire
/////////////////////////////////////////

$.validator.setDefaults({
    onkeyup: false,
    errorClass: "form-invalid",
    // En cas d'erreur pendant la vérification :
    errorPlacement: function(error, element) {
        let erreur = error.text();

        // Si l'erreur vient d'un required alors on affiche rien
        if (erreur.includes("required")){}

        // Pour les autres erreurs on affiche le message
        else{

            // Si l'élément vérifié à la classe "select2-original" alors on met en forme correctement le message d'erreur
            if(element.hasClass("select2-original")){
                element.nextAll("span.select2").after(error);
            }

            // Sinon, on affiche l'erreur normalement
            else{
                error.insertAfter(element);
            }
        }
    },
});

// Messages par défaut pour chacune des erreus validation.js
jQuery.extend(jQuery.validator.messages, {
    required: "",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

// Custom rule : Gestion de la validation des "tags" de select2
$.validator.addMethod("tags",function(value,element){
    let min = element.dataset.minTags;
    element = $(`[name='${element.name}']`);

    let nbTags = element.children().length;
    let select2 = element.nextAll("span.select2");

    // Si le nombre de tags présents est supéreur aux minimum de tags demandés, alors on enlève la classe "form-invalid" et on valide la vérification
    if(nbTags >= min){
        select2.removeClass("form-invalid");
        return true;
    }

    // Sinon, on ajoute la classe "form-invalid"
    else{
        select2.addClass("form-invalid");
        return false;
    }
});

    $(document).ready(function () {

    // Si y'a un changement dans un select alors on vérifie la validité de l'élément (utile pour select2)
    $("form").on("change", "select", function(e){
        $(this).valid();
    });

    // Initialisation de tous les champs ayant l'attribut "requiered" pour la vérification
    $("form *[required]").each(function(){
        $(this).rules("add", {
            required: true
        });
    });

    // Initialisation de tous les champs ayant l'attribut "minlength=XXX" pour la vérification
    $("form [minlength]").each(function(){
        $(this).rules("add", {
            minlength: $(this).attr("minlength")
        });
    });

    // Initialisation de tous les champs ayant l'attribut "data-min-tags=XXX" (select2) pour lé vérification
    // Cet attribut permet de définir le nombre de tags minimum demandé
    $("[data-min-tags]").each(function () {
        let min = $(this).data("min-tags");
        $(this).rules("add", {
            tags: min,
        });
    });

    /////////////////////////////////////////
    // Système de pagination (formulaire en plusieurs parties) + vérification page par page
    /////////////////////////////////////////

    // Page actuelle
    var currentPage = 0;

    // Nombre de pages (via la classe .form-part)
    var nbPages = $(".form-part").length;

    // Bouton suivant
    $(".btn-suivant").click(function(e){
        console.log("La page est bien renseignée : " + $("form").valid());

        // Si tous les champs obligatoires sont remplis
        if( $(`.form-part:eq(${currentPage}) input,
        .form-part:eq(${currentPage}) select,
        .form-part:eq(${currentPage}) textarea,
        .form-part:eq(${currentPage}) button,
        .form-part:eq(${currentPage}) fieldset,
        .form-part:eq(${currentPage}) legend,
        .form-part:eq(${currentPage}) datalist,
        .form-part:eq(${currentPage}) output,
        .form-part:eq(${currentPage}) option,
        .form-part:eq(${currentPage}) optgroup`).valid() ){

            console.log("hey");

            // Si la page actuelle n'est pas encore la dernière, alors :
            if (currentPage < nbPages - 1){
                // On incrémente le compteur et on affiche la page suivante
                currentPage++;
                $(".form-part").hide();
                $(`.form-part:eq(${currentPage})`).show();

            // Sinon, si il s'agit bien de la dernière page, on envoi le formulaire
            }else{
                $("form").submit();
                console.log("Vous avez atteint la dernière page, vous ne pouvez pas aller plus loin.")
            }

            // Si on est sur une autre page que la première, alors on affiche le bouton retour
            if(currentPage > 0){
                $(".btn-retour").show();
            }

        }
    });

    // Bouton retour (celui-ci est caché par défaut car on est logiquement directement sur la première page, donc pas de retour possible)
    $(".btn-retour").click(function(e){

        // Si on ne se trouve plus sur la première page :
        // On met à jour la variable compteur currentPage, on cache les pages et on affiche celle sur laquelle on est censé se trouver
        if(currentPage > 0){
            currentPage--;
            $(".form-part").hide();
            $(`.form-part:eq(${currentPage})`).show();
        }

        // Si on se trouve sur la première page, alors on cache le bouton retour
        if(currentPage == 0){
            $(".btn-retour").hide();
        }
    });

});
