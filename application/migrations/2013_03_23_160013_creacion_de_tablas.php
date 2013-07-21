<?php

class Creacion_De_Tablas {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up(){
		//
		Schema::create('cliente', function($table){
		    $table->increments('id_cliente');
		    $table->text('usuario');
		    $table->text('nombres');
		    $table->text('apellidos');
		    $table->text('correo');
		    $table->text('id_twitter')->nullable();
		    $table->text('id_facebook')->nullable();
		    $table->text('id_google')->nullable();
		    $table->timestamp('fecha_creacion');
		});

		Schema::create('rol', function($table){
		    $table->increments('id_rol');
		    $table->text('rol');
		});

		Schema::create('colaborador', function($table){
		    $table->increments('id_colaborador');
		    $table->integer('id_cliente_padre');
		    $table->integer('id_cliente_hijo');
		    $table->integer('id_rol');
		    $table->timestamp('fecha_creacion');
		    $table->foreign('id_cliente_padre')->references('id_cliente')->on('cliente');
		    $table->foreign('id_cliente_hijo')->references('id_cliente')->on('cliente');
		    $table->foreign('id_rol')->references('id_rol')->on('rol');
		});

		Schema::create('categoria_plantilla', function($table){
		    $table->increments('id_categoria_plantilla');
		    $table->text('categoria_plantilla');
		});

		Schema::create('plantilla', function($table){
		    $table->increments('id_plantilla');
		    $table->integer('id_categoria_plantilla');
		    $table->text('plantilla');
		    $table->text('html')->nullable();
		    $table->text('mensaje_sms')->nullable();
		    $table->timestamp('fecha_creacion');
		    $table->foreign('id_categoria_plantilla')->references('id_categoria_plantilla')->on('categoria_plantilla');
		});	

		Schema::create('plantilla_cliente', function($table){
		    $table->increments('id_plantilla_cliente');
		    $table->integer('id_cliente');
		    $table->integer('id_plantilla');
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		    $table->foreign('id_plantilla')->references('id_plantilla')->on('plantilla');
		});	

		Schema::create('archivo', function($table){
		    $table->increments('id_archivo');
		    $table->text('archivo');
		    $table->text('url');
		    $table->integer('id_cliente');
		    $table->timestamp('fecha_creacion');
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		});	

		Schema::create('base_datos', function($table){
		    $table->increments('id_base_datos');
		    $table->text('base_datos');
		    $table->integer('id_cliente');
		    $table->timestamp('fecha_creacion');
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		});

		Schema::create('registro', function($table){
		    $table->increments('id_registro');
		    $table->integer('id_base_datos');
		    $table->timestamp('fecha_creacion');
		    $table->boolean('borrado');
		    $table->foreign('id_base_datos')->references('id_base_datos')->on('base_datos');
		});

		Schema::create('tipo_atributo', function($table){
		    $table->increments('id_tipo_atributo');
		    $table->text('tipo_atributo');
		    $table->text('validacion');
		    $table->text('tipo_jqxgrid');
		    $table->text('formato');
		});

		Schema::create('atributo', function($table){
		    $table->increments('id_atributo');
		    $table->text('atributo');
		    $table->integer('id_tipo_atributo');
		    $table->integer('id_base_datos');
		    $table->foreign('id_base_datos')->references('id_base_datos')->on('base_datos');
		    $table->foreign('id_tipo_atributo')->references('id_tipo_atributo')->on('tipo_atributo');
		});

		Schema::create('celda', function($table){
		    $table->increments('id_celda');
		    $table->integer('id_atributo');
		    $table->integer('id_registro');
		    $table->text('valor');
		    $table->foreign('id_atributo')->references('id_atributo')->on('atributo');
		    $table->foreign('id_registro')->references('id_registro')->on('registro');
		});

