const {
    createPopper,
    eventListeners
} = require("@popperjs/core");
const {
    file
} = require("jszip");
const {
    add,
    delay
} = require("lodash");

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
        $clickedBloc = $(this).closest(".encadrant-bloc");

        $formInterne = $clickedBloc.find(".encadrant-interne");
        $formExterieur = $clickedBloc.find(".encadrant-exterieur");

        // Si interne alors on cache et on désactive les réponses du formulaire extérieur
        if (type.includes("interne")){
            $formInterne.find('*').prop("disabled", false);
            $formInterne.show();

            $formExterieur.find('*').prop("disabled", true);
            $formExterieur.hide();

        // Inversement de la procédure du dessus
        }else{
            $formExterieur.find('*').prop("disabled", false);
            $formExterieur.show();

            $formInterne.find('*').prop("disabled", true);
            $formInterne.hide();
        }
    });

    // JSP C QUOI
    $('.addNewStudents').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
            'style'
    });

    // Création d'un nouvel extérieur si il n'existe pas
    $(".box-encadrants").on("click", ".create-new-exterieur", function(e){
        // On met en variable le bloc auquel appartient l'élément sur lequel on a cliqué (imporant pour la suite)
        $clickedBloc = $(this).closest(".encadrant-bloc");

        // On met également en variable le select qui est juste après (correspond au select de l'utilisateur)
        $selectEncadrant = $clickedBloc.find(".selection-encadrant");

        // On lance la fenêtre sweetalert2 permettant de renseigner les infos d'un nouvel extérieur
        Swal.fire({
            // On utilise le <template id="new-exterieur"> (html) pour pouvoir mettre en forme un formulaire à plusieurs inputs comme on le souhaite
            template: '#new-exterieur',
            focusConfirm: false,
            // preConfirm est une fonction qui s'éxecute une fois le bouton Confirmer appuyé.
            // On utilise preConfirm dans le cas où on utilise un template html personnalisé, ce qui est notre cas
            preConfirm: () => {
                data = [];

                // On met en array toutes les données récupérées via les inputs de notre fenetre sweetalert2
                $("#create-new-ext input").each(function (index, element) {
                    data[index] = element.value;
                });

                // On clone le <template id="new-user-data"> (html)  test_creation en remplaçant les variables suivantes par les valeurs récupérées via sweetalert2
                let newUserData = $("#new-user-data").html().replaceAll('§', $clickedBloc.data("id")).replace('%prenom%', data[0]).replace('%nom%', data[1]).replace('%mail%', data[2]);

                // On efface au cas où les données d'un nouvel extérieur créé (pour éviter des conflits de données si l'utilisateur essaye de créer 2 fois un nouvel extérieur dans le même bloc)
                $clickedBloc.find(".new-exterieur-created").remove();

                // On append nos données du nouvel utilisateur à l'intérieur du bloc dans lequel on a souhaité créer le nouvel extérieur (les inputs de données sont en hidden)
                $clickedBloc.append(newUserData);

                // Puis on ajoute l'option dans le select utilisateur (en hidden et sélectionné par défaut)
                $selectEncadrant.append(`<option selected=selected hidden value="new">${data[0] + ' ' + data[1]}</option>`)
            }
            });
    });

    // Si un des inputs change alors on annule la création d'un nouvel extérieur
    $(".box-encadrants").on("change", ".encadrant-bloc select", function(e){
        $clickedBloc = $(this).closest(".encadrant-bloc");
        $clickedBloc.find(".new-exterieur-created").remove();
        if($(this).hasClass("type-encadrant")){
            $clickedBloc.find(".selection-encadrant").prop('selectedIndex',0);
        }
    });

    /////////////////////////////////////////
    // Cette partie ci-dessous concerne les spécialités
    /////////////////////////////////////////

    $(".filiere input:radio").prop('checked', false);
    $(".option input:checkbox").prop('checked', false);

    $(".filiere input:radio").click(function(e){
        $(".option").hide();
        $(".option input:checkbox").prop('checked', false);
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

    $(".input-mots-cles").select2({
        theme: "bootstrap-5",
        tags: true,
        maximumSelectionLength: 5,
        createTag: function (params) {
            var term = $.trim(params.term);
            console.log(term.length);

            if (term === '' || term.length < 3) {
              return null;
            }

            return {
              id: term,
              text: term,
              newTag: true // add additional parameters
            }
          }
    });


    /////////////////////////////////////////
    // Cette partie ci-dessous concerne les boutons toggles (prioritaire, retribution..)
    /////////////////////////////////////////

});

