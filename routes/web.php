<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ici, nous redirigeons TOUTES les requêtes web vers l'application Vue.js (la vue welcome).
| C'est Vue Router qui se chargera d'afficher la bonne page selon l'URL.
|
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
