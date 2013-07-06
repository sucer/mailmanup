<?php

class TipoAtributo extends Eloquent { 
    

	public static $table = 'tipo_atributo';
    

	public static $key = 'id_tipo_atributo';
    

	public static $timestamps = false;

	public function atributos(){ 
        return $this->has_many('Atributo', 'id_tipo_atributo');
    }

}