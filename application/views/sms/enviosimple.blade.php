@layout('template.base')
@section('titulo')
<title>{{ __('sms.titulo-envio')}}</title>
@endsection
@section('contenido')
	<h2>
		{{__('sms.titulo-envio')}}
	</h2>
	<form>
	  <fieldset>
	    <legend>{{ __('sms.enviar-mensaje') }}</legend>
	    <label>{{ __('sms.destinatarios') }}</label>
	    <input type="text" placeholder="{{__('sms.ingrese-destinatarios')}}">
	    <span class="help-block">{{__('sms.ayuda-destinatarios')}}</span>
	    <label> {{__('sms.mensaje')}}</label>
	      <textarea rows="4"></textarea>
	    <button type="submit" class="btn">{{__('sms.enviar')}}</button>
	  </fieldset>
	</form>
@endsection