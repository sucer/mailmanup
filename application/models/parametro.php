<?php

class Parametro extends Eloquent { 
    

	public static $table = 'parametro';
    

	public static $key = 'id_parametro';
    

	public static $timestamps = false;

	public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }

    public function tipo_parametro(){ 
    	return $this->belongs_to('TipoParametro', 'id_tipo_parametro');
    }
}