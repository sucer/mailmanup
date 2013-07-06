<?php

class Sms_Avanzado_Controller extends Base_Controller {

	public function action_index(){
		return View::make('sms.envioavanzado');
	}

}