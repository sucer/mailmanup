<?php

class Mensaje extends Eloquent { 
    

	public static $table = 'mensaje';
    

	public static $key = 'id_mensaje';
    

	public static $timestamps = false;

	public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }
    public function envios(){ 
        return $this->has_many('Envio', 'id_mensaje');
    }

}