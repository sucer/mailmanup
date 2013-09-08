<?php

/************ CONTROLADORES AJAX ***********/
//http://cognos-univirtual.utp.edu.co/ajax/idioma/cambiar
Route::controller('ajax.idioma');
Route::controller('ajax.grupos');
Route::controller('ajax.atributo');
Route::controller('ajax.registro');
Route::controller('ajax.celda');
/*****************************************************/
//Personalización de URL amigables
//Llamado ajax para cambiar el idioma de la app
Route::post('/cambiar-idioma','ajax.idioma@cambiar');
Route::post('/idioma-actual','ajax.idioma@actual');
Route::any('/validar-nombre-grupo','ajax.grupos@validar');
Route::any('/get-tipos','ajax.grupos@tipos');
Route::any('/crear-grupo','ajax.grupos@crear');
Route::any('/crear-atributo','ajax.atributo@crear');
Route::any('/crear-registro','ajax.registro@crear');
Route::any('/actualizar-celda','ajax.celda@actualizar');

Route::any('/simple-sms','sms.enviar@index');
Route::any('/plantillas','sms.plantillas@index');
Route::any('/grupos','sms.grupos@listar');
Route::any('/actualizar-grupo/(:num)','sms.grupos@actualizar');
Route::any('/crear-grupo','sms.grupos@crear');
Route::any('/avanzado-sms','sms.avanzado@index');
Route::any('/login-google','login.login@google');
Route::any('/login-facebook','login.login@facebook');
Route::any('/login-twitter','login.login@twitter');
Route::any('/auth-twitter','login.login@reqtwitter');

Route::any('/git-update',function(){
	ini_set('memory_limit','32M');
	@set_time_limit(10000);
	exec('cd /var/www/mailmanup/;git pull origin master',$salida);
    var_dump($salida);
});

Route::any('/grid',function(){
	return View::make('sms.grid');
});

Route::get('/', function(){
	return View::make('paginas.inicio');
});
/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});


Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});
