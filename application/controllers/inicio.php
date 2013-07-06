<?php

class Inicio_Controller extends Base_Controller {

	public function action_index(){
		return View::make('plantillas.inicio');
	}

}