<?php

class Plantilla extends Eloquent { 
    

	public static $table = 'plantilla';
    

	public static $key = 'id_plantilla';
    

	public static $timestamps = false;

	public function categoria(){ 
    	return $this->belongs_to('CategoriaPlantilla', 'id_categoria_plantilla');
    }

    public function plantillas_cliente(){ 
    	return $this->has_many('PlantillaCliente', 'id_plantilla');
    }
}