<?php

class MensajeSms extends Eloquent { 
    

	public static $table = 'mensaje_sms';
    

	public static $key = 'id_mensaje_sms';
    

	public static $timestamps = false;

	public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }
    public function envios(){ 
        return $this->has_many('EnvioSms', 'id_mensaje_sms');
    }

}