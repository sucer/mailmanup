//Definicion de variables globales
//Objeto global con la definicion de los campos de formulario inicial antes del grid
var arrCampos = [];
/* Estructura arreglo arrCampos
	[
		{ "campo":'producción',
		  "tipo": 1,
		  "validacion": '.*',
		}
	] */
//varible de validaciones
var validaciones ={};	
//variable global con los datos de la primera fila que van vacios
var datos_fila_nueva={};
//tipos de los campos de la fila nueva
var tipos_fila_nueva=[];
//columnas de la grid
var columnas_grid=[];
//variable global de numero de campos
var numero_campos = 0;
//ancho de la grid
var width_grid = 680;
//alto de la grid
var height_grid = 350;
//ancho campos
var ancho_campos=160;
//Funcion que se ejecuta cuando la pagina carga
$(document).on("ready", inicioGrupos);

//Funcion que muestra los mensajes de error
function mostrarMensaje(mensaje){
	$("#mensaje-error").css('display','block');
	$("#mensaje-error").append(mensaje+' ');
}

//Funcion que oculta el mensaje de error
function cerrarMensaje(evento){
	$("#mensaje-error").css('display','none');
	
}

//Funcion que devuelve la cadena en formato de variable
function convertirNombreVariable(str){
    var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
    var to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
    var mapping = {};
    var ret = [];

    //Arma el mapa de caracteres a reemplazar
    for(var i = 0; i < from.length; i++){
        mapping[ from.charAt( i ) ] = to.charAt( i );
    }
    //quito los espacios al inicio
    str= $.trim(str);
    //cambio los espacio por _
    str=str.replace(/ /g,"_");
    //recorre la cadena recibida
    for( var i = 0; i < str.length; i++ ) {
        //lee cada caracter
        var c = str.charAt( i );
        //mira si el objeto tiene la propiedad caracter especial
        if( mapping.hasOwnProperty( str.charAt( i ) ) )
          //coloca el caracter sin tilde, realiza la conversion
          ret.push( mapping[ c ] );
        else
          //coloca el carcater original
          ret.push( c );
    }
    return ret.join('').toLowerCase();
}

//funcion que inicializa el comportamiento de la pagina
function inicioGrupos(evento){
	//inializalizo la pagina
	$('#form_campos').css('display','none');
	//Asocio los eventos 
	$('#btn_definir_campos').on('click',mostrarDefinicionCampos);
	$('#btn_mostrar_campos').on('click',mostrarCamposaDefinir);
	$('#cerar_mensaje').on('click',cerrarMensaje);
}

//funcion que muestra el formulacio de la definicion del numero de 
function mostrarDefinicionCampos(evento){
	//Nombre de grupo o base de datos
	var nombre= $('#nombre_grupo').val();
	if(nombre == ""){
		mostrarMensaje(localStorage.mensaje_error_nombre_grupo);
		return 0;
	}
	//validacion ajax 
	//realiza la validación que el nombre del grupo no exista para el mismo cliente
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/validar-nombre-grupo",
	   dataType: "html",
	   data: "grupo="+$('#nombre_grupo').val(),
	   async: false,
	   success: function(res){	
       		if(res=="true"){
       			//el grupo no existe se puede continuar
       			//cierra el mensaje en caso de que estuviera abierto
       			cerrarMensaje();
       			//desactiva la edición del campo
       			$('#nombre_grupo').attr('disabled','true');
       			$('#btn_definir_campos').hide();
       			$('#form_campos').css('display','block');       
       		}else{
       			//el nombre del grupo existe
       			mostrarMensaje(localStorage.mensaje_error_grupo_existente);
       		}
       }
	});
}

