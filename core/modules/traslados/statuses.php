<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
//echo table_pagination('items','deleted=0',$actual=false,$intervalo=500);


?>
<script>

</script>
<div class="modal fade hidden-print" id="modal_nuevo"></div>
	
<div id="toolbar_helper">Mostrando 
<select id="state" name="state">
<option value="" selected> - Todos - </option>
<option value="Solicitado" >Iniciado</option>
<option value="Cerrado" >Cerrado</option>
<option value="Enviado" >Enviado</option>
<option value="Recibido" >Recibido</option>
<option value="Completado" >Completado</option>

</select>
</div>


<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>ID Interno</th>
<th># de Traslado</th>
<th>Estado</th>
<th></th>
</tr>
</thead>
<tbody>

</tbody>
</table>


<script type="text/javascript" charset="utf-8">


$(document).ready(function() {
var table =   $('#example').DataTable( {

        "ajax": "?mod=traslados&proc=list",
	
    } );

    $('#state').change( function() {
	var valor=$('#state').val();
	var nueva="?mod=traslados&proc=list&category=" + valor;
	table.ajax.url(nueva).load();

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
