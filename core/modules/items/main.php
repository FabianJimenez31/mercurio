<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<script>

   function checkboxes()
      {
       var inputElems = $('[name="selected_item[]"]:checked').length;



	if(inputElems==1){ $( "#edit" ).removeClass( "disabled" ); $( "#delete" ).removeClass( "disabled" ); }
	if(inputElems>1){$( "#delete" ).removeClass( "disabled" ); $( "#edit" ).addClass( "disabled" );}
	if(inputElems<1){$( "#delete" ).addClass( "disabled" ); $( "#edit" ).addClass( "disabled" );}


     }

function borrar(){






}



</script>
<div class="modal fade hidden-print" id="modal_nuevo"></div>
		<div class="row">
			<div class="col-md-12 center" style="text-align: right;">					
				<div class="btn-group  ">
								 
					
						<a href="?mod=items&proc=new" class="btn btn-medium btn-primary" title="Nuevo Artículo"><i class="fa fa-plus   hidden-lg fa fa-2x tip-bottom" data-original-title="Nuevo Artículo"></i> <span class="visible-lg" >Nuevo Artículo</span></a>
					
					<a href="?mod=items&proc=import_file" class="btn hidden-xs btn-medium btn-primary " title="Importar de Excel"><i class="fa fa-upload   hidden-lg fa fa-2x tip-bottom" data-original-title="Importar de Excel"></i><span class="visible-lg">Importar de Excel</span></a>		
			<a href="?mod=items&proc=export" class="btn hidden-xs btn-medium btn-primary" title="Exportar a Excel"><i class="fa fa-download   hidden-lg fa fa-2x tip-bottom" data-original-title="Exportar a Excel"></i><span class="visible-lg">Exportar a Excel</span></a>												

					<a  id="delete" class="btn btn-danger disabled" title="Borrar"><i class="fa fa-trash-o hidden-lg fa fa-2x tip-bottom" data-original-title="Borrar"></i><span class="visible-lg">Borrar</span></a>	

					<a  id="edit" class="btn btn-danger disabled" title="Borrar"><i class="fa fa-pencil hidden-lg fa fa-2x tip-bottom" data-original-title="Editar"></i><span class="visible-lg">Editar</span></a>					
				</div>
			 </div>
		</div>
	
<div id="toolbar_helper">
<select id="category" name="category">
<option value="">Seleccione una Categoria</option>
<?php

$categ=select_mysql("DISTINCT category","items");

foreach($categ['result'] as $m){

echo "<option value=\"".$m['category']."\">".$m['category']."</option>";

}

?>

</select>
</div>


<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th></th>
<th>ID Interno</th>
<th>ID de Producto</th>
<th>Nombre</th>
<th>Categoria</th>
<th>Tamaño</th>
<th>Costo</th>
<th>Precio de Venta</th>
<th>Cantidad</th>
<th>Inventario</th>
<th></th>
</tr>
</thead>
<form id="items_varios">
<tbody>

</tbody>
</form>
</table>


<script type="text/javascript" charset="utf-8">


$(document).ready(function() {
var table =   $('#example').DataTable( {

        "ajax": "?mod=items&proc=list",
	
    } );

    $('#category').change( function() {
	var valor=$('#category').val();
	var nueva="?mod=items&proc=list&category=" + valor;
	table.ajax.url(nueva).load();

    } );

    $('#delete').click( function() {


var inputElemsCount = $('[name="selected_item[]"]:checked').length;
var inputElemsValues = $('[name="selected_item[]"]:checked').serialize();

var r = confirm("¿Esta seguro de Eliminar los ( " + inputElemsCount + " ) elementos seleccionados?");

if(r == true){

$.post( "?mod=items&proc=delete", inputElemsValues , function( data ) {
alert("Eliminados");
reload_table();
} );



}

    } );



    $('#edit').click( function() {


var inputElemsValues = $('[name="selected_item[]"]:checked').val();
	window.location.href = '?mod=items&proc=edit&item_id=' + inputElemsValues;


    } );



	

	function reload_table(){
		table.ajax.reload();	
	}



} );
		</script>
<?php


}
load_template('partial','footer');

?>
