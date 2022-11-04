/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/choix_proj.js ***!
  \************************************/
document.addEventListener('DOMContentLoaded', function () {
  // DRAG AND DROP -> choix des projets 
  var elements = document.querySelectorAll('.select_box>li');
  var elements_prio = document.querySelectorAll('.select_box_prio>li');
  var dragged;
  var id;
  var index;
  var indexDrop;
  var list;
  var titre_proj = document.querySelectorAll(".select_box>li>h3");
  var titre_proj_prio = document.querySelectorAll(".select_box_prio>li>h3");
  var container_titre_proj = document.querySelectorAll(".select_box>li");
  var container_titre_proj_prio = document.querySelectorAll(".select_box>li");

  function dragStart(e) {
    dragged = e.target;
    id = e.target.dataset.value;
    list = e.target.parentNode.children;
    dragged.style.opacity = 0.5;

    for (var i = 0; i < list.length; i++) {
      if (list[i] == dragged) {
        index = i;
      }
    }
  }

  function enter(e) {
    var bloc = e.target;

    if (bloc.parentNode.tagName == 'LI') {
      bloc = bloc.parentNode;
    } else if (bloc.parentNode.parentNode.tagName == 'LI') {
      bloc = bloc.parentNode.parentNode;
    }

    if (bloc.dataset.value !== id && bloc.parentNode == dragged.parentNode) {
      bloc.style.transform = "scale(1.05, 1.05)";

      if (bloc.classList.contains("vac")) {
        bloc.style.background = "#f1bd3d";
      } else {
        bloc.style.background = "#4479ca ";
      }
    }
  }

  function leave(e) {
    var leave = e.target;

    if (leave.tagName == "LI" || leave.tagName == "BUTTON" || leave.tagName == "H3" || leave.tagName == "I") {
      leave.style.transform = "scale(1, 1)";
      leave.style.background = "";
    }
  }

  function drop(e) {
    var dropzone_slc;
    var dropzone = e.target;
    dropzone.style.transform = "scale(1, 1)";
    dropzone.style.background = "";
    dragged.style.opacity = 1; // si un élément enfant de la liste est selectionné lor du drop, faire en sorte que ce soit le parent.

    if (dropzone.parentNode.tagName == 'LI') {
      dropzone = dropzone.parentNode;
    } // changement de la zone de drop en fonction de la liste selectionnée


    if (dragged.parentNode.classList.contains('select_box_prio')) {
      dropzone_slc = "dropzone_prio";
    } else {
      dropzone_slc = "dropzone";
    }

    if (dropzone.classList.contains(dropzone_slc) && dropzone.dataset.value !== id) {
      dragged.remove(dragged);

      for (var i = 0; i < list.length; i++) {
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

  elements.forEach(function (project) {
    project.addEventListener("dragstart", dragStart);
    project.addEventListener("dragover", function (e) {
      e.preventDefault();
    });
    project.addEventListener("dragend", function (e) {
      e.target.style.opacity = 1;
    });
    project.addEventListener("dragenter", enter);
    project.addEventListener('dragleave', leave);
    project.addEventListener("drop", drop);
  });
  elements_prio.forEach(function (project_prio) {
    project_prio.addEventListener("dragstart", dragStart);
    project_prio.addEventListener("dragover", function (e) {
      e.preventDefault();
    });
    project_prio.addEventListener("dragend", function (e) {
      e.target.style.opacity = 1;
    });
    project_prio.addEventListener("dragenter", enter);
    project_prio.addEventListener('dragleave', leave);
    project_prio.addEventListener("drop", drop);
  });
});
/******/ })()
;