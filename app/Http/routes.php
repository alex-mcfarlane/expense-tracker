<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>'auth'], function() {
	Route::get('/bills', 'BillsController@index');
	Route::get('bills/view/{id}', 'BillsController@view');
	Route::get('/bills/create', 'BillsController@create');
    Route::post('/bills', 'BillsController@store');

    Route::get("/bills/{billId}/entries/create", "BillEntryController@create");
    Route::post("/bills/{billId}/entries", "BillEntryController@store");

    Route::get("/billEntries/{id}/edit", "BillEntryController@edit");
    Route::get("/billEntries/{id}/pay", "BillEntryController@getPay");
    Route::put("/entries/{id}", "BillEntryController@update");
    Route::patch("/billEntries/{id}", "BillEntryController@partialUpdate");
    Route::delete("/billEntries/{id}", "BillEntryController@destroy");
});
