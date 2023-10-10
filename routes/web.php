<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::resource('integrante', 'IntegranteController');
Route::resource('atividade', 'AtividadeController');
Route::resource('material', 'MaterialController');
Route::resource('atividade_integrante', 'AtividadeIntegranteController');

Route::prefix('/atividade')->group(function () {
    Route::get('/{atividade}/addFotoReuniao', 'AtividadeController@addFotoReuniao')->name('atividade.addFotoReuniao');
    Route::post('/{atividade}/', 'AtividadeController@storeFotoReuniao')->name('atividade.storeFotoReuniao');
});

Route::prefix('/atividade_integrante')->group(function () {
    Route::get('/{atividade}/create', 'AtividadeIntegranteController@create')->name('atividade_integrante.create');
    Route::post('/{atividade}/', 'AtividadeIntegranteController@store')->name('atividade_integrante.store');
});

Route::prefix('/site')->group(function() {
    Route::get('/atividade', 'SiteController@getAtividades')->name('site.atividade');
    Route::get('/integrante', 'SiteController@getIntegrantes')->name('site.integrante');
    Route::get('/material', 'SiteController@getMateriais')->name('site.material');
});

