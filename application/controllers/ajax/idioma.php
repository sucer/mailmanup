<?php

class Ajax_Idioma_Controller extends Base_Controller {

    public function action_cambiar(){
		//Cambia el idioma de la app seteando la variable de session sesion_idioma
		switch (Input::get("idioma")) {
			case 'en':
				Session::put('sesion_idioma', 'en');
				break;
			case 'es':
				Session::put('sesion_idioma', 'es');
				break;
			default:
				Session::put('sesion_idioma', 'en');
				break;
		}
		return Session::get('sesion_idioma');
	}

	public function action_actual(){
		//Cambia el idioma de la app seteando la variable de session sesion_idioma
		return Session::get('sesion_idioma');
	}
}