<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/
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
	
	
	/*foreach (Cliente::all() as $cliente){
    	echo $cliente->nombres."<br />";
    	echo $cliente->fecha_creacion."<br />";
	}


	$hijos = Cliente::find(1)->colaboradores_padre;

	foreach ($hijos as $key => $hijo) {
	 	# code...
	 	echo $hijo->cliente_hijo()->first()->nombres."<br />";

	} 

	$padres = Cliente::find(1)->colaboradores_hijos;

	foreach ($padres as $key => $padre) {
	 	# code...
	 	echo $padre->cliente_padre()->first()->nombres."<br />";

	}*/
	
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
