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
<th>Fecha / Hora</th>
<th>Usuario</th>
<th>IP de Consulta</th>
<th>Módulo</th>
<th>Proceso</th>
<th>Variables POST</th>
<th>Variables GET</th>
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

        "ajax": "?mod=logger&proc=list",
	
    } );



   


} );
		</script>
<?php


}
load_template('partial','footer');

?>
