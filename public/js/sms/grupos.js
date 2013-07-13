//Tipos de campos
/*
string
number
int
float
bool
textbox
dropdownlist
checkbox
datetimeinput
numberinput

*/


$(document).on("ready", inicioGrupos);
//Objeto global con la definicion de los campos 
var arrCampos = {};

/* Estructura arreglo arrCampos
	[
		{ "campo":'producción',
		  "tipo": 1,
		  "validacion": '.*',
		}
	] */
//variable global con los datos de la primera fila que vacios
var datos={};
//tipos de los campos
var tipos={};
//campos con los tipos de input
var columnas={};

//variable global de numero de campos
var numero_campos = 0;
//Funcion que muestra los mensajes de error
function mostrarMensaje(mensaje){
	$("#mensaje-error").css('display','block');
	$("#mensaje-error").append(mensaje+' ');
}
//Funcion que oculta el mensaje de error
function cerrarMensaje(evento){
	$("#mensaje-error").css('display','none');
	
}
//funcion que inicializa la pagina
function inicioGrupos(evento){
	//inializalizo la pagina
	$('#form_campos').css('display','none');
	//Asocio los eventos 
	$('#btn_definir_campos').on('click',mostrarDefinicionCampos);
	$('#btn_mostrar_campos').on('click',mostrarCamposaDefinir);
	$('#cerar_mensaje').on('click',cerrarMensaje);

}
//funcion que muestra la definicion de los campos
function mostrarDefinicionCampos(evento){
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

//funcion que crea el formulario con la definicion de los campos dependiendo el número
function mostrarCamposaDefinir(evento){
	var numero = $('#numero_campos').val();
	if($.isNumeric(numero) && Math.floor(numero) == numero && numero.length>=1 && numero.length <= 2){
		cerrarMensaje();
		window.numero_campos=numero;
		//ocultar boton
		
		$('#numero_campos').attr('disabled','true');
		var tipos="";
		//hacer llamado ajax para traer la lista de tipos de atributos
		$.ajax({
		   type: "POST",
		   url: localStorage.url_base_app_dominio+"/get-tipos",
		   dataType: "html",
		   async: false,
		   success: function(res){	
	          localStorage.opciones_tipos=res;
	       }
		});
		$('#btn_mostrar_campos').off('click',mostrarCamposaDefinir);
		$('#btn_mostrar_campos').attr('value',localStorage.adicionar_campo);
		$('#btn_mostrar_campos').on('click',adicionarCampo);

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
		$('#tipo_campo_1').val(2);
		//evento del boton	
		$('#btn_guardar_definicion').on('click',validarDefinicionCampos);
	}else{
		mostrarMensaje(localStorage.mensaje_error_numero_campos);
		return 0;
	}
}
//adiciona un campo
function adicionarCampo(){
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
//elimina el campo i
function eliminarCampo(i){
	if(confirm(localStorage.mensaje_confirmacion_eliminacion_campo)){
		$('#div_campo_'+i).remove();
		$('#numero_campos').val($('#numero_campos').val()-1);
	}
}

//funcion que valida la definicion de los campos
function validarDefinicionCampos(evento){
	
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
			cerrarMensaje();
			window.arrCampos.push( { "campo":$('#'+'campo_'+i).val(),"tipo":$('#'+'tipo_campo_'+i).val(),"validacion":$('#'+'tipo_campo_'+i)[0][$('#'+'tipo_campo_'+i)[0].selectedIndex].title } );
		}
	}
	$('#seccion_campos').hide();
	$('#btn_mostrar_campos').hide();
	$('#btn_guardar_definicion').hide();
	mostrarGrid();
}

function mostrarGrid(){
	console.log(window.arrCampos);
/*
{ text: 'Edad', datafield: 'edad', columntype: 'numberinput', width: 80, 
          	  validation: function (cell, value) {
          	  		//alert('Validando: '+value);
          	  		return true;
          	  }
          }
*/
	for (c in window.arrCampos){
		window.datos[window.arrCampos[c].campo]='';
		window.tipos.push({name:window.arrCampos[c].campo,type: 'string'});
		window.columnas.push({text:window.arrCampos[c].campo,datafield:window.arrCampos[c].campo, columntype:window.arrCampos[c].tipo });
	}
	console.log('datos:');
	console.log(window.datos);
	console.log('tipos:');
	console.log(window.tipos);

	var tabla = '<div style="margin-left: 10px; float: left;">\
		            <div>\
		                <input id="addrowbutton" type="button" value="Agregar Fila" />\
		            </div>\
		            <div style="margin-top: 10px;">\
		                <input id="deleterowbutton" type="button" value="Borrar fila" />\
		            </div>\
	            </div>\
				<div id="jqxWidget">\
			        <div id="jqxgrid"></div>\
			        <div style="font-size: 12px; font-family: Verdana, Geneva, sans-serif; margin-top: 30px;">\
			            <div id="cellbegineditevent"></div>\
			            <div style="margin-top: 10px;" id="cellendeditevent"></div>\
			       </div>\
			    </div>';
	$('#tabla_grid').html(tabla);

	var source =
    {
        localdata: window.datos,
        datatype: "local",
        updaterow: function (rowid, rowdata, commit) {
            //alert('guardando en el servidor');
            console.log('guardar en el servidor');
            console.log(rowdata);
            commit(true);

        },
        addrow: function (rowid, rowdata, position, commit) {
            //alert('Adicionando fila');
            commit(true);
        },
        deleterow: function (rowid, commit) {
            //alert('Borrando fila');
            commit(true);
        },
        datafields: window.tipos,
        
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // initialize jqxGrid
    $("#jqxgrid").jqxGrid(
    {
        width: 680,
        source: dataAdapter,
        theme: 'bootstrap',
        editable: true,
        sortable: true,
        selectionmode: 'singlerow',
        columns: window.columnas,
    });

    $("#jqxgrid").on('cellbeginedit', function (event) {
        var args = event.args;
        $("#cellbegineditevent").text("Event Type: cellbeginedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
    });
    $("#jqxgrid").on('cellendedit', function (event) {
        var args = event.args;
        $("#cellendeditevent").text("Event Type: cellendedit, Column: " + args.datafield + ", Row: " + (1 + args.rowindex) + ", Value: " + args.value);
    });
    $("#addrowbutton").jqxButton({ theme: 'bootstrap' });
	$("#deleterowbutton").jqxButton({ theme: 'bootstrap' });
	// create new row.
    $("#addrowbutton").on('click', function () {
		var datarow={'celular':'','nombre':'','edad':'','correo':''};
        var commit = $("#jqxgrid").jqxGrid('addrow', null, datarow);
    });
    $("#deleterowbutton").on('click', function () {
        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
        if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
            var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
            var commit = $("#jqxgrid").jqxGrid('deleterow', id);
        }
    });
}