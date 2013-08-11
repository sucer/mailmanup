<?php

class Sms_Grupos_Controller extends Base_Controller {

	public function action_crear(){
		return View::make('sms.grupos');
	}
	//funcion que lista los grupos de un cliente
	public function action_listar(){
		$grupos= BaseDatos::where('id_cliente','=',1)->order_by('id_base_datos','desc')->paginate(Config::get('mailmanup.cuantos'));
        //se le manda a la vista el arreglo Generos *
        return View::make("sms.listargrupos")
                    ->with('grupos',$grupos);
	}
	//funcion que actualiza el grupo
	public function action_actualizar($id_base_datos){
        return "Actualizando: ".$id_base_datos;
    }

}