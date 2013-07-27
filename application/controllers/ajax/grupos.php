<?php

class Ajax_Grupos_Controller extends Base_Controller {

	//función que valida el nombre del grupo para que sea unico
    public function action_validar(){
    	//valida que el nombre no exista
    	if(Input::has("grupo")){
    		$grupo = Input::get("grupo");
    		$basededatos = BaseDatos::where('base_datos','=',$grupo)->first();
    		if($basededatos){
    			return "false";
    		}else{
    			return "true";
    		}
		}
		return "false";
	}

	public function action_tipos(){
    	//retorna los option del select de tipos
		$tipos = DB::table('tipo_atributo')->order_by('id_tipo_atributo','asc')->get();
		$arrTipos = array();
		$html='<option value="-1" >'.__('grupos.seleccione-un-tipo-atributo').'</option>';
		foreach ($tipos as $tipo) {
			$html.='<option value="'.$tipo->id_tipo_atributo.'_'.$tipo->tipo_jqxgrid.'_'.$tipo->tipo_atributo.'" title="'.$tipo->validacion.'">'.__('grupos.'.$tipo->tipo_atributo).'</option>';
		}		
		return $html;
	}

	public function action_crear(){
    	
    	if(Input::has("grupo")){
    		$arrayBaseDeDatos = array(
                                'base_datos' =>Input::get("grupo"),
                                'id_cliente' =>1,
                                'fecha_creacion'=>date('Y-m-d H:i:s'),
                                );
            $basededatos= new BaseDatos();
            $basededatos->fill($arrayBaseDeDatos);
            $basededatos->save();
            return $basededatos->id_base_datos;
        }
	}

}