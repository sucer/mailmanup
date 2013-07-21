@layout('template.base')
@section('titulo')
<title>{{ __('grupos.titulo-grupos')}}</title>
@endsection
@section('css')
{{ HTML::style('js/jqwidgets/styles/jqx.base.css') }}
{{ HTML::style('js/jqwidgets/styles/jqx.bootstrap.css') }}
@endsection

@section('scripts')
{{ HTML::script('js/sms/grupos.js') }}
{{ HTML::script('js/jqwidgets/jqxcore.js') }}
{{ HTML::script('js/jqwidgets/jqxdata.js') }}
{{ HTML::script('js/jqwidgets/jqxbuttons.js') }}
{{ HTML::script('js/jqwidgets/jqxscrollbar.js') }}
{{ HTML::script('js/jqwidgets/jqxmenu.js') }}
{{ HTML::script('js/jqwidgets/jqxcheckbox.js') }}
{{ HTML::script('js/jqwidgets/jqxlistbox.js') }}
{{ HTML::script('js/jqwidgets/jqxdropdownlist.js') }}
{{ HTML::script('js/jqwidgets/jqxgrid.js') }}
{{ HTML::script('js/jqwidgets/jqxgrid.sort.js') }}
{{ HTML::script('js/jqwidgets/jqxgrid.pager.js') }}
{{ HTML::script('js/jqwidgets/jqxgrid.selection.js') }}
{{ HTML::script('js/jqwidgets/jqxnumberinput.js') }}
{{ HTML::script('js/jqwidgets/jqxcalendar.js') }}

{{ HTML::script('js/jqwidgets/jqxdatetimeinput.js') }}

{{ HTML::script('js/jqwidgets/globalization/globalize.js') }}
{{ HTML::script('js/jqwidgets/jqxgrid.edit.js') }}

<script>
	localStorage.mensaje_error_nombre_grupo='{{__("grupos.mensaje-nombre-grupo")}}';
	localStorage.mensaje_error_numero_campos='{{__("grupos.mensaje-numero-campos")}}';
	localStorage.mensaje_error_grupo_existente = '{{__("grupos.mensaje-grupo-existente")}}';
	localStorage.nombre_campo = '{{__("grupos.nombre-campo")}}';
	localStorage.tipo_campo = '{{__("grupos.tipo-campo")}}';
	localStorage.mensaje_error_nombre_campo = '{{__("grupos.mensaje-error-nombre-campo")}}';
	localStorage.mensaje_error_tipo_campo = '{{__("grupos.mensaje-error-tipo-campo")}}';
	localStorage.boton_guardar_definicion = '{{__("grupos.boton-guardar-definicion")}}';
	localStorage.adicionar_campo = '{{__("grupos.adicionar-campo")}}';
	localStorage.mensaje_confirmacion_eliminacion_campo= '{{__("grupos.mensaje-confirmacion-eliminacion-campo")}}';
	localStorage.telefono = '{{__("grupos.telefono")}}';
	localStorage.id_atributo_telefono = {{ Config::get('mailmanup.id_atributo_telefono') }};
	localStorage.mensaje_campo_obligatorio = '{{__("grupos.mensaje-campo-obligatorio")}}';
	localStorage.add_fila = '{{__("grupos.agregar-fila")}}';
	localStorage.delete_fila = '{{__("grupos.borrar-fila")}}';
</script>
@endsection



@section('contenido')
	<h2>
	{{__('grupos.creacion-grupos')}}
	</h2>
	<div class="row-fluid">
		<div class="span10">
			<div class="alert alert-block alert-error" id="mensaje-error" style="display:none">
				<a class="close" id="cerar_mensaje" href="javascript:void(0)">&times;</a>
			</div>
			<label for="nombre_grupo">{{__('grupos.nombre-grupo')}}</label>
			<input type="text" id="nombre_grupo" name="nombre_grupo"/>
			<input type="button" class="btn btn-info" name="btn_definir_campos" id="btn_definir_campos" value="{{__('grupos.definir-campos')}}"/>
			
			<div id="form_campos">
				<label for="numero_campos">{{__('grupos.numero-campos')}}</label>
				<input type="text" id="numero_campos" name="numero_campos" pattern="[0-9]{1,2}" />
				<input type="button" class="btn btn-info" name="btn_mostrar_campos" id="btn_mostrar_campos" value="{{__('grupos.adicionar-campos')}}"/>
				<div id="campos_a_definir"></div>
			</div>
		</div>
	</div>
	<div id="tabla_grid"></div>
@endsection