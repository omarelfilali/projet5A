<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "Le champ doit être accepté.",
    "active_url"       => "Le champ n'est pas une URL valide.",
    "after"            => "Le champ doit être une date postérieure au :date.",
    "alpha"            => "Le champ doit seulement contenir des lettres.",
    "alpha_dash"       => "Le champ doit seulement contenir des lettres, des chiffres et des tirets.",
    "alpha_num"        => "Le champ doit seulement contenir des chiffres et des lettres.",
    "before"           => "Le champ doit être une date antérieure au :date.",
    "between"          => array(
        "numeric" => "La valeur de doit être comprise entre :min et :max.",
        "file"    => "Le fichier doit avoir une taille entre :min et :max kilobytes.",
        "string"  => "Le texte doit avoir entre :min et :max caractères.",
    ),
    "confirmed"        => "Le champ de confirmation ne correspond pas.",
    "date"             => "Le champ n'est pas une date valide.",
    "date_format"      => "Le champ ne correspond pas au format :format.",
    "different"        => "Les champs et :other doivent être différents.",
    "digits"           => "Le champ doit avoir :digits chiffres.",
    "digits_between"   => "Le champ doit avoir entre :min and :max chiffres.",
    "email"            => "Le format du champ est invalide.",
    "exists"           => "Le champ sélectionné est invalide.",
    "image"            => "Le champ doit être une image.",
    "in"               => "Le champ est invalide.",
    "integer"          => "Le champ doit être un entier.",
    "ip"               => "Le champ doit être une adresse IP valide.",
    "max"              => array(
        "numeric" => "La valeur de ne peut être supérieure à :max.",
        "file"    => "Le fichier ne peut être plus gros que :max kilobytes.",
        "string"  => "Le texte de ne peut contenir plus de :max caractères.",
    ),
    "mimes"            => "Le champ doit être un fichier de type : :values.",
    "min"              => array(
        "numeric" => "La valeur de doit être inférieure à :min.",
        "file"    => "Le fichier doit être plus que gros que :min kilobytes.",
        "string"  => "Le texte doit contenir au moins :min caractères.",
    ),
    "not_in"           => "Le champ sélectionné n'est pas valide.",
    "numeric"          => "Le champ doit contenir un nombre.",
    "regex"            => "Le format du champ est invalide.",
    "required"         => "Le champ est obligatoire.",
    "required_if"      => "Le champ est obligatoire quand la valeur de :other est :value.",
    "required_with"    => "Le champ est obligatoire quand :values est présent.",
    "required_without" => "Le champ est obligatoire quand :values n'est pas présent.",
    "same"             => "Les champs et :other doivent être identiques.",
    "size"             => array(
        "numeric" => "La taille de la valeur de doit être :size.",
        "file"    => "La taille du fichier de doit être de :size kilobytes.",
        "string"  => "Le texte de doit contenir :size caractères.",
    ),
    "unique"           => "La valeur du champ est déjà utilisée.",
    "url"              => "Le format de l'URL de n'est pas valide.",

    "category"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout de la catégorie",
            "success"   => "La catégorie a été ajoutée !",
        ),
        "updated"           => array(
            "error"     => array(
                "generic" => "Erreur lors de la mise à jour de la catégorie",
                "resp_materiel" => "La catégorie ne peut pas être visible tant qu'elle est associée à un responsable matériel",
            ),
            "success"   => "La catégorie a bien été modifiée !",
        ),
        "deleted"           => array(
            "error"     => array(
                "resp_materiel" => "Suppression impossible : la catégorie est liée à un responsable matériel",
                "product_type" => "Suppression impossible : des types de produits sont liés à la catégorie",
            ),
            "success"   => "La catégorie a bien été supprimée !",
        ),
        "name_unavailable" => "Une autre catégorie porte déjà ce nom",
    ),

    "type"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du type de produit",
            "success"   => "Le type de produit a été ajouté !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification du type de produit",
            "success"   => "Le type de produit a bien été modifié !",
        ),
        "deleted"           => array(
            "error"     => array(
                "product" => "Suppression impossible : le type de produit est lié à un produit",
            ),
            "success"   => "Le type de produit a bien été supprimé !",
        ),
        "name_unavailable" => "Un autre type de produit porte déjà ce nom",
    ),

    "filter"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout de la caractéristique",
            "success"   => "La caractéristique a été ajoutée !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification de la caractéristique",
            "success"   => "La caractéristique a bien été modifiée !",
        ),
        "deleted"           => array(
            "success"   => "La caractéristique a bien été supprimée",
        ),
        "name_unavailable" => "Une caractéristique du même nom est déjà associée au produit",
    ),

    "product"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du produit",
            "success"   => "Le produit a été ajouté !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification du produit",
            "success"   => "Le produit a bien été modifié !",
        ),
        "deleted"           => array(
            "error"     => array(
                "reference" => "Suppression impossible : des références sont liées au produit",
            ),
            "success"   => "Le produit a bien été supprimé !",
        ),
        "name_unavailable" => "Un autre produit porte déjà le même nom",
    ),

    "reference"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout de la référence",
            "success"   => "La référence a été ajoutée !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification de la référence",
            "success"   => "La référence a bien été modifiée !",
        ),
        "deleted"           => array(
            "error"     => array(
                "loan" => "Suppression impossible : des emprunts sont liés à la référence",
            ),
            "success"   => "La référence a bien été supprimée !",
        ),
        "serial_nb_unavailable" => "Une autre référence porte déjà le même numéro de série",
        "ensim_id_unavailable" => "Cet identifiant est déjà utilisé pour un autre matériel",
        "ensim_id_wrong_format" => "L'identifiant doit commencer par E-, ne contenir que des lettres et des chiffres et posséder entre 1 et 18 caractères",
    ),

    "technician"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du technicien",
            "success"   => "Le technicien a été ajouté !",
        ),
        "deleted"           => array(
            "error"   => "Erreur lors de la suppression du technicien",
            "success"   => "Le technicien a bien été supprimé !",
        ),
    ),

    "responsable"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du responsable",
            "success"   => "Le responsable a été modifié !",
        ),
    ),

    "admin_resp"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du responsable administratif",
            "success"   => "Le responsable administratif a été ajouté !",
        ),
        "deleted"           => array(
            "error"   => "Erreur lors de la suppression du responsable administratif",
            "success"   => "Le responsable administratif a bien été supprimé !",
        ),
    ),

    "mat_resp"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du responsable matériel",
            "success"   => "Le responsable matériel a été ajouté !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification du responsable matériel",
            "success"   => "Le responsable a bien été modifié !",
        ),
        "deleted"           => array(
            "error"     =>  "Erreur lors de la suppression du responsable matériel",
            "success"   => "Le responsable matériel a bien été supprimé !",
        ),
        "no_category_selected" => "Vous devez sélectionner au moins une catégorie",
    ),

    "options"                  => array (
        "updated"           => array(
            "error"     => "Erreur lors de la mise à jour des paramètres",
            "success"   => "Les paramètres ont été sauvegardés",
        ),
    ),

    "request"                  => array (
        "added"           => array(
            "error"     => "Erreur lors de la création de l'emprunt",
            "success"   => "L'emprunt a bien été créé !",
        ),
        "accepted"             => array(
            "supervisor"     => "Seul un encadrant peut accepter la demande",
            "technician"   => "Seul le technicien associé à l'emprunt peut accepter la demande",
            "admin_resp"     => "Seul un responsable administratif peut accepter la demande",
        ),
        "picked_up" => "Seul le technicien associé à l'emprunt peut démarrer un emprunt",
        "returned"              => array(
            "error"     => array(
                "bad_technician" => "Seul le technicien associé à l'emprunt marquer un emprunt comme retourné",
            ),
            "success" => "L'emprunt a bien été marqué comme rendu !"
        ),
        "refused"             => array(
            "supervisor"     => "Seul un encadrant peut refuser la demande",
            "technician"   => "Seul le technicien associé à l'emprunt peut refuser la demande",
            "admin_resp"     => "Seul un responsable administratif peut refuser la demande",
        ),
        "cancelled" => "Seul le technicien associé à l'emprunt peut annuler un emprunt",
        "past_date" => "La date saisie est déjà passée",
        "period"            => array(
            "updated"           => array(
                "error"     => "Erreur lors de la modification de la période",
                "success"   => "La période a bien été modifiée !",
            ),
            "past_date" => "La date de début saisie est déjà passée",
            "request_started" => "L'emprunt est commencé, la date de début n'est plus modifiable",
            "second_date_before" => "La deuxième date doit être après la première",
        ),
        "action"            => array(
            "error"     => "Erreur lors de la réalisation de l'action",
            "success"   => "L'action a bien été prise en compte !",
        ),
        "product_replacement"            => array(
            "error"     => "Erreur lors du remplacement du produit",
            "success"   => "Le produit a bien été remplacé !",
        ),
        "supervisor"            => array(
            "add"           => array(
                "error"     => "Erreur lors de l'ajout de l'encadrant",
                "success"   => "L'encadrant a bien été ajouté !",
            ),
            "remove"           => array(
                "error"     => array(
                    "generic"     => "Erreur lors de la suppression de l'encadrant",
                    "last_one"   => "Impossible de supprimer le dernier encadrant !",
                ),
                "success"   => "L'encadrant a bien été supprimé !",
            ),
        ),
        "technician_change"            => array(
            "error"     => "Erreur lors du changement de technicien",
            "success"   => "Le technicien a bien été changé !",
        ),
    ),

    "not_found"     => array(
        "category" => "La catégorie n'existe pas",
        "technician" => "Le technicien n'existe pas",
        "type" => "Le type de produit n'existe pas",
        "serial_nb" => "Le numéro de série n'existe pas",
        "staff" => "Le personnel n'existe pas",
        "product" => "Le produit n'existe pas",
        "student" => "L'étudiant n'existe pas",
        "action" => "Action inconnue",
    ),

    "cart"     => array(
        "add_product"     => array(
            "error"     => "Erreur lors de l'ajout du produit au panier",
            "success"   => "Le produit a bien été ajouté au panier !",
        ),
        "remove_product"     => array(
            "error"     => "Erreur lors de la suppression du produit",
            "success"   => "Le produit a bien été retiré du panier !",
        ),
        "edit_product_quantity"     => array(
            "error"     => "Erreur lors de la mise à jour de la quantité",
            "success"   => "La quantité du produit a bien été mise à jour !",
        ),
    ),

    "projet"                  => array (
        "added"             => array(
            "error"     => "Erreur lors de l'ajout du projet",
            "success"   => "Le projet a été ajouté !",
        ),
        "updated"           => array(
            "error"     => "Erreur lors de la modification du projet",
            "success"   => "Le projet a bien été modifié !",
        ),
        "deleted"           => array(
            "error"     => array(
                "reference" => "La suppression a échoué",
            ),
            "success"   => "Le projet a bien été supprimé !",
        ),
        "name_unavailable" => "Un autre projet porte déjà le même nom",
    ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(),

);
