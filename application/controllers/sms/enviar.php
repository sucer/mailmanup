<?php

class Sms_Enviar_Controller extends Base_Controller {

	public function action_index(){
		return View::make('sms.enviosimple');
	}

}