//funcion que muestra el formulario con la definicion de los campos dependiendo el número de campos
function mostrarCamposaDefinir(evento){
	//numero de campos a crear
	var numero = $('#numero_campos').val();
	//valida que sea un numero entero
	if($.isNumeric(numero) && Math.floor(numero) == numero && numero.length>=1 && numero.length <= 2){
		//cierra el mensaje en caso de que estuviera abierto
		cerrarMensaje();
		//asigna el numero de campos a la variable global 
		window.numero_campos=numero;
		
		//oculta el boton
		$('#numero_campos').attr('disabled','true');
		//variable con las opciones de los tipos disponibles
		var tipos="";
		//llamado ajax para traer la lista de tipos de atributos
		$.ajax({
		   type: "POST",
		   url: localStorage.url_base_app_dominio+"/get-tipos",
		   dataType: "html",
		   async: false,
		   success: function(res){	
	          localStorage.opciones_tipos=res;
	       }
		});
		//activa los eventos de los botones 
		$('#btn_mostrar_campos').off('click',mostrarCamposaDefinir);
		$('#btn_mostrar_campos').attr('value',localStorage.adicionar_campo);
		$('#btn_mostrar_campos').on('click',adicionarCampo);
		//construye el html dinamico
		var html='<div id="seccion_campos">';
		for (var i = 1; i <= window.numero_campos; i++){
			if( i == 1){
				html+='\
					<div class="bloque_tipo_campos" id="div_campo_'+i+'"> \
					<a class="close" id="cerar_campo_'+i+'" href="javascript:eliminarCampo('+i+');">&times;</a> \
					<label for="campo_'+i+'">'+localStorage.nombre_campo+'</label> \
					<input type="text" id="campo_'+i+'" value="'+localStorage.telefono+'" required/> \
					<label for="tipo_campo_'+i+'">'+localStorage.tipo_campo+'</label> \
					<select name="tipo_campo_'+i+'" id="tipo_campo_'+i+'" required> \
						'+localStorage.opciones_tipos+'\
					</select> \
					</div> \
				';

			}else{

				html+='\
					<div class="bloque_tipo_campos" id="div_campo_'+i+'"> \
					<a class="close" id="cerar_campo_'+i+'" href="javascript:eliminarCampo('+i+');">&times;</a> \
					<label for="campo_'+i+'">'+localStorage.nombre_campo+'</label> \
					<input type="text" id="campo_'+i+'" required/> \
					<label for="tipo_campo_'+i+'">'+localStorage.tipo_campo+'</label> \
					<select name="tipo_campo_'+i+'" id="tipo_campo_'+i+'" required> \
						'+localStorage.opciones_tipos+'\
					</select> \
					</div> \
				';
			}
		}
		html+='</div> <input type="button" class="btn btn-primary" name="btn_guardar_definicion" id="btn_guardar_definicion" value="'+localStorage.boton_guardar_definicion+'"/> \
				';
		$('#campos_a_definir').html(html);
		//primer campo telefono
		$('#tipo_campo_1').val(localStorage.id_atributo_telefono+'_textbox_celular');
		//evento del boton
		$('#btn_guardar_definicion').on('click',validarDefinicionCampos);
	}else{
		mostrarMensaje(localStorage.mensaje_error_numero_campos);
		return 0;
	}
}

//funcion que adiciona un campo
function adicionarCampo(evento){
	$('#numero_campos').val(parseInt($('#numero_campos').val())+1);
	window.numero_campos++;
	var html='\
			<div class="bloque_tipo_campos" id="div_campo_'+window.numero_campos+'"> \
			<a class="close" id="cerar_campo_'+window.numero_campos+'" href="javascript:eliminarCampo('+window.numero_campos+');">&times;</a> \
			<label for="campo_'+window.numero_campos+'">'+localStorage.nombre_campo+'</label> \
			<input type="text" id="campo_'+window.numero_campos+'" required/> \
			<label for="tipo_campo_'+window.numero_campos+'">'+localStorage.tipo_campo+'</label> \
			<select name="tipo_campo_'+window.numero_campos+'" id="tipo_campo_'+window.numero_campos+'" required> \
				'+localStorage.opciones_tipos+'\
			</select> \
			</div> \
		';
	$('#seccion_campos').append(html);
}

//funcion que elimina el campo i
function eliminarCampo(i){
	if(confirm(localStorage.mensaje_confirmacion_eliminacion_campo)){
		$('#div_campo_'+i).remove();
		$('#numero_campos').val( parseInt($('#numero_campos').val()) - 1);
	}
}

