<?php

class Ajax_Celda_Controller extends Base_Controller {

	public function action_actualizar(){
    	if(Input::has("valor")){
    		$celda = Celda::where('id_atributo','=',Input::get("id_atributo"))
                    ->where('id_registro','=',Input::get("id_registro"))
                    ->first();
            if($celda){
                //La celda existe
                //solo se actualiza el valor
                $celda->valor=Input::get("valor");
                $celda->save();
            }else{
                //crea la celda nueva
                $tupla = array(
                                'id_atributo' => Input::get("id_atributo"),
                                'id_registro' => Input::get("id_registro"),
                                'valor'=> Input::get("valor"),
                            );
                $celda= new Celda();
                $celda->fill($tupla);
                $celda->save();
            }
            return $celda->id_registro;
        }
	}

}