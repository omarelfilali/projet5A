<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MigrationController;
use App\Http\Controllers\PermissionsController;

// Controllers pour les pages de l'administration :
use App\Http\Controllers\Administration\InternationalController as AdministrationInternationalController;
use App\Http\Controllers\Administration\ProjetController as AdministrationProjetController;
use App\Http\Controllers\Administration\InformatiqueController as AdministrationInformatiqueController;
use App\Http\Controllers\Administration\DroitsController as AdministrationDroitsController;

// Controllers pour les pages publiques :
use App\Http\Controllers\Public\ProjetController as PublicProjetController;
use App\Http\Controllers\Public\InformatiqueController as PublicInformatiqueController;
use App\Http\Controllers\Public\InternationalController as PublicInternationalController;

// Controllers pour les pages publiques de Materiel :
use App\Http\Controllers\Public\Materiel\RequestController as PublicRequestController;
use App\Http\Controllers\Public\Materiel\ProductController as PublicProductController;
use App\Http\Controllers\Public\Materiel\CartController as PublicCartController;
use App\Http\Controllers\Public\Materiel\QRCodeController as PublicQRCodeController;

// Controllers pour les pages de l'administration de Materiel:
use App\Http\Controllers\Administration\Materiel\ProductController as AdministrationProductController;
use App\Http\Controllers\Administration\Materiel\TypeController as AdministrationTypeController;
use App\Http\Controllers\Administration\Materiel\RequestController as AdministrationRequestController;
use App\Http\Controllers\Administration\Materiel\StaffController as AdministrationStaffController;
use App\Http\Controllers\Administration\Materiel\CategoryController as AdministrationCategoryController;
use App\Http\Controllers\Administration\Materiel\InsuranceController as AdministrationInsuranceController;
use App\Http\Controllers\Administration\Materiel\OptionController as AdministrationOptionController;


Route::get('/', [AuthController::class, 'auth'])->name('auth');
// Route::post('/login-interne', [AuthController::class, 'login_interne'])->name('login.interne');
Route::get('login_cas', [AuthController::class, 'loginCAS'])->name('login.cas');
Route::post('login_ensim', [AuthController::class, 'loginENSIM'])->name('login.ensim');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// TEST : création d'un role avec spatie-permission
Route::get('create_roles', [PermissionsController::class, 'test'])->name('create.role');

Route::get('/qrcode/{ref_id}', [PublicQRCodeController::class, 'index'])->name('qrcode.index');


