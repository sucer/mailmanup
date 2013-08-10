<?php

class Sms_Grupos_Controller extends Base_Controller {

	public function action_index(){
		return View::make('sms.grupos');
	}
	
	public function action_listar(){
		$grupos= BaseDatos::where('id_cliente','=',1)->order_by('id_base_datos','desc')->paginate(Config::get('mailmanup.cuantos'));
        //se le manda a la vista el arreglo Generos *
        return View::make("sms.listargrupos")
                    ->with('grupos',$grupos);
	}

}