		Schema::create('mensaje', function($table){
		    $table->increments('id_mensaje');
		    $table->integer('id_cliente');
		    $table->integer('id_base_datos');
		    $table->text('asunto');
		    $table->text('email_envia');
		    $table->text('email_responsable');
		    $table->text('mensaje');
		    $table->timestamp('fecha_creacion');
		    $table->timestamp('fecha_programada');
		    $table->integer('id_atributo_fecha_envio')->nullable();
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		    $table->foreign('id_base_datos')->references('id_base_datos')->on('base_datos');
		    $table->foreign('id_atributo_fecha_envio')->references('id_atributo')->on('atributo');
		});

		Schema::create('mensaje_sms', function($table){
		    $table->increments('id_mensaje_sms');
		    $table->integer('id_cliente');
		    $table->integer('id_base_datos');
		    $table->text('mensaje_sms');
		    $table->timestamp('fecha_creacion');
		    $table->timestamp('fecha_programada');
		    $table->integer('id_atributo_fecha_envio')->nullable();
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		    $table->foreign('id_base_datos')->references('id_base_datos')->on('base_datos');
		    $table->foreign('id_atributo_fecha_envio')->references('id_atributo')->on('atributo');
		});

		Schema::create('envio', function($table){
		    $table->increments('id_envio');
		    $table->integer('id_mensaje');
		    $table->text('correo');
		    $table->text('mensaje_enviado');
		    $table->timestamp('fecha_envio');
		    $table->foreign('id_mensaje')->references('id_mensaje')->on('mensaje');
		});

		Schema::create('envio_sms', function($table){
		    $table->increments('id_envio_sms');
		    $table->integer('id_mensaje_sms');
		    $table->text('movil');
		    $table->text('mensaje_sms_enviado');
		    $table->timestamp('fecha_envio');
		    $table->foreign('id_mensaje_sms')->references('id_mensaje_sms')->on('mensaje_sms');
		});

		Schema::create('desuscripcion', function($table){
		    $table->increments('id_desuscripcion');
		    $table->integer('id_envio');
		    $table->text('correo');
		    $table->text('ip');
		    $table->text('motivo');
		    $table->timestamp('fecha_desuscripcion');
		    $table->foreign('id_envio')->references('id_envio')->on('envio');
		});

		Schema::create('apertura', function($table){
		    $table->increments('id_apertura');
		    $table->integer('id_envio');
		    $table->text('correo');
		    $table->text('ip');
		    $table->timestamp('fecha_apertura');
		    $table->foreign('id_envio')->references('id_envio')->on('envio');
		});

		Schema::create('calificacion', function($table){
		    $table->increments('id_calificacion');
		    $table->integer('id_envio');
		    $table->integer('calificacion');
		    $table->text('correo');
		    $table->text('ip');
		    $table->timestamp('fecha_calificacion');
		    $table->foreign('id_envio')->references('id_envio')->on('envio');
		});

		Schema::create('tipo_parametro', function($table){
		    $table->increments('id_tipo_parametro');
		    $table->text('tipo_parametro');
		});

		Schema::create('parametro', function($table){
		    $table->increments('id_parametro');
		    $table->integer('id_cliente');
		    $table->integer('id_tipo_parametro');
		    $table->boolean('editable');
		    $table->text('parametro');
		    $table->text('valor');
		    $table->text('comentario')->nullable();
		    $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down(){
		//
		Schema::drop('parametro');
		Schema::drop('tipo_parametro');
		Schema::drop('calificacion');
		Schema::drop('apertura');
		Schema::drop('desuscripcion');
		Schema::drop('envio_sms');
		Schema::drop('envio');
		Schema::drop('mensaje_sms');
		Schema::drop('mensaje');
		Schema::drop('celda');
		Schema::drop('atributo');
		Schema::drop('tipo_atributo');
		Schema::drop('registro');
		Schema::drop('base_datos');
		Schema::drop('archivo');
		Schema::drop('plantilla_cliente');
		Schema::drop('plantilla');
		Schema::drop('categoria_plantilla');
		Schema::drop('colaborador');
		Schema::drop('rol');
		Schema::drop('cliente');
	}

}