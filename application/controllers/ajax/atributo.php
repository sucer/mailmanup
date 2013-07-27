<?php

class Ajax_Atributo_Controller extends Base_Controller {

	public function action_crear(){
    	if(Input::has("id_base_datos")){
    		$tupla = array(
                                'atributo' => Input::get("atributo"),
                                'id_tipo_atributo' => Input::get("id_tipo_atributo"),
                                'id_base_datos'=> Input::get("id_base_datos"),
                        );
            $atributo= new Atributo();
            $atributo->fill($tupla);
            $atributo->save();
            return $atributo->id_atributo;
        }
	}

}