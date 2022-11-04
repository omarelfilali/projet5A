document.addEventListener('DOMContentLoaded', () => {
    //let container_proj_etu = document.querySelector('.container_proj_etu');
    let butons = document.querySelectorAll('.menu-naviguation>div');
    let table_dashboard_proj = document.querySelector(".table_dashboard_proj");

    if (butons != null) {
        let container_relindus = document.querySelector('.container_relindus');
        let container_propos = document.querySelector('.container_propos');
        butons.forEach(buton => {
            buton.addEventListener('click', (e) => {
                if (!e.target.parentNode.classList.contains("ongletActif")) {
                    butons.forEach(buton_class => {
                        buton_class.classList.remove('ongletActif')
                    });
                    e.target.parentNode.classList.add("ongletActif");
                    if (e.target.id == "docs&infos") {
                        container_propos.setAttribute('style', 'display: none');
                        container_relindus.style.display = "grid";
                    } else if (e.target.id == "voeux_btn") {
                        container_relindus.setAttribute('style', 'display: none !important;');
                        container_propos.style.display = 'block';
                    }
                }
            });
        });
    }

    if (table_dashboard_proj != null) {

        // tout les chexbox sont validés lorsque le principale est validé

        let main_check = document.querySelector('.main_check');
        let all_check = document.querySelectorAll('.checkbox_dashboard');
        main_check.addEventListener('change', (e) => {
            all_check.forEach(check => {
                if (main_check.checked) {
                    check.checked = true;
                } else {
                    check.checked = false;
                }
            })
        })
    }

    //affichage du bloc de filtres

    let filtre_panel = document.querySelector('.filtre-panel');
    let filter_dashboard = document.querySelector('.filter_dashboard');

    if (table_dashboard_proj != null || filter_dashboard != null) {

        if (filtre_panel) {
            let buton_filtre = document.querySelector('.filter_dashboard');
            buton_filtre.addEventListener('click', () => {
                filtre_panel.classList.toggle('dispblock');
            })
            document.querySelector('.croix_filtre').addEventListener('click', () => {
                filtre_panel.classList.remove('dispblock');
            })
        }
    }

    let content_ajout_proj = document.querySelector('.content_ajout_proj');
    if (content_ajout_proj) {


        // ajouter des étudiants à un projet

        let check_ajout_etu = document.getElementById('ajouterEtudiants');
        let bloc_ajout_etu = document.querySelector('.bloc_ajout_etu');
        bloc_ajout_etu.style.display = "none";
        check_ajout_etu.addEventListener('change', (e) => {
            if (e.target.checked) {
                bloc_ajout_etu.style.display = "block";
            } else {
                bloc_ajout_etu.style.display = "none";
            }
        })

        //affichage des spécialités et des options

        document.querySelectorAll('.specialite').forEach(specialite => {
            if (specialite.childNodes[1].checked) {
                option_bloc(specialite.childNodes[1]);
            } else {
                document.querySelector('.options_spe').classList.toggle('display_n');
            }
            specialite.addEventListener('click', option_bloc);
        });

        function option_bloc(e) {
            let option = document.querySelectorAll('.option');
            let bloc_spe = document.querySelector('.options_spe');

            let active = e.target;
            if (active == undefined) {
                active = e;
            }
            switch (active.value) {
                case "A&I":
                    option[0].nextElementSibling.innerText = option[0].value = "Vibrations, Acoustique";
                    option[1].nextElementSibling.innerText = option[1].value = "Capteurs et Instrumentation";
                    bloc_spe.classList.remove('display_n');
                    break;

                case "INFO":
                    option[0].nextElementSibling.innerText = option[0].value = "Architecture des Systèmes Temps Réel et Embarqués";
                    option[1].nextElementSibling.innerText = option[1].value = "Interaction Personnes Systèmes";
                    bloc_spe.classList.remove('display_n');
                    break;
                case "Transversal":
                    bloc_spe.classList.toggle('display_n');
                    break;
                default:
                    break;
            }
        }
    }
});
