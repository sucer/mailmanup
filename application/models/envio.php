<?php

class Envio extends Eloquent { 
    

	public static $table = 'envio';
    

	public static $key = 'id_envio';
    

	public static $timestamps = false;


    public function mensaje(){ 
    	return $this->belongs_to('Mensaje', 'id_mensaje');
    }

    public function desuscripciones(){ 
        return $this->has_many('Desuscripcion', 'id_envio');
    }

    public function aperturas(){ 
        return $this->has_many('Apertura', 'id_envio');
    }

    public function calificaciones(){ 
        return $this->has_many('Calificacion', 'id_envio');
    }


}