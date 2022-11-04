<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administration\Materiel\APIController as PanelAPIController;



// Route::group(['middleware' => ['personnel']], function () {
Route::group(['middleware' => ['login']], function () {
    Route::post('emprunts/recherche', [PanelAPIController::class, 'emprunts_recherche']);
    Route::get('produits/recherche', [PanelAPIController::class, 'produits_recherche']);
    Route::post('historique/recherche', [PanelAPIController::class, 'historique_recherche']);
    Route::post('stocks/recherche', [PanelAPIController::class, 'stocks_recherche']);

    // Route::group(['middleware' => 'respmateriel'], function () {
        Route::post('etudiant', [PanelAPIController::class, 'etudiant']);
        Route::post('produits/references', [PanelAPIController::class, 'produits_references']);
    // });

    // Route::group(['middleware' => 'technicien'], function () {
        Route::post('types/filtres', [PanelAPIController::class, 'types_filtres']);
        Route::post('type', [PanelAPIController::class, 'type']);
        Route::post('produits/filtres', [PanelAPIController::class, 'produits_filtres']);
    // });

    // Route::group(['middleware' => 'etudiant'], function () {
        Route::patch('panier/ligne/quantite', [PanelAPIController::class, 'edit_product_quantity']);
        Route::delete('panier/ligne', [PanelAPIController::class, 'remove_product']);
        Route::post('panier/verification_assurance', [PanelAPIController::class, 'verification_presence_assurance']);
        Route::post('panier/verification_dates_assurance', [PanelAPIController::class, 'verification_dates_assurance']);
    // });

});



Route::fallback(function () {
    return abort(404);
});
