<?php

class Registro extends Eloquent { 
    

	public static $table = 'registro';
    

	public static $key = 'id_registro';
    

	public static $timestamps = false;

	public function celdas(){ 
        return $this->has_many('Celda', 'id_registro');
    }
    public function base_datos(){ 
    	return $this->belongs_to('BaseDatos', 'id_base_datos');
    }

}