//funcion que valida la definicion de los campos
function validarDefinicionCampos(evento){
	//cierra el mensaje en caso de que estuviera abierto
	cerrarMensaje();
	for (var i = 1; i <= window.numero_campos; i++){
		if($('#'+'campo_'+i).length!=0){
			if($('#'+'campo_'+i).val()==""){
				mostrarMensaje(localStorage.mensaje_error_nombre_campo);
				return false;
			}
			if($('#'+'tipo_campo_'+i).val()==-1){
				mostrarMensaje(localStorage.mensaje_error_tipo_campo);
				return false;
			}
			window.arrCampos.push( { 
				campo: $('#'+'campo_'+i).val(),
				tipo: $('#'+'tipo_campo_'+i).val().split('_')[1],
				validacion:$('#'+'tipo_campo_'+i)[0][ $('#'+'tipo_campo_'+i)[0].selectedIndex ].title, 
				tipo_atributo:$('#'+'tipo_campo_'+i).val().split('_')[2],
				id_tipo_atributo: $('#'+'tipo_campo_'+i).val().split('_')[0],
			});
			//Arreglo de validaciones Validaciones
			window.validaciones[convertirNombreVariable($('#'+'campo_'+i).val())] = $('#'+'tipo_campo_'+i)[0][ $('#'+'tipo_campo_'+i)[0].selectedIndex ].title+'#'+$('#'+'tipo_campo_'+i).val().split('_')[2];
		}
	}
	//oculto la seccion de creacion de campos
	$('#seccion_campos').hide();
	$('#btn_mostrar_campos').hide();
	$('#btn_guardar_definicion').hide();
	//llama a la funcion crearGrupo
	crearGrupo();
	//crea el primer registro
	crearRegistro(localStorage.id_base_datos,0);
	//llama a la funcion que crea la grid dinamica para el ingreso de los datos de cada campo
	mostrarGrid();
}