document.addEventListener('DOMContentLoaded', (e) => {

    if (document.querySelector('.content_ajout_proj')) {

        let btn_suivant = document.querySelector('.btn_suivant_ajout');
        let btn_encadrant = document.querySelector('.bouton_ajout_encadrant');
        let btn_motcle;
        let valid_motcle = document.querySelector('.valid_motcle');

        //! CONSTANTES
        const longneurMin = 4;
        const longeurResum = 30;
        const longeurEmail = 7
        const ext_images = ['png', 'jpg', 'jpeg', 'gif'];
        const ext_documents = ['pdf'];

        //? PARTIES PAGE
        let part1_ajout = document.querySelector('.part1_ajout');
        let part2_ajout = document.querySelector('.part2_ajout');

        //? DESCRIPTION
        let nomProj = document.getElementById('inputName');
        let resumeProj = document.getElementById('inputDescription');
        let motcleProj = document.getElementById('inputKeywords');
        let imgProj = document.getElementById('inputImage');

        list_keyword = document.querySelector('.list_keyword');

        //? REMARQUE
        let inputPorteurNom = document.getElementById('inputPorteurNom');
        let porteur_nom_ext = document.getElementById('porteur_nom_ext');
        let inputPorteurEmail = document.getElementById('porteur_email_ext');

        //? EQUIPE ETUDIANTS VISEE

        let anneproj = document.getElementById('anneeproj')
        let selectEtu = document.getElementById('selectNbEtudiants');
        let radioElement = document.querySelectorAll('.specialite');
        let inputSpecialite = document.querySelectorAll('.inputSpecialite');
        let inputNewStudent = document.querySelector('.addNewStudents');

        //? BOUTON OUI / NON

        let btn_toggle = document.querySelectorAll('.tgl-skewed');


        let cadrageInput = document.getElementById('cadrageInput');
        let select_type = document.querySelector('.select_type');

        //? UPLOAD INPUT

        let inputImage = document.getElementById('inputImage');
        let inputDiapo = document.getElementById('diapoRessource');

        //? LISTE INPUT

        // let textInput = [nomProj, resumeProj, motcleProj];
        // let RadioInput = [radioElement];
        let selectInput = [anneeproj, inputPorteurNom];
        let uploadInput = [inputImage, inputDiapo];

        eventInput();



        // email affiché si le role est partenaire

        // let inputPorteur = document.getElementById('inputPorteur');
        // let bloc_ext = document.querySelector('.content_ext');
        // bloc_ext.style.display = 'none';
        // inputPorteurNom.addEventListener('change', (e) => {
        //     if (e.target.value === e.target.firstChild.textContent) {
        //         console.log('coucou');
        //     }
        // })

        // inputPorteur.addEventListener('change', (e) => {
        //     if (e.target.value == 'encadrant') {

        //         inputPorteurNom.parentNode.style.display = "block";
        //         bloc_ext.style.display = 'none';
        //         let emailRemId;
        //         let nomRemId;
        //         textInput.forEach(element => {
        //             if (element === inputPorteurEmail) {
        //                 emailRemId = textInput.indexOf(element);
        //             }
        //             if (element === porteur_nom_ext) {
        //                 nomRemId = textInput.indexOf(element);
        //             }
        //         });
        //         if (emailRemId || nomRemId) {
        //             textInput.splice(emailRemId, emailRemId);
        //             textInput.splice(nomRemId, nomRemId);
        //         }
        //         if (!selectInput.includes(inputPorteurNom)) {
        //             selectInput.push(inputPorteurNom);
        //             eventInput();
        //         }
        //     } else {
        //         let nomRemIdExt;
        //         selectInput.forEach(element => {
        //             if (element === inputPorteurNom) {
        //                 nomRemIdExt = selectInput.indexOf(element);
        //             }
        //         });
        //         if (nomRemIdExt) {
        //             selectInput.splice(nomRemIdExt, nomRemIdExt);
        //         }
        //         bloc_ext.style.display = 'block';
        //         inputPorteurNom.parentNode.style.display = "none";
        //         textInput.push(inputPorteurEmail);
        //         textInput.push(porteur_nom_ext);
        //         eventInput();
        //     }
        // });

        // btn_encadrant.addEventListener('click', (e) => {
        //     let btn_fermer = document.querySelector('.supp_content');
        //     btn_fermer.insertAdjacentHTML('beforeend', '<div class="card-body bg-light rounded encadrant_unite mt-3"><div class="form-group"><div class="btn float-right d-flex fermer_porteur"><i class="fas fa-xmark"></i></div><label for="inputPorteur">Porteur du projet</label><p>Rôle</p><select name="porteur" id="inputPorteur" class="form-control"><option value="encadrant">Encadrants</option><option value="partenaire">Partenaire industriel / extérieur</option></select></div><div class="form-group nom_encadrant"><p>Nom</p><select id="inputPorteurNom" class="form-control"></select></div><div class="content_ext"><div class="form-group nom_bloc_partenaire"><p>Nom</p><input type="text" id="inputPorteurNom" class="form-control porteurNom"></div><div class="form-group email_bloc_partenaire"><p>Email</p><input type="email" id="inputPorteurEmail" class="form-control porteurEmail"></div></div></div>')
        //     document.querySelectorAll('.fermer_porteur').forEach(fermer_porteur => {
        //         fermer_porteur.addEventListener('click', (e) => {
        //             let text = e.currentTarget.parentElement.parentElement.lastChild;
        //             let select = e.currentTarget.parentElement.parentElement.children[1];
        //             if (text.style.display === "none") {
        //                 for (let index = 0; index < select.children.length; index++) {
        //                     const element = select.children[index];
        //                     if (element.name === 'nom') {
        //                         selectInput.splice(selectInput.indexOf(element), selectInput.indexOf(element));
        //                         eventInput();
        //                     }
        //                 }
        //             } else {
        //                 for (let index = 0; index < text.children.length; index++) {
        //                     const element = text.children[index];
        //                     textInput.splice(textInput.indexOf(element.children[1]), textInput.indexOf(element.children[1]));
        //                     eventInput();
        //                 }
        //             }
        //             fermer_porteur.parentElement.parentElement.remove();
        //             eventInput();
        //         });
        //     });

        //     let content_nom_ext = JSON.parse(btn_fermer.dataset.encadrant);

        //     for (let index = 0; index < btn_fermer.children.length; index++) {
        //         let current_bloc = btn_fermer.children[index];
        //         if (!selectInput.includes(current_bloc.children[1].lastChild)) {
        //             selectInput.push(current_bloc.children[1].lastChild);
        //         }
        //         btn_fermer.children[index].children[1].lastChild.name = "nom_" + index;
        //         btn_fermer.children[index].lastChild.firstChild.lastChild.name = "nom_ext_" + index;
        //         btn_fermer.children[index].lastChild.lastChild.lastChild.name = "email_ext_" + index;
        //         eventInput();

        //         if (current_bloc.nextElementSibling === null) {
        //             current_bloc.lastChild.style.display = "none";

        //             current_bloc.children[1].lastChild.insertAdjacentHTML('afterbegin', '<option></option>');
        //             content_nom_ext.forEach(test => {
        //                 current_bloc.children[1].lastChild.insertAdjacentHTML('beforeend', '<option value="' + test.id + '">' + test.nom + ' ' + test.prenom + '</option>')
        //             })
        //             current_bloc.firstChild.lastChild.addEventListener('change', (e) => {
        //                 if (e.target.value == 'encadrant') {
        //                     current_bloc.lastChild.style.display = "none";
        //                     e.target.parentElement.nextElementSibling.style.display = "block";
        //                     let emailRemId;
        //                     let nomRemId;
        //                     // current_bloc.lastChild.childNodes.forEach(bloc =>{

        //                     // })
        //                     textInput.forEach(input => {
        //                         if (input === current_bloc.lastChild.children[0].children[1]) {
        //                             emailRemId = textInput.indexOf(input);
        //                         }
        //                         if (input === current_bloc.lastChild.children[1].children[1]) {
        //                             nomRemId = textInput.indexOf(input);
        //                         }
        //                     })
        //                     if (emailRemId && nomRemId) {
        //                         textInput.splice(emailRemId, emailRemId);
        //                         textInput.splice(nomRemId, nomRemId);
        //                     }
        //                     if (!selectInput.includes(current_bloc.children[1].lastChild)) {
        //                         selectInput.push(current_bloc.children[1].lastChild);
        //                     }
        //                     eventInput();
        //                 } else {
        //                     current_bloc.lastChild.style.display = 'block';
        //                     e.target.parentElement.nextElementSibling.style.display = "none";
        //                     let selectEncRem;
        //                     selectInput.forEach(select => {
        //                         if (e.target.parentElement.nextElementSibling.children[1] === select) {
        //                             selectEncRem = selectInput.indexOf(select);
        //                         }
        //                     })
        //                     if (selectEncRem) {
        //                         selectInput.splice(selectEncRem, selectEncRem);
        //                     }
        //                     console.log(current_bloc.lastChild);
        //                     if (!textInput.includes(current_bloc.lastChild.firstChild.children[1]) && !textInput.includes(current_bloc.lastChild.lastChild.children[1])) {
        //                         textInput.push(current_bloc.lastChild.firstChild.children[1]);
        //                         textInput.push(current_bloc.lastChild.lastChild.children[1]);
        //                     }
        //                     eventInput();
        //                 }
        //             })
        //         }
        //     }
        // });

        function eventInput() {
            // btn_toggle.forEach(element => {
            //     element.value = "non";
            //     element.addEventListener('click', () => {
            //         if (element.value === "oui") {
            //             element.value = "non";
            //             if (element.id === "achat") {
            //                 document.querySelector('.budget_box').style.display = "none";
            //             }
            //         } else {
            //             element.value = "oui";
            //             if (element.id === "achat") {
            //                 document.querySelector('.budget_box').style.display = "block";
            //             }
            //         }
            //     })
            // });

            // textInput.forEach(element => {
            //     element.addEventListener('focus', () => {

            //     });
            //     element.addEventListener('blur', (e) => {
            //         if (element != motcleProj) {
            //             testEmpty(e, element);
            //         }
            //         testMotCle(e, element);
            //     });
            //     element.addEventListener('keyup', (e) => {
            //         if (element != motcleProj) {
            //             testEmpty(e, element);
            //         }
            //     });
            // });

            // inputSpecialite.forEach(specialite => {
            //     specialite.addEventListener('change', (e) => {
            //         testSpe(e, specialite);
            //     });
            // });

            cadrageInput.addEventListener('change', (e) => {
                testSelect(e, cadrageInput);
            });

            // valid_motcle.addEventListener('click', (e) => {
            //     e.preventDefault();
            //     let valueMotCle = motcleProj.value;
            //     if (valueMotCle.length > 2) {
            //         testMotCle(e, motcleProj, valueMotCle);
            //         //addKeyWord(motcleProj, valueMotCle);
            //     }
            // })

            // motcleProj.addEventListener('keydown', (e) => {
            //     let valueMotCle = motcleProj.value;
            //     if (e.code == 'Space') {
            //         e.preventDefault();
            //     }
            //     if (e.code == 'Enter' && valueMotCle.length > 2) {
            //         testMotCle(e, motcleProj, valueMotCle);
            //         //addKeyWord(motcleProj, valueMotCle);
            //     }
            // });

            // page suivante et précédente formulaire

            // btn_suivant.addEventListener('click', (e) => {
            //     textInput.forEach(input => {
            //         if (input != motcleProj) {
            //             testEmpty(e, input);
            //         }
            //         testMotCle(e, input);
            //     });
            //     // RadioInput.forEach(input => {
            //     //     testSpe(e, input);
            //     // });
            //     selectInput.forEach(input => {
            //         testSelect(e, input);
            //     });
            //     testUpload();

            //     for (let index = 0; index < list_keyword.children.length; index++) {
            //         list_keyword.children[index].firstElementChild.name = 'motcle' + (index + 1);
            //     }
            //     if (e.target.dataset.page == 2) {
            //         testSelect(e, cadrageInput);
            //         testCheck(e, select_type);
            //     }
            // });

            btn_suivant.addEventListener('click', validForm);

            selectInput.forEach(element => {
                element.addEventListener('change', (e) => {
                    if (e.target === anneproj) {
                        if (e.target.value == 5) {
                            selectEtu.min = 1;
                            selectEtu.max = 4;
                            selectEtu.nextElementSibling.value = selectEtu.max / 2;
                        }
                    }
                    testSelect(e, element);
                });
            })

            testUpload();
        }

        function testSelect(e, element) {
            if (element.value === "selection") {
                errorMsg(e, element, "Une année doit être selectionnée.");
            } else if (element.value === "") {
                errorMsg(e, element, "Un nom d'encadrant doit être selectionné");
            } else {
                succesMsg(element);
            }
        }

        function testCheck(e, select_type) {
            let check = false;
            for (let index = 0; index < select_type.children.length; index++) {
                if (select_type.children[index].firstElementChild.firstElementChild.checked === true) {
                    check = true;
                }
            }
            if (check) {
                succesMsg(select_type);
            } else {
                errorMsg(e, select_type, 'Vous devez selectionner au moins un type de projet');
            }
        }

        function testUpload() {
            uploadInput.forEach(element => {
                let list_res;
                let message;
                if (element === inputImage) {
                    list_res = ext_images;
                    message = "Vous devez selectionnez un fichier au format PNG, JPG, JPEG ou GIF";
                } else {
                    list_res = ext_documents;
                    message = 'Vous devez selectionnez un fichier au format PDF';
                }
                element.addEventListener('change', (e) => {
                    let extension = element.value.slice(element.value.lastIndexOf('.') + 1);
                    if (extension) {
                        if (list_res.includes(extension)) {
                            succesMsg(element);
                        } else {
                            errorMsg(e, element, message);
                            return;
                        }
                    }
                    let container;
                    let nomRes;
                    if (e.target === inputImage) {
                        container = document.querySelector('.projet-images');
                        nomRes = 'projetimg';
                    } else {
                        console.log('coucou');
                        container = document.querySelector('.projet-doc');
                        nomRes = 'projetdoc';
                    }
                    container.innerHTML = "";
                    let files = e.target.files;
                    let array_file;
                    for (let index = 0; index < files.length; index++) {
                        let img_upload = document.createElement('img');
                        let div = document.createElement('div');
                        div.classList.add(nomRes);
                        container.appendChild(div);
                        container.lastChild.appendChild(img_upload);
                        if (element === inputImage) {
                            img_upload.src = URL.createObjectURL(files[index]);
                            div.insertAdjacentHTML('beforeend', "<button class='btn_supr_img'><i class='fa-solid fa-xmark'></button>");
                        } else {
                            img_upload.src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/Icon_pdf_file.svg/1795px-Icon_pdf_file.svg.png';
                            container.insertAdjacentHTML('beforeend', '<p>' + files[index].name + '</p>')
                            container.style.background = "#f6f6f6";
                            container.insertAdjacentHTML('beforeend', "<button class='btn_supr_doc'><i class='fa-solid fa-xmark'></button>");

                        }
                        div.id = 'img-' + (index);
                    }
                    let btn_supr_img = document.querySelectorAll('.btn_supr_img');
                    let btn_supr_doc = document.querySelector('.btn_supr_doc');
                    if (btn_supr_img) {
                        let files_img = inputImage.files;
                        btn_supr_img.forEach(element => {
                            element.addEventListener('click', (e) => {
                                e.preventDefault();
                                for (let u = 0; u < document.querySelector('.projet-images').children.length; u++) {
                                    document.querySelector('.projet-images').children[u].id = 'img-' + u;
                                }
                                let index = parseInt(e.currentTarget.parentElement.id.split('-')[1]);
                                array_file = Array.from(inputImage.files);
                                array_file.splice(index, 1);
                                let list = new DataTransfer();
                                array_file.forEach(file => {
                                    list.items.add(file);
                                });
                                inputImage.files = list.files;
                                e.currentTarget.parentElement.remove();
                            });
                        })
                    }

                    if (btn_supr_doc) {
                        btn_supr_doc.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.currentTarget.parentElement.innerHTML = "";
                            inputDiapo.value = "";
                        });
                    }
                });
            });
        }

        // function testSpe(e, element) {
        //     let checked = false;
        //     if (NodeList.prototype.isPrototypeOf(element)) {
        //         for (let index = 0; index < element.length; index++) {
        //             if (element[index].firstElementChild.checked) {
        //                 checked = true;
        //             }
        //         }
        //         element = element[0].parentNode;
        //     } else {
        //         if (element.checked) {
        //             checked = true;
        //         }
        //         element = element.parentNode.parentNode;
        //     }
        //     if (checked === false) {
        //         errorMsg(e, element, 'selectionnez une spécialité');
        //     } else {
        //         succesMsg(element);
        //     }
        // }

        function testEmpty(event, element) {
            let nb;
            if (element.type == "textarea") {
                nb = longeurResum;
            } else if (element.id === "inputPorteurEmail") {
                nb = longeurEmail;
            } else {
                nb = longneurMin;
            }
            if (element.value.length < nb && element.value.length > 0) {
                errorMsg(event, element, 'Ce champ doit contenir ' + nb + ' caractères.');
            } else if (element.value.length === 0) {
                errorMsg(event, element, 'Ce champ doit contenir ' + nb + ' caractères.');
                if (!event.target.type) {
                    clear('error', element);
                    clear('succes', element);
                }
            } else {
                succesMsg(element);
            }
        }

        // function addKeyWord(motcleProj, valueMotCle) {
        //     list_keyword.insertAdjacentHTML('afterbegin', "<li><input class='inputmot' value='" + valueMotCle + "'><span><i class='btn_motcle' name='motcle'></i></span></li>");
        //     let test = document.querySelector(".list_keyword>li");
        //     const contexte = document.createElement('canvas').getContext('2d');
        //     contexte.font = window.getComputedStyle(test.querySelector('input'), null).getPropertyValue('font-size');
        //     const {
        //         width
        //     } = contexte.measureText(test.querySelector('input').value);
        //     test.querySelector('input').style.width = width * 1.5 + 'px';
        //     if (list_keyword.children.length >= 3) {
        //         succesMsg(motcleProj);
        //     }
        //     motcleProj.value = "";
        //     document.querySelector('.btn_motcle').addEventListener('click', (e) => {
        //         e.target.parentNode.parentNode.remove();
        //         testMotCle(e, motcleProj);
        //     })
        // }

        // function testMotCle(e, element, value = null) {
        //     if (element.id == "inputKeywords") {
        //         if (e.type === "blur" || e.type == "click") {
        //             let eleCount = list_keyword.children.length;
        //             if (eleCount < 3 || eleCount > 5) {
        //                 errorMsg(e, element, 'Vous devez avoir entre 3 et 5 mots clés.');
        //             } else {
        //                 succesMsg(element);
        //             }
        //         }
        //         if (value !== null) {
        //             if (list_keyword.children.length < 5) {
        //                 for (let index = 0; index < list_keyword.children.length; index++) {
        //                     if (list_keyword.children[index].firstChild.value === value) {
        //                         timeErrorMsg(e, element, "Ce mot est déjà présent dans la liste.");
        //                         element.value = "";
        //                         return;
        //                     }
        //                 }
        //                 addKeyWord(element, value);
        //             }
        //         }

        //     }
        // }

        function errorMsg(e, element, message) {
            if (element.id === "inputKeywords") {
                element = element.parentNode;
            }
            clear('succes', element);
            let errorBloc = element.parentNode.children.errorMsg;
            let span = document.createElement("span");
            span.classList.add('errorMsg');
            span.id = 'errorMsg';
            if (!errorBloc) {
                span.innerHTML = "<p>" + message + "</p>";
                element.after(span);
                if (RadioInput[0][0].parentElement == element) {
                    element.style.background = '#fff6f4';
                }
                console.log(element);
                if (element.tagName === "DIV") {
                    element.style.border = 'solid 1px';
                }
                element.style.borderColor = 'red';
            } else {
                let newMsg = document.createElement('p');
                newMsg.innerText = message;
                if (message !== errorBloc.lastChild.textContent) {
                    errorBloc.appendChild(newMsg);
                }
            }
            e.stopImmediatePropagation();
        }



        function timeErrorMsg(e, element, message) {
            if (element.id === "inputKeywords") {
                element = element.parentNode;
            }
            clear('succes', element);
            //let tempErrorBloc = element.parentNode.children.errorMsg;
            let span = document.createElement("span");
            span.classList.add('tempErrorMsg');
            span.id = 'tempErrorMsg';

            span.innerHTML = "<p class='error_time'>" + message + "</p>";
            element.after(span);
            element.style.borderColor = 'red';
            setTimeout(() => {
                if (span.parentNode.children.length === 1) {
                    element.style.borderColor = '';
                }
                span.remove();
                clear("error", element);
            }, 2500);

        }

        function succesMsg(element) {
            if (element.id === "inputKeywords") {
                element = element.parentNode;
            }
            let check = document.createElement('i');
            check.classList.add('fas');
            check.classList.add('fa-check');
            check.id = 'check';
            let blocCheck = element.parentNode.children.check;
            clear('error', element);
            if (!blocCheck) {
                element.before(check);
                element.style.borderColor = 'green';
            }
        }

        function clear(etat, element) {
            if (etat === 'succes') {
                if (element.parentNode.children.check) {
                    element.parentNode.children.check.remove();
                    element.style.border = '';
                }
            } else if (etat === 'error') {
                if (element.parentNode.children.errorMsg) {
                    element.style.border = '';
                    element.parentNode.children.errorMsg.remove();
                    element.style.background = '';
                }
            }

        }

        function validForm(e) {
            if (!part1_ajout.classList.contains('.part1_ajout_rev')) {
                part1_ajout.classList.add('part1_ajout_rev');
                part2_ajout.classList.add('part2_ajout_rev');
                let btn_prec_ajout = document.querySelector('.btn_prec_ajout');
                if (btn_prec_ajout == undefined) {
                    btn_suivant.dataset.page = 2;
                    e.target.parentNode.insertAdjacentHTML('afterbegin', '<input class="btn_prec_ajout btn-lg btn btn-primary mt-sm-4 position-relative end-0" type="button" value="PRECEDENT">');
                    document.querySelector('.btn_prec_ajout').addEventListener('click', suiv_prec);
                } else {
                    document.forms['form_prop'].submit();
                    btn_prec_ajout.addEventListener('click', suiv_prec);
                }
            }
        }

        function suiv_prec(e) {
            part1_ajout.classList.remove('part1_ajout_rev');
            part2_ajout.classList.remove('part2_ajout_rev');
            e.target.nextElementSibling.dataset.page = 1;
            e.target.remove();
        }
    }
});
