<?php

class PlantillaCliente extends Eloquent { 
    

	public static $table = 'plantilla_cliente';
    

	public static $key = 'id_plantilla_cliente';
    

	public static $timestamps = false;

	public function plantilla(){ 
    	return $this->belongs_to('Plantilla', 'id_plantilla');
    }

    public function cliente(){ 
    	return $this->belongs_to('Cliente', 'id_cliente');
    }


}