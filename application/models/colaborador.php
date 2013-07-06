<?php

class Colaborador extends Eloquent { 
    public static $table = 'colaborador';
    public static $key = 'id_colaborador';
    public static $timestamps = false;

    public function cliente_padre(){ 
    	return $this->belongs_to('Cliente', 'id_cliente_padre');
    }

     public function cliente_hijo(){ 
    	return $this->belongs_to('Cliente', 'id_cliente_hijo');
    }

    public function rol(){
    	return $this->belongs_to('Rol', 'id_rol');
    }
}