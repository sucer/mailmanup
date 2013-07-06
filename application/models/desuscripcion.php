<?php

class Desuscripcion extends Eloquent { 
    

	public static $table = 'desuscripcion';
    

	public static $key = 'id_desuscripcion';
    

	public static $timestamps = false;

	public function envio(){ 
    	return $this->belongs_to('Envio', 'id_envio');
    }

}