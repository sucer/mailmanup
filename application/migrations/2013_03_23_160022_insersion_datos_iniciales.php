<?php

class Insersion_Datos_Iniciales {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up(){
		//
		DB::table('tipo_atributo')->insert( array(
				array(
				'tipo_atributo' => 'correo',
	 			'validacion' => '[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}',
				),
				array(
				'tipo_atributo' => 'celular',
	 			'validacion' => '[0-9]{10}',
				),
				array(
				'tipo_atributo' => 'fecha',
	 			'validacion' => '^[0-3]{1}[0-9]{1}\/[0-1]{1}[0-9]{1}\/[0-9]{4}$',
				),
				array(
				'tipo_atributo' => 'numero',
	 			'validacion' => '[0-9]+$',
				),
				array(
				'tipo_atributo' => 'texto',
	 			'validacion' => '.*',
				),
			)
		);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}