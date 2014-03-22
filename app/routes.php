<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get ('login/{serial?}',  array( 'uses' => 'UserController@logIn' ) );
Route::post ('login/', array( 'uses' => 'UserController@validateLogIn' ) );
Route::get ('logout/',  array( 'uses' => 'UserController@logOut' ) );


Route::group (array( 'before' => 'auth' ), function()
{
	Route::get ( 'ajax/vehicle-model/{IdVehicleMake}',          array( 'uses' => 'AjaxController@getVehicleModel' ) );
	Route::get ( 'ajax/insurance-rates/{IdCompany}',          array( 'uses' => 'AjaxController@getInsuranceRates' ) );
	
	Route::get ( '/',                                           array( 'uses' => 'HomeController@showWelcome' ) );
	Route::get ( 'client/search',                               array( 'uses' => 'ClientController@searchClient' ) );
	Route::get ( 'client/perfil/{IdClient}',                    array( 'uses' => 'ClientController@perfilClient' ) );
	
	Route::get  ( 'client/driver-license/{IdClient}',           array( 'uses' => 'DriverLicenseController@driverLicense' ) );
	Route::post ( 'client/add-photo-driver-license/{IdClient}', array( 'uses' => 'DriverLicenseController@addPhotoDriverLicense' ) );
	
	Route::get  ('insurance/{IdClient}/{IdInsurance?}',                     array ('uses' => 'InsuranceController@insurance'));
	Route::post ('insurance/{IdClient}',                                    array ('uses' => 'InsuranceController@addInsurance'));
	Route::get  ('insurance/{IdClient}/{IdInsurance}/vehicle/{IdVehicle?}', array ('uses' => 'InsuranceController@vehicle'));
	Route::post ('insurance/{IdClient}/{IdInsurance}/vehicle/{IdVehicle?}', array ('uses' => 'InsuranceController@addVehicle'));
	Route::post ('insurance/{IdClient}/{IdInsurance}/vehicle/{IdVehicle}/photo', array ('uses' => 'InsuranceController@addVehiclePhoto'));
	
	Route::get ('insurance-near-expire/{beforeDays?}', array('uses' => 'InsuranceController@nearExpire'));
	Route::get ('insurance/delete/{IdInsurance?}',     array('uses' => 'InsuranceController@delete'));
	
	Route::get  ( 'client/add', array( 'uses' => 'ClientController@addClient' ) );
	Route::post ( 'client/add', array( 'uses' => 'ClientController@addClient' ) );
	
	Route::post ( 'client/edit', array( 'uses' => 'ClientController@editClient' ) );

});




Route::group (array( 'before' => 'auth' ), function()
{
	Route::get  ( 'company/{IdCompany?}',          array( 'uses' => 'CompanyController@company' ) );
	Route::post ( 'company/addCompany',            array( 'uses' => 'CompanyController@addCompany' ) );
	Route::post ( 'company/addRates',              array( 'uses' => 'CompanyController@addRates' ) );
	Route::get  ( 'company/{IdCompany}/{IdRates}', array( 'uses' => 'CompanyController@company' ) )->where(array('IdCompany' => '[0-9]+', 'IdRates' => '[0-9]+'));

});