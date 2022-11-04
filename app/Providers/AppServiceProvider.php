<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\InventaireEmprunt as InventaireEmprunt;
use App\Models\Personnel as Personnel;
use App\Models\SI_demandes_wifi;
use App\Models\Etudiant as Etudiant;
use App\Models\InventaireCategorie as InventaireCategorie;
use Illuminate\Http\Request as Request;

use Illuminate\Support\Facades\Auth as Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        //
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        view()->composer(['partials.admin.sidebar', 'partials.inventoryheader', 'partials.header'], function ($view) {
            
            if (Auth::check()){

                $count = 0;
                $demandes = InventaireEmprunt::where('technicien_id', '!=', NULL)->whereBetween('status', [-1, 3])->get();
                foreach ($demandes as $d){
                    switch ($d->status){
                        case -1:
                        if (Auth::user()->hasRole('Responsable administratif')) {
                            $count++;
                        }
                        break;
                        case 0:
                        if (in_array(Personnel::user()->id, $d->encadrants_id())) {
                            $count++;
                        }
                        break;
                        case 1:
                        if (Personnel::user()->id == $d->technicien_id) {
                            $count++;
                        }
                        break;
                        case 2:
                        if (Auth::user()->hasRole('Responsable administratif')) {
                            $count++;
                        }
                        break;
                    }
                }

                $demandesEnAttente = SI_demandes_wifi::where("validation", 0)->orderBy("date_demande", 'DESC')->get();
                $view->with(['demandes_attente' => $count, 'notifications_informatique' => count($demandesEnAttente)]);
            };
        });

        // view()->composer(['partials.inventoryheader'], function ($view) {
        //      if (Personnel::getGuard()->check() || Etudiant::getGuard()->check()){
        //         $categories = InventaireCategorie::where('visible', 1)->get();
        //         $categories = $categories->sortByDesc(function($category){
        //             return $category->number_of_products();
        //         });
        //         $view->with('categories', $categories);
        //     }
        // });

    }
}
