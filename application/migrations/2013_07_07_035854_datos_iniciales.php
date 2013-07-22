<?php

class Datos_Iniciales {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		DB::table('tipo_atributo')->insert( array(
				array(
				'tipo_atributo' => 'correo',
	 			'validacion' => '[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}',
	 			'tipo_jqxgrid' =>'textbox',
				),
				array(
				'tipo_atributo' => 'celular',
	 			'validacion' => '[0-9]{10}',
	 			'tipo_jqxgrid' => 'textbox',
				),
				array(
				'tipo_atributo' => 'fecha',
	 			'validacion' => '^[0-9]{4}\-[0-1]{1}[0-9]{1}\-[0-3]{1}[0-9]{1}$',
	 			'tipo_jqxgrid' => 'datetimeinput',
				),
				array(
				'tipo_atributo' => 'numero',
	 			'validacion' => '[0-9]+$',
	 			'tipo_jqxgrid' => 'numberinput',
				),
				array(
				'tipo_atributo' => 'texto',
	 			'validacion' => '.*',
	 			'tipo_jqxgrid' => 'textbox',
				),
				array(
				'tipo_atributo' => 'hora',
	 			'validacion' => '^[0-9]{2}:[0-9]{2}$',
	 			'tipo_jqxgrid' => 'textbox',
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