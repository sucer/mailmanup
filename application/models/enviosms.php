<?php

class EnvioSms extends Eloquent { 
    

	public static $table = 'envio_sms';
    

	public static $key = 'id_envio_sms';
    

	public static $timestamps = false;


    public function mensaje(){ 
    	return $this->belongs_to('MensajeSms', 'id_mensaje_sms');
    }

}