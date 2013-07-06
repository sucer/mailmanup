<?php

class CategoriaPlantilla extends Eloquent { 
    

	public static $table = 'categoria_plantilla';
    

	public static $key = 'id_categoria_plantilla';
    

	public static $timestamps = false;

	public function plantillas(){ 
    	return $this->has_many('Plantilla', 'id_plantilla');
    }

}