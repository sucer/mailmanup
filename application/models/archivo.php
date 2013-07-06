<?php

class Archivo extends Eloquent { 
    

	public static $table = 'archivo';
    

	public static $key = 'id_archivo';
    

	public static $timestamps = false;

	public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }

}