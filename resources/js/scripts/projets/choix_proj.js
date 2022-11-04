document.addEventListener('DOMContentLoaded', () => {
    // DRAG AND DROP -> choix des projets
    let elements = document.querySelectorAll('.select_box>li');
    let elements_prio = document.querySelectorAll('.select_box_prio>li');
    let dragged;
    let id;
    let index;
    let indexDrop;
    let list;

    let titre_proj = document.querySelectorAll(".select_box>li>h3");
    let titre_proj_prio = document.querySelectorAll(".select_box_prio>li>h3");
    let container_titre_proj = document.querySelectorAll(".select_box>li");
    let container_titre_proj_prio = document.querySelectorAll(".select_box>li");


    function dragStart(e) {
        dragged = e.target;
        id = e.target.dataset.value;
        list = e.target.parentNode.children;
        dragged.style.opacity = 0.5;
        for (let i = 0; i < list.length; i++) {
            if (list[i] == dragged) {
                index = i;
            }
        }
    }

    function enter(e) {
        let bloc = e.currentTarget;
        if (bloc.dataset.value !== id && bloc.parentNode == dragged.parentNode) {
            bloc.style.transform = "scale(1.05, 1.05)";
            if (bloc.classList.contains("ai")) {
                bloc.style.background = "#f1bd3d";
            } else {
                bloc.style.background = "#7c7c7c";
            }

        }
    }

    function leave(e) {
        let leave = e.currentTarget;
        if (leave.tagName == "LI" || leave.tagName == "BUTTON" || leave.tagName == "H3" || leave.tagName == "I") {
            leave.style.transform = "scale(1, 1)";
            leave.style.background = "";
        }
    }

    function drop(e) {
        let dropzone_slc;
        let dropzone = e.target.parentNode;
        dropzone.style.transform = "scale(1, 1)";
        dropzone.style.background = "";
        dragged.style.opacity = 1;

        if (dragged.parentNode.classList.contains('select_box_prio')) {
            dropzone_slc = "dropzone_prio";
        } else {
            dropzone_slc = "dropzone";
        }
        if (dropzone.dataset.value !== id) {

            dragged.remove(dragged);
            for (let i = 0; i < list.length; i++) {
                if (list[i] == dropzone) {
                    indexDrop = i;
                }
            }

            if (index > indexDrop) {
                dropzone.before(dragged);
            } else {
                dropzone.after(dragged);
            }
        }
    }

    function getData(e) {
        let target = e.target
        if (e.target.parentNode.classList.contains('pt')) {
            target = e.target.parentNode;
        }
        document.querySelector('.bloc_infos').style.display = "block";
        let buttoninfo = document.querySelector('.informations_proj');
        let data = JSON.parse(target.dataset.id);
        let tabspan = [document.getElementById('ref'), document.getElementById('nom'), document.getElementById('prenom'), document.getElementById('datadepot'), document.getElementById('structure'),
            document.getElementById('mail'), document.getElementById('tel'), document.getElementById('adresse')
        ];
        let tabinfo = [document.getElementById("titre"), document.getElementById('description'), document.getElementById('annee'), document.getElementById('nbequipe'), document.getElementById('speopt')];
        buttoninfo.href = "/projets/informations/" + data.id;
        tabspan.forEach(tabdata => {
            if (tabdata.dataset.keyword === "date_creation") {
                let date = new Date(data.date_creation);
                data.date_creation = date.getDate() + ' ' + date.toLocaleString('default', {
                    month: 'long'
                }) + ' ' + date.getFullYear();
            }
            tabdata.nextElementSibling.innerHTML = data[tabdata.dataset.keyword];
        });

        tabinfo.forEach(tabdata => {
            data.annee_inge_cible = data.annee_inge_cible.substring(0, 1);
            tabdata.innerHTML = data[tabdata.dataset.keyword];
        });
    }

    elements.forEach(project => {
        project.addEventListener("dragstart", dragStart);
        project.addEventListener("dragover", (e) => {
            e.preventDefault();
        });
        project.addEventListener("dragend", (e) => {
            e.target.style.opacity = 1;
        });
        project.addEventListener("dragenter", enter);
        project.addEventListener('dragleave', leave);
        project.addEventListener("drop", drop);
        project.addEventListener('click', getData);
    });

    elements_prio.forEach(project_prio => {
        project_prio.addEventListener("dragstart", dragStart);
        project_prio.addEventListener("dragover", (e) => {
            e.preventDefault();
        });
        project_prio.addEventListener("dragend", (e) => {
            e.target.style.opacity = 1;
        });
        project_prio.addEventListener("dragenter", enter);
        project_prio.addEventListener('dragleave', leave);
        project_prio.addEventListener("drop", drop);
    });
});
