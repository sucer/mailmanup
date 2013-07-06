<?php

class Sms_Plantillas_Controller extends Base_Controller {

	public function action_index(){
		return View::make('sms.plantillas');
	}

}