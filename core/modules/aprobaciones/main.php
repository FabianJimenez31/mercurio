<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<div class="modal fade hidden-print" id="modal_nuevo"></div>

	

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>SKU</th>
<th>Numero de Contrato / Serial</th>
<th>Teléfono</th>
<th>Factura</th>
<th>Cliente</th>
<th>Vendedor</th>
<th>Contrato Subido</th>
<th>Fecha de Venta</th>
<th></th>
</tr>
</thead>
<form id="items_varios">
<tbody>

</tbody>
</form>
</table>


<script type="text/javascript" charset="utf-8">


var table =   $('#example').DataTable( {

        "ajax": "?mod=aprobaciones&proc=list"
	
    } );


function aprobar_item(item_id, line , sale_id ){

var uurl = "?mod=aprobaciones&proc=delete&i=" + item_id + "&l=" + line + "&s=" + sale_id ;
$.post( uurl, function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
table.ajax.reload();
});


}

function rechazar_item(item_id, line , sale_id ){
var razon = prompt("Por Favor Ingrese el Motivo del Rechazo", "No Especificada");

var uurl = "?mod=aprobaciones&proc=delete2&i=" + item_id + "&l=" + line + "&s=" + sale_id + "&r=" + razon ;
$.post( uurl, function( data ) {
gritter("\u00c9xito",data,'gritter-item-success');
table.ajax.reload();
});


}
   



		</script>
<?php


}
load_template('partial','footer');

?>
