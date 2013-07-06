<?php

class TipoParametro extends Eloquent { 
    

	public static $table = 'tipo_parametro';
    

	public static $key = 'id_tipo_parametro';
    

	public static $timestamps = false;

	public function parametros(){ 
        return $this->has_many('Parametro', 'id_tipo_parametro');
    }

}