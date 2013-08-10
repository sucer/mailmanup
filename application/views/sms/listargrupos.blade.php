@layout('template.base')
@section('titulo')
<title>{{ __('grupos.titulo-listar-grupos')}}</title>
@endsection
@section('css')
{{ HTML::style('js/jqwidgets/styles/jqx.base.css') }}
{{ HTML::style('js/jqwidgets/styles/jqx.bootstrap.css') }}
@endsection

@section('scripts')
{{ HTML::script('js/sms/listargrupos.js') }}
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
@endsection

@section('contenido')
	<h2>
	{{__('grupos.lista-grupos')}}
	</h2>
	<div class="row-fluid">
		<div class="span10">
			<div>{{__('grupos.mensaje-cantidad-grupos')}}<span>{{ count($grupos) }}</span></div>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span10">
			@forelse ($grupos->results as $grupo)
				<div>
					{{$grupo->base_datos}} {{Registro::where('id_base_datos','=',$grupo->id_base_datos)->count()}}
				</div>
			@empty
				<div>
					{{ __("base.empty") }}
				</div>
			@endforelse
			<div class="paginacion">
				{{ $grupos->links() }}
			<div>
		</div>
	</div>

@endsection