//Funcion que limpia la fila nueva
function getFilaNueva(){
	var datos={};
	for (i in window.arrCampos){
		//carga la fila nueva con valores vacios
		datos[ window.arrCampos[i].campo ] ='';
	}
	return datos;
}
//function crea un  Grupo
function crearGrupo(){
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/crear-grupo",
	   dataType: "html",
	   data: "grupo="+$('#nombre_grupo').val(),
	   async: false,
	   success: function(res){	
       		if(res!="-1"){
     			localStorage.id_base_datos=res;
     			console.log('id_base_datos: '+localStorage.id_base_datos);
       		}
       }
	});
}
//funcion que crea el atributo enviado en la base de datos
function crearAtributo(atributo,id_tipo_atributo,id_base_datos){
	//realiza el llamado ajax
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/crear-atributo",
	   dataType: "html",
	   data: "atributo="+atributo+"&id_tipo_atributo="+id_tipo_atributo+"&id_base_datos="+id_base_datos,
	   async: false,
	   success: function(res){	
       		if(res!="-1"){
       			var campo = convertirNombreVariable(atributo);
     			localStorage['id_atributo_'+campo]=res;
     			console.log('id_atributo_'+campo+': '+localStorage['id_atributo_'+campo]);
       		}
       }
	});
}
//funcion que guarda el atributo enviado en la base de datos
function crearRegistro(id_base_datos,fila){
	//realiza el llamado ajax
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/crear-registro",
	   dataType: "html",
	   data: "id_base_datos="+id_base_datos,
	   async: false,
	   success: function(res){	
       		if(res!="-1"){
     			localStorage['id_registro_'+fila]=res;
     			console.log('id_registro_'+fila+': '+localStorage['id_registro_'+fila]);
       		}
       }
	});
}
//funcion que actualiza el valor de la celda
function actualizarCelda(id_atributo,id_registro,valor){
	//realiza el llamado ajax
	$.ajax({
	   type: "POST",
	   url: localStorage.url_base_app_dominio+"/actualizar-celda",
	   dataType: "html",
	   data: "id_atributo="+id_atributo+"&id_registro="+id_registro+"&valor="+valor,
	   async: false,
	   success: function(res){	
       		if(res!="-1"){
     			localStorage['id_celda_'+id_registro+'_'+id_atributo]=res;
     			console.log('id_celda_'+id_registro+'_'+id_atributo+': '+localStorage['id_celda_'+id_registro+'_'+id_atributo]);
       		}
       }
	});
}
//funcion que muestra la grid
function mostrarGrid(evento){
	//console.log('arrCampos');
	//console.log(window.arrCampos);
	//var w = parseInt(window.width_grid/window.numero_campos);
	var w= parseInt(window.ancho_campos);
	//recorro el arreglo de campos
	for (c in window.arrCampos){
		//crea en la base de datos los atributos
		crearAtributo(
				window.arrCampos[c].campo,
				window.arrCampos[c].id_tipo_atributo,
				localStorage.id_base_datos
		);
		//carga la fila nueva con valores vacios
		window.datos_fila_nueva[ window.arrCampos[c].campo ] ='';
		//carga los tipos todos string
		window.tipos_fila_nueva.push({
			"name": convertirNombreVariable(window.arrCampos[c].campo),
			"type": 'string',
		});
		//carga las opciones de entrada para cada campo
		window.columnas_grid.push({
			expresion: window.arrCampos[c].validacion,
			posicion:c,
			text: window.arrCampos[c].campo,
			datafield: convertirNombreVariable(window.arrCampos[c].campo),
			columntype: window.arrCampos[c].tipo,
			width: w,
			resizable: true,
			validation: function (cell, value) {
				console.log('celda:');
				console.log(cell);

		        var re = new RegExp( window.validaciones[cell.column].split('#')[0]);
			    
			    console.log('valor');
			    console.log(value);
			    
			    //console.log('mensaje: ');
			    //console.log(String("mensaje_"+window.validaciones[cell.column].split('#')[1]));
			    //console.log( localStorage[String("mensaje_"+window.validaciones[cell.column].split('#')[1]) ]);
			    
			    if( value.match(re) === null ){
					return { result: false, message: localStorage[ String("mensaje_"+window.validaciones[cell.column].split('#')[1] ) ] };
				}else{
					console.log('id_atributo: '+localStorage['id_atributo_'+cell.column] );
					console.log('id_registro: '+localStorage['id_registro_'+cell.row]);
					actualizarCelda(localStorage['id_atributo_'+cell.column],localStorage['id_registro_'+cell.row],value);
				}
		        return true;
		    },
		});
	}
	//console.log('datos_fila_nueva:');
	//console.log(window.datos_fila_nueva);
	//console.log('tipos_fila_nueva:');
	//console.log(window.tipos_fila_nueva);
	//console.log('columnas:');
	//console.log(window.columnas_grid);
	//console.log('Validaciones:');
	//console.log(window.validaciones);
	//crea el html de la grid
	var tabla = '<div class="row-fluid" style="margin:0.2em;">\
		            <div style="margin: 0.3em; float:left;">\
		                <input id="addrowbutton" type="button" value="'+localStorage.add_fila+'" />\
		            </div>\
		            <div style="margin: 0.3em; float:left;">\
		                <input id="deleterowbutton" type="button" value="'+localStorage.delete_fila+'" />\
		            </div>\
		            <div style="margin: 0.3em; float:left;">\
		                <input id="terminar" type="button" value="'+localStorage.terminar+'" />\
		            </div>\
	            </div>\
				<div class="row-fluid" id="jqxWidget">\
			        <div id="jqxgrid"></div>\
			    </div>';
	$('#tabla_grid').html(tabla);

	$("#terminar").jqxButton({ theme: 'bootstrap' });
	$('#terminar').on('click',terminar);
	//fuente de datos
	var source ={
        localdata: [window.datos_fila_nueva],
        datatype: "local",
        updaterow: function (rowid, rowdata, commit) {
            commit(true);
        },
        addrow: function (rowid, rowdata, position, commit) {
            console.log('Adicionando fila: ');
            console.log(rowid);
            //crea el primer registro
			crearRegistro(localStorage.id_base_datos,rowid);
            commit(true);
        },
        deleterow: function (rowid, commit) {
			console.log('Borrando la fila');
            console.log(rowid);
            console.log(commit);
            commit(true);
        },
        datafields: window.tipos_fila_nueva,
    };

    var dataAdapter = new $.jqx.dataAdapter(source);
    // initialize jqxGrid
    $("#jqxgrid").jqxGrid({
        width: window.width_grid,
        height: window.height_grid,
        source: dataAdapter,
        theme: 'bootstrap',
        editable: true,
        sortable: true,
        selectionmode: 'singlerow',
        columns: window.columnas_grid,
    });
	// Boton para crear nueva fila
    $("#addrowbutton").jqxButton({ theme: 'bootstrap' });
    $("#addrowbutton").on('click', function () {
        var commit = $("#jqxgrid").jqxGrid('addrow', null, getFilaNueva());
    });
    //Boton para eliminar fila n
	$("#deleterowbutton").jqxButton({ theme: 'bootstrap' });
    $("#deleterowbutton").on('click', function(){
        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
        if( confirm(localStorage.confirm_delete) ){
	        if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
	            var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
	            var commit = $("#jqxgrid").jqxGrid('deleterow', id);
	        }
        }
    });
}
//funcion que termina 
function terminar(evento){
	document.location.href=localStorage.url_base_app_dominio;
}