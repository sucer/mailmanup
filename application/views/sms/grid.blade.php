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
            var firstNames =
            [
                "Andrew", "Nancy", "Shelley", "Regina", "Yoshi", "Antoni", "Mayumi", "Ian", "Peter", "Lars", "Petra", "Martin", "Sven", "Elio", "Beate", "Cheryl", "Michael", "Guylene"
            ];
            var lastNames =
            [
                "Fuller", "Davolio", "Burke", "Murphy", "Nagase", "Saavedra", "Ohno", "Devling", "Wilson", "Peterson", "Winkler", "Bein", "Petersen", "Rossi", "Vileid", "Saylor", "Bjorn", "Nodier"
            ];
            var productNames =
            [
                "Black Tea", "Green Tea", "Caffe Espresso", "Doubleshot Espresso", "Caffe Latte", "White Chocolate Mocha", "Cramel Latte", "Caffe Americano", "Cappuccino", "Espresso Truffle", "Espresso con Panna", "Peppermint Mocha Twist"
            ];
            var priceValues =
            [
                "2.25", "1.5", "3.0", "3.3", "4.5", "3.6", "3.8", "2.5", "5.0", "1.75", "3.25", "4.0"
            ];
            var generaterow = function (i) {
                var row = {};
                var productindex = Math.floor(Math.random() * productNames.length);
                var price = parseFloat(priceValues[productindex]);
                var quantity = 1 + Math.round(Math.random() * 10);
                row["firstname"] = firstNames[Math.floor(Math.random() * firstNames.length)];
                row["lastname"] = lastNames[Math.floor(Math.random() * lastNames.length)];
                row["productname"] = productNames[productindex];
                row["price"] = price;
                row["quantity"] = quantity;
                row["total"] = price * quantity;
                return row;
            }
            for (var i = 0; i < 10; i++) {
                var row = generaterow(i);
                data[i] = row;
            }
            var source =
            {
                localdata: data,
                datatype: "local",
                datafields:
                [
                    { name: 'firstname', type: 'string' },
                    { name: 'lastname', type: 'string' },
                    { name: 'productname', type: 'string' },
                    { name: 'quantity', type: 'number' },
                    { name: 'price', type: 'number' },
                    { name: 'total', type: 'number' }
                ],
                addrow: function (rowid, rowdata, position, commit) {
                    // synchronize with the server - send insert command
                    // call commit with parameter true if the synchronization with the server is successful 
                    //and with parameter false if the synchronization failed.
                    // you can pass additional argument to the commit callback which represents the new ID if it is generated from a DB.
                    commit(true);
                },
                deleterow: function (rowid, commit) {
                    // synchronize with the server - send delete command
                    // call commit with parameter true if the synchronization with the server is successful 
                    //and with parameter false if the synchronization failed.
                    commit(true);
                },
                updaterow: function (rowid, newdata, commit) {
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failed.
                    commit(true);
                }
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {
                width: 500,
                height: 350,
                source: dataAdapter,
                theme: 'bootstrap',
                columns: [
                  { text: 'First Name', datafield: 'firstname', width: 100 },
                  { text: 'Last Name', datafield: 'lastname', width: 100 },
                  { text: 'Product', datafield: 'productname', width: 180 },
                  { text: 'Quantity', datafield: 'quantity', width: 80, cellsalign: 'right' },
                  { text: 'Unit Price', datafield: 'price', width: 90, cellsalign: 'right', cellsformat: 'c2' },
                  { text: 'Total', datafield: 'total', width: 100, cellsalign: 'right', cellsformat: 'c2' }
                ]
            });
            $("#addrowbutton").jqxButton({ theme: 'bootstrap' });
            $("#addmultiplerowsbutton").jqxButton({ theme: 'bootstrap' });
            $("#deleterowbutton").jqxButton({ theme: 'bootstrap' });
            $("#updaterowbutton").jqxButton({ theme: 'bootstrap' });
            // update row.
            $("#updaterowbutton").on('click', function () {
                var datarow = generaterow();
                var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                    var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                    var commit = $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                    $("#jqxgrid").jqxGrid('ensurerowvisible', selectedrowindex);
                }
            });
            // create new row.
            $("#addrowbutton").on('click', function () {
                var datarow = generaterow();
                var commit = $("#jqxgrid").jqxGrid('addrow', null, datarow);
            });
            // create new rows.
            $("#addmultiplerowsbutton").on('click', function () {
                $("#jqxgrid").jqxGrid('beginupdate');
                for (var i = 0; i < 10; i++) {
                    var datarow = generaterow();
                    var commit = $("#jqxgrid").jqxGrid('addrow', null, datarow);
                }
                $("#jqxgrid").jqxGrid('endupdate');
            });
            // delete row.
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
			
			<div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
		        <div style="float: left;" id="jqxgrid">
		        </div>
		        <div style="margin-left: 10px; float: left;">
            <div>
                <input id="addrowbutton" type="button" value="Add New Row" />
            </div>
            <div style="margin-top: 10px;">
                <input id="addmultiplerowsbutton" type="button" value="Add Multiple New Rows" />
            </div>
            <div style="margin-top: 10px;">
                <input id="deleterowbutton" type="button" value="Delete Selected Row" />
            </div>
            <div style="margin-top: 10px;">
                <input id="updaterowbutton" type="button" value="Update Selected Row" />
            </div>
        	</div>
   	 		</div>


		</div>
	</div>
@endsection