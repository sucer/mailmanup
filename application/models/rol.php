<?php

class Rol extends Eloquent { 
    public static $table = 'rol';
    public static $key = 'id_rol';
    public static $timestamps = false;

    public function colaboradores (){
    	return $this->has_many('Colaborador', 'id_rol');
    }

}