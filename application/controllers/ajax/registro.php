<?php

class Ajax_Registro_Controller extends Base_Controller {

	public function action_crear(){
    	if(Input::has("id_base_datos")){
    		$tupla = array(
                                'id_base_datos' => Input::get("id_base_datos"),
                                'fecha_creacion' => date('Y-m-d H:i:s'),
                                'borrado'=> 0,
                        );
            $registro= new Registro();
            $registro->fill($tupla);
            $registro->save();
            return $registro->id_registro;
        }
	}

}