<?php

/*
|--------------------------------------------------------------------------
| ADM Routes
|--------------------------------------------------------------------------
*/

// auth routes
Auth::routes();
Route::get('/adm', "Adm\HomeController@index");

// Acompanhe Routes
Route::resource('/adm/acompanhe/', 'Adm\AcompanheController');
Route::get('/adm/acompanhe/order/', 'Adm\AcompanheController@order');
Route::get('/adm/acompanhe/edit/{url}/', 'Adm\AcompanheController@edit')->name('acompanhe-editar');
Route::post('/adm/acompanhe/edited/{id}', 'Adm\AcompanheController@update')->name('acompanhe-update');
Route::get('/adm/acompanhe/orderned/', 'Adm\AcompanheController@orderned');
Route::get('/adm/acompanhe/search/', 'Adm\AcompanheController@search');
Route::get('/adm/acompanhe/delete/{id}', 'Adm\AcompanheController@destroy');

// Contato Routes
Route::resource('/adm/contato/', 'Adm\ContatoController');
Route::get('/adm/contato/editar/{id}', 'Adm\ContatoController@edit')->name('contato-editar');
Route::post('/adm/contato/edited/{id}', 'Adm\ContatoController@update')->name('contato-update');
Route::get('/adm/contato/search/', 'Adm\ContatoController@search');
Route::get('/adm/contato/excel/', 'Adm\ContatoController@excel');
Route::get('adm/contato/delete/{id}', 'Adm\ContatoController@destroy')->name('contato-delete');

// News Routes
Route::resource('/adm/news/', 'Adm\NewsController');
Route::get('/adm/news/editar/{id}', 'Adm\NewsController@edit')->name('news-editar');
Route::post('/adm/news/edited/{id}', 'Adm\NewsController@update')->name('news-update');
Route::get('/adm/news/search/', 'Adm\NewsController@search');
Route::get('/adm/news/delete/{id}', 'Adm\NewsController@destroy')->name('news-delete');
Route::get('/adm/news/excel/', 'Adm\NewsController@excel');

// Google Routes
Route::resource('/adm/google/', 'Adm\GoogleController');
Route::get('/adm/google/edit/{id}', 'Adm\GoogleController@edit')->name('google-editar');
Route::post('/adm/google/edited/{id}', 'Adm\GoogleController@update')->name('google-update');

// UserDados
Route::get('/adm/dados-usuario/', 'Adm\UserController@index');
Route::post('/adm/dados-usuario/update/{id}','Adm\UserController@submit');

/*
|--------------------------------------------------------------------------
| Website Routes
|--------------------------------------------------------------------------
*/

Route::get("/", "HomeController@index")->name('home');
Route::post("/news", "HomeController@submit")->name("news");
Route::get("/enviado", "HomeController@sucesso")->name('home-sucesso');

Route::get('/acompanhe', "AcompanheController@index")->name('acompanhe');
Route::get("/acompanhe/{url}", "AcompanheController@show")->name('acompanhe-show');
Route::post('/acompanhe/links', "AcompanheController@busca")->name('acompanhe-busca');

Route::get("/contato", "ContatoController@index")->name("contato");
Route::post("/contato/submit", "ContatoController@submit")->name("contato-submit");
Route::get("/contato/sucesso", "ContatoController@sucesso")->name("contato-sucesso");
