<?php

class Sms_Grupos_Controller extends Base_Controller {

	public function action_index(){
		return View::make('sms.grupos');
	}

}