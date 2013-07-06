<?php

class Atributo extends Eloquent { 
    

	public static $table = 'atributo';
    

	public static $key = 'id_atributo';
    

	public static $timestamps = false;

	public function base_datos(){ 
    	return $this->belongs_to('BaseDatos', 'id_base_datos');
    }
    public function tipo_atributo(){ 
    	return $this->belongs_to('TipoAtributo', 'id_tipo_atributo');
    }
    public function celdas(){ 
        return $this->has_many('Celda', 'id_atributo');
    }

}