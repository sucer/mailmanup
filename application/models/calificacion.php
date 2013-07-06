<?php

class Calificacion extends Eloquent { 
    

	public static $table = 'calificacion';
    

	public static $key = 'id_calificacion';
    

	public static $timestamps = false;

	public function envio(){ 
    	return $this->belongs_to('Envio', 'id_envio');
    }

}