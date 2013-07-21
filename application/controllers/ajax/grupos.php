<?php

class Ajax_Grupos_Controller extends Base_Controller {

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
			$html.='<option value="'.$tipo->id_tipo_atributo.'_'.$tipo->tipo_jqxgrid.'_'.$tipo->formato.'" title="'.$tipo->validacion.'">'.__('grupos.'.$tipo->tipo_atributo).'</option>';
		}		
		return $html;
	}
}