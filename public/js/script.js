$(document).on("ready", inicio);
function inicio(evento){
	//asigno el evento de onchange al select de idioma
	$("input[name=sel_idioma]").on("click",seleccionarIdioma);
	//Detecta el idioma del navegador y lo asigna a la session
	if(!localStorage.sesion_idioma){
		//si es la primer vez que carga la aplicación 
		localStorage.sesion_idioma = detectarIdioma();
		$.ajax({
		   type: "POST",
		   url: localStorage.url_base_app_dominio+"/cambiar-idioma",
		   dataType: "html",
		   data: "idioma="+localStorage.sesion_idioma,
		   success: function(res){	
	       		localStorage.sesion_idioma=res;
	       		document.location.reload();       
	       }
		});
	}else{
		$.ajax({
		   type: "POST",
		   url: localStorage.url_base_app_dominio+"/idioma-actual",
		   dataType: "html",
		   success: function(res){	
	       		if(res==''){
	       			$.ajax({
					   type: "POST",
					   url: localStorage.url_base_app_dominio+"/cambiar-idioma",
					   dataType: "html",
					   data: "idioma="+localStorage.sesion_idioma,
					   success: function(res){	
				       		localStorage.sesion_idioma=res;
				       		document.location.reload();       
				       }
					});
	       		}
	       }
		});
	}
	//selecciona el idioma actual
	$("input[name=sel_idioma]").each(function() {
		if ( $(this).val()== localStorage.sesion_idioma) {
			$(this).attr("checked","checked");
		}
	});
}
//Funcion que cambia el idioma de la aplicación
function seleccionarIdioma(){
	var idioma = $("input:checked[name=sel_idioma]").val();
	localStorage.sesion_idioma=idioma;
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/cambiar-idioma",
	   dataType: "html",
	   data: "idioma="+idioma,
	   success: function(res){	
	   		localStorage.sesion_idioma=res;
       		document.location.reload();       
       }
	});
}
//Funcion que detecta el idioma del navegador
function detectarIdioma(){
	if (navigator.userLanguage) {
		baseLang = navigator.userLanguage.substring(0,2).toLowerCase();
	} else {
		baseLang = navigator.language.substring(0,2).toLowerCase();
	}
	return baseLang;
}