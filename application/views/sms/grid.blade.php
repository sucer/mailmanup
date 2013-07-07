@layout('template.base')
@section('titulo')
<title>{{ __('grupos.titulo-grupos')}}</title>
@endsection
@section('css')
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
	$(document).on("ready", inicioGrid);
	function inicioGrid(evento){
		var data = {};
		var row={};
		row['celular']='3168765086';
		row['nombre']='Andres Sucerquia';
		row['edad']='31';
		row['correo']='andressucer@gmail.com';
		data[0] = row;
		var source =
	    {
	        localdata: data,
	        datatype: "local",
	        updaterow: function (rowid, rowdata, commit) {
	            alert('guardando en el servidor');
	            console.log('guardar en el servidor');
	            console.log(rowdata);
	            commit(true);

	        },
	        addrow: function (rowid, rowdata, position, commit) {
	            alert('Adicionando fila');
	            commit(true);
	        },
	        deleterow: function (rowid, commit) {
	            alert('Borrando fila');
	            commit(true);
	        },
	        datafields:
	        [
	            { name: 'celular', type: 'string' },
	            { name: 'nombre', type: 'string' },
	            { name: 'edad', type: 'number' },
	            { name: 'correo', type: 'string' },
	        ]
	    };
	    var dataAdapter = new $.jqx.dataAdapter(source);
	    // initialize jqxGrid
	    $("#jqxgrid").jqxGrid(
	    {
	        width: 700,
	        height: 400,
	        source: dataAdapter,
	        theme: 'bootstrap',
	        editable: true,
	        selectionmode: 'multiplecellsadvanced',
	        columns: [
	          { text: 'Celular', datafield: 'celular', width: 100, columntype: 'textbox' },
	          { text: 'Nombre', datafield: 'nombre', columntype: 'textbox', width: 200 },
	          { text: 'Edad', datafield: 'edad', columntype: 'numberinput', width: 80, 
	          	  validation: function (cell, value) {
	          	  		alert('Validando');
	          	  }
	          },
	          { text: 'Correo', datafield: 'correo', cellsalign: 'right',  width: 200, columntype: 'textbox' },
	        ]
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
			var datarow={};
			datarow['celular']='3168765086';
			datarow['nombre']='Andres Sucerquia';
			datarow['edad']='31';
			datarow['correo']='andressucer@gmail.com';
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

</script>
@endsection


@section('contenido')
	<h2>
	{{__('grupos.creacion-grupos')}}
	</h2>
	<div class="row-fluid">
		<div class="span10">
			<div id="jqxWidget">
			        <div id="jqxgrid"></div>
			        <div style="font-size: 12px; font-family: Verdana, Geneva, sans-serif; margin-top: 30px;">
			            <div id="cellbegineditevent"></div>
			            <div style="margin-top: 10px;" id="cellendeditevent"></div>
			       </div>
			       
			       <div style="margin-left: 10px; float: left;">
			            <div>
			                <input id="addrowbutton" type="button" value="Agregar Fila" />
			            </div>
			            <div style="margin-top: 10px;">
			                <input id="deleterowbutton" type="button" value="Borrar Fila" />
			            </div>
		            </div>
			    </div>

		</div>
	</div>
@endsection