<?php
class Cliente extends Eloquent {

    public static $table = 'cliente';
    public static $key = 'id_cliente';
    public static $timestamps = false;

    public function colaboradores_padre(){ 
    	return $this->has_many('Colaborador', 'id_cliente_padre');
    }
	public function colaboradores_hijos(){ 
    	return $this->has_many('Colaborador', 'id_cliente_hijo');
    }
    public function plantillas_cliente(){ 
        return $this->has_many('PlantillaCliente', 'id_cliente');
    }
    public function parametros(){ 
        return $this->has_many('Parametro', 'id_cliente');
    }
    public function archivos(){ 
        return $this->has_many('Archivo', 'id_cliente');
    }
    public function bases_datos(){ 
        return $this->has_many('BaseDatos', 'id_cliente');
    }
    public function mensajes(){ 
        return $this->has_many('Mensaje', 'id_cliente');
    }
    public function envios(){ 
        return $this->has_many('Envio', 'id_cliente');
    }
}