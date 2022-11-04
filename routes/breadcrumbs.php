<?php

use App\Models\Projet;

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('administration.index', function (BreadcrumbTrail $trail): void {
  $trail->push('Accueil', route('administration.index'));
});

/* PROJETS */

Breadcrumbs::for('administration.projets.dashboard', function (BreadcrumbTrail $trail): void {
  $trail->parent('administration.index');
  $trail->push('Projets', route('administration.projets.dashboard'));
});

Breadcrumbs::for('administration.projets.edit', function (BreadcrumbTrail $trail, Projet $projet): void {
  $trail->parent('administration.projets.dashboard');
  $trail->push('Editer le projet n°'.$projet->id, route('administration.projets.dashboard', $projet->id));
});


/* MATERIELS */

Breadcrumbs::for('administration.materiel.requests.index', function (BreadcrumbTrail $trail): void {
  $trail->parent('administration.index');
  $trail->push('Matériel', route('administration.materiel.requests.index'));
});
