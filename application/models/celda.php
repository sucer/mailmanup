<?php

class Celda extends Eloquent { 
    

	public static $table = 'celda';
    

	public static $key = 'id_celda';
    

	public static $timestamps = false;

	public function atributo(){ 
    	return $this->belongs_to('Atributo', 'id_atributo');
    }

	public function registro(){ 
    	return $this->belongs_to('Registro', 'id_registro');
    }

    


}