/*
|--------------------------------------------------------------------------
| ROUTES ACCESSIBLES UNIQUEMENT UNE FOIS CONNECTÉ
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'login'], function () {

    Route::group(['middleware' => ['role:Administrateur']], function () {

        // Migrations :
        Route::get('/migration/projets', [MigrationController::class, 'migrationProjets']);
        Route::get('/migration/international', [MigrationController::class, 'migrationInternational']);
        Route::get('/migration/exterieurs', [MigrationController::class, 'exterieursToPersonnels']);
        Route::get('/migration/users', [MigrationController::class, 'migrationOldUsersToUtilisateur']);
        Route::get('/migration/test', [MigrationController::class, 'samy']);

        
    });

    Route::get('database', function () {return view('smoky-chicken.index');})->name('database');

    // Gestion de fichiers (files) utilisé lors des uploads dans des formulaires
    Route::post('add_tmp_file', [FileController::class, 'storeTmpFile'])->name('store_tmp_file');
    Route::post('remove_tmp_file', [FileController::class, 'removeTmpFile'])->name('remove_tmp_file');





    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

        /*
        |--------------------------------------------------------------------------
        | PROJETS
        |--------------------------------------------------------------------------
        */

        Route::controller(PublicProjetController::class)->prefix('projets')->group(function () {
            // Les routes suivants sont automatiquement au format : /projets/...
            Route::group(['middleware' => ['permission:module.projets']], function () {
                Route::get('/', 'index')->name('public.projets.relindus');
                Route::get('/voeux', 'voeux')->name('public.projets.choix_proj');
                // Route::get('projets/projets_etu',[PublicProjetController::class, 'projets_etu'])->name('public.projets.projets_etu');
                Route::get('/{id}', 'projets_etu')->name('public.projets.projets_etu');
                Route::get('/informations/{id}', 'infos_proj')->name('public.projets.show_proj');
            });
        });



        
        /*
        |--------------------------------------------------------------------------
        | INTERNATIONAL
        |--------------------------------------------------------------------------
        */

        Route::controller(PublicInternationalController::class)->prefix('international')->group(function () {
            // Les routes suivants sont automatiquement au format : /international/...
            Route::group(['middleware' => ['permission:module.international']], function () {
                Route::get('/', 'index')->name('public.international.index');
                Route::post('/', 'create_fiche')->name('public.international.create_fiche');
                Route::get('/{id}', 'show')->name('public.international.show_fiche');
            });
        });




        /*
        |--------------------------------------------------------------------------
        | INFORMATIQUE
        |--------------------------------------------------------------------------
        */

        Route::controller(PublicInformatiqueController::class)->prefix('informatique')->group(function () {
            // Les routes suivants sont automatiquement au format : /informatique/...
            Route::group(['middleware' => ['permission:module.informatique']], function () {
                Route::get('/', 'show')->name('public.informatique.show_demandes');
                Route::post('/', 'create_demande')->name('public.informatique.create_demande');
                Route::get('/logiciels', 'logiciels')->name('public.informatique.logiciels');
            });
        });
        



        /*
        |--------------------------------------------------------------------------
        | MATERIEL
        |--------------------------------------------------------------------------
        */

        Route::controller(PublicProductController::class)->prefix('materiel')->group(function () {
            // Les routes suivants sont automatiquement au format : /materiel/...
            Route::group(['middleware' => ['permission:module.materiel']], function () {

                // Product Routes
                Route::get('/', 'show_products')->name('public.materiel.products.index');
                Route::get('/category/{category?}', 'show_products')->name('public.materiel.products.category');
                Route::get('/products/{id}', 'show_product')->name('public.materiel.products.show');

                // Cart Routes
                Route::get('/cart', [PublicCartController::class, 'show_cart'])->name('public.materiel.cart.index');
                Route::patch('/cart/add_product', [PublicCartController::class, 'add_product'])->name('public.materiel.cart.add_product');
                Route::patch('/cart/remove_product', [PublicCartController::class, 'remove_product'])->name('public.materiel.cart.remove_product');
                Route::get('/cart/validation', [PublicCartController::class, 'validate_cart'])->name('public.materiel.cart.validation');

                // Request Routes
                Route::get('/requests', [PublicRequestController::class, 'show_requests'])->name('public.materiel.requests.index');
                Route::get('/requests/{id}', [PublicRequestController::class, 'show_request'])->name('public.materiel.requests.show');
                Route::put('/requests', [PublicRequestController::class, 'create_request'])->name('public.materiel.requests.create');
            });
        });

        



        
        
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::group(['middleware' => ['permission:module.administration']], function () {
        Route::get('administration', function () {return view('administration.index');})->name('administration.index');

            /*
            |--------------------------------------------------------------------------
            | PROJETS
            |--------------------------------------------------------------------------
            */

            Route::controller(AdministrationProjetController::class)->prefix('administration/projets')->group(function () {
                // Les routes suivants sont automatiquement au format : administration/projets/...
                Route::group(['middleware' => ['permission:administration.projets']], function () {
                    Route::get('/', 'projets')->name('administration.projets.dashboard');

                    Route::get('/affectation', 'affectation')->name('administration.projets.affectation');
                    Route::patch('/affectation', 'filtre_affectation')->name('administration.projets.filtre_affectation');

                    Route::get('/ajouter', 'ajouter')->name('administration.projets.prop_proj');

                    Route::get('/edit/{id}', 'edit')->name('administration.projets.edit');
                    Route::patch('/edit/{id}', 'update_projet')->name('administration.projets.update');

                    Route::delete('/delete/{id}', 'delete')->name('administration.projets.delete');

                    Route::get('/parametres', 'parametre')->name('administration.projets.parametres');
                    Route::put('/parametres/add', 'add_parametre')->name('administration.projets.parametres.add');

                    Route::post('/ajouter', 'postProj')->name('administration.projets.postProj');

                    //Route test pour tester le form
                    // Route::get('/administration/testencadrants', function () {return view('administration.projets.test_encadrants_post');});
                    // Route::post('/administration/testencadrants', [AdministrationProjetController::class, 'testEncadrants'])->name('administration.projets.encadrants_post');

                });
            });




            /*
            |--------------------------------------------------------------------------
            | INFORMATIQUE
            |--------------------------------------------------------------------------
            */

            Route::controller(AdministrationInformatiqueController::class)->prefix('administration/informatique')->group(function () {
                // Les routes suivants sont automatiquement au format : administration/informatique/...
                Route::group(['middleware' => ['permission:administration.informatique']], function () {
                    Route::get('/wifi', 'wifi')->name('administration.informatique.wifi');
                    Route::patch('/wifi_action', 'wifi_action')->name('administration.informatique.wifi_action');
                    Route::get('/parametres', 'parametre')->name('administration.informatique.parametres');
                    Route::put('/parametres/add', 'add_parametre')->name('administration.informatique.parametres.add');
                });
            });




            /*
            |--------------------------------------------------------------------------
            | INTERNATIONAL
            |--------------------------------------------------------------------------
            */

            Route::controller(AdministrationInternationalController::class)->prefix('administration/international')->group(function () {
                // Les routes suivants sont automatiquement au format : administration/international/...
                Route::group(['middleware' => ['permission:administration.international']], function () {
                    Route::get('/', 'dashboard')->name('administration.international.dashboard');
                    Route::get('/sejours', 'sejours')->name('administration.international.sejours');
                    Route::get('/fiche/{id}', 'show_fiche')->name('administration.international.fiche');
                    Route::get('/dispenses', 'index_dispense')->name('administration.international.dispenses');
                    Route::get('/bourses', function () {return view('administration.international.bourses');})->name('administration.international.bourses');
                    Route::get('/parametres', function () {return view('administration.international.parametres');})->name('administration.international.parametres');
                });
            });




            /*
            |--------------------------------------------------------------------------
            | MATERIEL
            |--------------------------------------------------------------------------
            */

            Route::prefix('administration/materiel')->group(function () {
                // Les routes suivants sont automatiquement au format : administration/materiel/...
                Route::group(['middleware' => ['permission:administration.materiel']], function () {

                    // Request Routes
                    Route::get('/', [AdministrationRequestController::class, 'index'])->name('administration.materiel.requests.index');
                    // Route::get('/administration/materiel/requests/all', [AdministrationRequestController::class, 'admin'])->name('administration.materiel.requests.admin')->middleware('admin');
                    Route::get('/requests/all', [AdministrationRequestController::class, 'admin'])->name('administration.materiel.requests.admin');
                    Route::get('/requests/{id}', [AdministrationRequestController::class, 'classic_show'])->name('administration.materiel.requests.show');
                    
                    Route::patch('/requests/{id}/action', [AdministrationRequestController::class, 'action'])->name('administration.materiel.requests.action');

                    /*
                    |--------------------------------------------------------------------------
                    | Routes accessibles via la permission [materiel.acces.respmateriel]
                    |--------------------------------------------------------------------------
                    */

                    Route::group(['middleware' => ['permission:materiel.acces.respmateriel']], function () {

                        // Stocks Routes
                        Route::get('/stocks', [AdministrationProductController::class, 'resp_stocks'])->name('administration.materiel.respmateriel.stocks');
                        Route::get('/stocks/{id}/history', [AdministrationProductController::class, 'history'])->name('administration.materiel.respmateriel.stocks.history');

                        // Request Routes
                        Route::get('/emprunts', [AdministrationRequestController::class, 'respm_emprunts'])->name('administration.materiel.respmateriel.emprunts');
                        Route::get('/emprunts/add', [AdministrationRequestController::class, 'respm_add'])->name('administration.materiel.respmateriel.create');
                        Route::put('/emprunts/add', [AdministrationRequestController::class, 'respm_create'])->name('administration.materiel.respmateriel.emprunts.create');
                        Route::get('/emprunts/{id}', [AdministrationRequestController::class, 'respm_show'])->name('administration.materiel.respmateriel.emprunts.show');
                        Route::patch('/emprunts/{id}/periode', [AdministrationRequestController::class, 'respm_update_periode'])->name('administration.materiel.respmateriel.emprunts.periode.update');
                        Route::patch('/emprunts/{id}/rendu', [AdministrationRequestController::class, 'respm_rendu'])->name('administration.materiel.respmateriel.emprunts.rendu');
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | Routes accessibles via la permission [materiel.acces.technicien]
                    |--------------------------------------------------------------------------
                    */

                    Route::group(['middleware' => ['permission:materiel.acces.technicien']], function () {

                        // Request Routes
                        Route::get('/requests/{id}/{article}/edit', [AdministrationRequestController::class, 'edit_product'])->name('administration.materiel.requests.products.edit');
                        Route::patch('/requests/{id}/{article}/edit', [AdministrationRequestController::class, 'update_product'])->name('administration.materiel.requests.products.update');
                        Route::put('/requests/{id}/encadrants/add', [AdministrationRequestController::class, 'add_encadrant'])->name('administration.materiel.requests.encadrants.add');
                        Route::delete('/requests/{id}/encadrants/delete', [AdministrationRequestController::class, 'delete_encadrant'])->name('administration.materiel.requests.encadrants.delete');
                        Route::patch('/requests/{id}/technicien', [AdministrationRequestController::class, 'update_technicien'])->name('administration.materiel.requests.technicien.update');
                        Route::patch('/requests/{id}/periode', [AdministrationRequestController::class, 'update_periode'])->name('administration.materiel.requests.periode.update');

                        // Product Routes
                        Route::get('/products', [AdministrationProductController::class, 'index'])->name('administration.materiel.products.index');
                        Route::get('/products/add', [AdministrationProductController::class, 'add'])->name('administration.materiel.products.add_product');
                        Route::put('/products/add', [AdministrationProductController::class, 'create'])->name('administration.materiel.products.create_product');
                        Route::get('/products/{id}', [AdministrationProductController::class, 'show_product'])->name('administration.materiel.products.show');
                        Route::patch('/products/{id}', [AdministrationProductController::class, 'update_product'])->name('administration.materiel.products.update');
                        Route::get('/products/{id}/history', [AdministrationProductController::class, 'history'])->name('administration.materiel.products.history');
                        Route::delete('/products/{id}/delete', [AdministrationProductController::class, 'delete_product'])->name('administration.materiel.products.delete_product');
                        Route::get('/products/{id}/stocks', [AdministrationProductController::class, 'stock'])->name('administration.materiel.products.stocks');
                        Route::put('/products/{id}/stocks/add', [AdministrationProductController::class, 'add_ref'])->name('administration.materiel.products.add_ref');
                        Route::get('/products/{id}/stocks/{ref_id}', [AdministrationProductController::class, 'show_ref'])->name('administration.materiel.products.show_ref');
                        Route::patch('/products/{id}/stocks/{ref_id}', [AdministrationProductController::class, 'update_ref'])->name('administration.materiel.products.update_ref');
                        Route::delete('/products/{id}/stocks/{ref_id}/delete', [AdministrationProductController::class, 'delete_ref'])->name('administration.materiel.products.delete_ref');

                        // Types Routes
                        Route::get('/types', [AdministrationTypeController::class, 'index'])->name('administration.materiel.types.index');
                        Route::get('/types/add', [AdministrationTypeController::class, 'add_type'])->name('administration.materiel.types.add_type');
                        Route::put('/types/create', [AdministrationTypeController::class, 'create_type'])->name('administration.materiel.types.create_type');
                        Route::get('/types/{id}', [AdministrationTypeController::class, 'show_type'])->name('administration.materiel.types.show_type');
                        Route::patch('/types/{id}', [AdministrationTypeController::class, 'update_type'])->name('administration.materiel.types.update_type');
                        Route::delete('/types/{id}/delete', [AdministrationTypeController::class, 'delete_type'])->name('administration.materiel.types.delete_type');
                        Route::put('/types/{id}/filters/add', [AdministrationTypeController::class, 'add_filter'])->name('administration.materiel.types.add_filter');
                        Route::get('/types/{id}/filters/{filter_id}', [AdministrationTypeController::class, 'show_filter'])->name('administration.materiel.types.show_filter');
                        Route::patch('/types/{id}/filters/{filter_id}', [AdministrationTypeController::class, 'update_filter'])->name('administration.materiel.types.update_filter');
                        Route::delete('/types/{id}/filters/{filter_id}/delete', [AdministrationTypeController::class, 'delete_filter'])->name('administration.materiel.types.delete_filter');

                        // Categories Routes
                        Route::get('/categories', [AdministrationCategoryController::class, 'index'])->name('administration.materiel.categories.index');
                        // Route::get('/panel/categories', [PanelCategoryController::class, 'index'])->name('panel.categories.index');
                        Route::put('/categories/add', [AdministrationCategoryController::class, 'add'])->name('administration.materiel.categories.add');
                        Route::get('/categories/{id}', [AdministrationCategoryController::class, 'show'])->name('administration.materiel.categories.show');
                        Route::patch('/categories/{id}', [AdministrationCategoryController::class, 'update'])->name('administration.materiel.categories.update');
                        Route::delete('/categories/{id}/delete', [AdministrationCategoryController::class, 'delete'])->name('administration.materiel.categories.delete');
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | Routes accessibles via la permission [materiel.acces.respadmin]
                    |--------------------------------------------------------------------------
                    */

                    Route::group(['middleware' => ['permission:materiel.acces.respadmin']], function () {

                        // Insurance Routes
                        Route::get('/insurances', [AdministrationInsuranceController::class, 'index'])->name('administration.materiel.insurances.index');
                        Route::patch('/insurances/{id}/action', [AdministrationInsuranceController::class, 'action'])->name('administration.materiel.insurances.action');                        
                    });

                    /*
                    |--------------------------------------------------------------------------
                    | Routes accessibles via la permission [materiel.acces.admin]
                    |--------------------------------------------------------------------------
                    */

                    Route::group(['middleware' => ['permission:materiel.acces.admin']], function () {
                        
                        // Options Routes
                        Route::get('/options', [AdministrationOptionController::class, 'index'])->name('administration.materiel.options.index');
                        Route::patch('/options', [AdministrationOptionController::class, 'update'])->name('administration.materiel.options.update');

                        // Staff Routes
                        Route::get('/staff/respadministratifs', [AdministrationStaffController::class, 'show_resp_administratifs'])->name('administration.materiel.staff.respadministratifs');
                        Route::put('/staff/respadministratifs/add', [AdministrationStaffController::class, 'add_resp_administratif'])->name('administration.materiel.staff.respadministratifs.add');
                        Route::delete('/staff/respadministratifs/{id}/delete', [AdministrationStaffController::class, 'delete_resp_administratif'])->name('administration.materiel.staff.respadministratifs.delete');

                        Route::get('/staff/techniciens', [AdministrationStaffController::class, 'show_techniciens'])->name('administration.materiel.staff.techniciens');
                        Route::put('/staff/techniciens/add', [AdministrationStaffController::class, 'add_technicien'])->name('administration.materiel.staff.techniciens.add');
                        Route::delete('/staff/techniciens/{id}/delete', [AdministrationStaffController::class, 'delete_technicien'])->name('administration.materiel.staff.techniciens.delete');

                        Route::get('/staff/respmateriels', [AdministrationStaffController::class, 'show_resp_materiels'])->name('administration.materiel.staff.respmateriels');
                        Route::put('/staff/respmateriels/add', [AdministrationStaffController::class, 'add_resp_materiel'])->name('administration.materiel.staff.respmateriels.add');
                        Route::get('/staff/respmateriels/{id}', [AdministrationStaffController::class, 'show_resp_materiel'])->name('administration.materiel.staff.respmateriels.show');
                        Route::patch('/staff/respmateriels/{id}', [AdministrationStaffController::class, 'update_resp_materiel'])->name('administration.materiel.staff.respmateriels.update');
                        Route::delete('/staff/respmateriels/{id}/delete', [AdministrationStaffController::class, 'delete_resp_materiel'])->name('administration.materiel.staff.respmateriels.delete');

                    });
                });
            });
            // Route::get('/panel/products/{id}', [PanelProductController::class, 'show_product'])->name('panel.products.show');
            // Route::patch('/panel/products/{id}', [PanelProductController::class, 'update_product'])->name('panel.products.update');





            /*
            |--------------------------------------------------------------------------
            | DROITS
            |--------------------------------------------------------------------------
            */

            Route::controller(AdministrationDroitsController::class)->prefix('administration/droits')->group(function () {
                // Les routes suivants sont automatiquement au format : administration/international/...
                Route::group(['middleware' => ['permission:administration']], function () {
                    Route::get('/utilisateurs', 'utilisateurs')->name('administration.droits.utilisateurs');
                    Route::get('/utilisateurs/{id}', 'edit_utilisateurs')->name('administration.droits.utilisateurs.edit');
                    Route::get('/roles', 'roles')->name('administration.droits.roles');
                    Route::get('/roles/{id}', [AdministrationDroitsController::class, 'show_roles'])->name('administration.droits.roles.show');
                        
                });
            });

    });
});