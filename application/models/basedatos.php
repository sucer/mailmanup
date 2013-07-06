<?php

class BaseDatos extends Eloquent { 
    

	public static $table = 'base_datos';
    

	public static $key = 'id_base_datos';
    

	public static $timestamps = false;

	public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }
    public function atributos(){ 
        return $this->has_many('Atributo', 'id_base_datos');
    }
    public function registros(){ 
        return $this->has_many('Registro', 'id_base_datos');
    }


}