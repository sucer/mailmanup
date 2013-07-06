<!DOCTYPE HTML>
<html lang="{{ Session::get('sesion_idioma') }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@yield('titulo')
	<!-- ESTILOS -->
	{{ HTML::style('css/normalize.css') }}
  {{ HTML::style('css/estilos.css') }}
	{{ Asset::container('bootstrapper')->styles() }}
	@yield('css')
	<!-- JS -->
	{{ HTML::script('js/prefixfree.min.js') }}	
	{{ Asset::container('bootstrapper')->scripts() }}
  {{ HTML::script('js/script.js') }}

  <script>
    $(document).on("ready", actualizarVariables);
    function actualizarVariables(evento){
        if(!localStorage.url_base_app_dominio){
          localStorage.url_base_app_dominio='{{ URL::base() }}';
        }
    }
  </script>
	@yield('scripts')
</head>
<body>
	<div class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="{{ URL::base() }}">{{__('inicio.nombre-producto')}} </a>
          
          
          

          <div class="nav-collapse">
            <ul class="nav pull-right">
                <li class="divider-vertical"></li>
                <li class="dropdown visible-desktop">
                  <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{__('inicio.entrar')}} <strong class="caret"></strong></a>
                  <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                    {{ Form::open('home/login', 'POST',array('class'=>'')) }}
                    {{ Form::token() }}
                    {{ Form::text('username', Input::old('username'), array('class' => 'span2', 'placeholder' => __('inicio.usuario'))) }}
                    {{ Form::password('password', array('class' => 'span2', 'placeholder' => __('inicio.clave'))) }}
                    {{ Form::submit(__('inicio.entrar'), array('class'=>'btn-info')) }}
                  {{ Form::close() }}
                  </div>
                </li>



                <li class="dropdown visible-desktop">
                  <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{__('inicio.idioma')}} <strong class="caret"></strong></a>
                  <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                    <label class="radio"><input type="radio" name="sel_idioma" value="es" />{{ __('inicio.español') }}</label>
                    <label class="radio"><input type="radio" name="sel_idioma" value="en" />{{ __('inicio.ingles') }}</label>
                  </div>
                </li>

              <li> </li>
              <li>{{ HTML::link_to_action('home@logout', __('inicio.salir')) }}</li>
              
            </ul>
            <ul class="nav">
              <li class="active"><a href="{{URL::base();}}">{{__('inicio.inicio')}}</a></li>
                <li>{{ HTML::link_to_action('user@index', __('inicio.perfil')) }} </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


    <div id="section_contenido" class="container" >
      <div class="row-fluid">
        <div class="span2">
          <!--Sidebar content-->
          <ul>
            <li> <a href="{{ URL::base() }}/grupos/"> {{ __('inicio.enlace-grupos') }} </a></li>
            <li> <a href="{{ URL::base() }}/plantillas/"> {{ __('inicio.enlace-plantillas') }} </a></li>
            <li> <a href="{{ URL::base() }}/simple-sms/"> {{ __('inicio.enlace-simple-sms') }} </a></li>
            <li> <a href="{{ URL::base() }}/avanzado-sms/"> {{ __('inicio.enlace-avanzado-sms') }}</a></li>
          </ul>
         
        </div>
        <div class="span10">
          <!--Body content-->
          @yield('contenido')
      </div>
    </div>
	<div id="footer">
    <div class="container">
		 <p class="text-center">{{ __('inicio.powerby') }}</p> 	
    </div>
	</div>
</body>
</html>