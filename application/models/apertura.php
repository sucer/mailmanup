<?php

class Apertura extends Eloquent { 
    

	public static $table = 'apertura';
    

	public static $key = 'id_apertura';
    

	public static $timestamps = false;

	public function envio(){ 
    	return $this->belongs_to('Envio', 'id_envio');
    }

}