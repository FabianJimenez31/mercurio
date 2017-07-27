<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
?>


<h1>Marcas</h1>
Nueva Marca: <input type="text" id="n_marca"> <a onclick="javascript: new_marca();">Crear</a>
<br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>Marca</th>
<th>Ver Modelos</th>
<th>Eliminar</th>
</tr>
</thead>
<tbody id="marcas">

</tbody>
</form>
</table>


<script>
function update_marcas(){

$.post( "?mod=geeksify_config&proc=marcas", function( data ) {

$("#marcas").html(data);

});

}

function new_marca(){

var valores=$("#n_marca").val();
$.post( "?mod=geeksify_config&proc=n_marca", { nuevo:valores } , function( data ) {

update_marcas();

});

}

function delete_marca(ides){

$.post( "?mod=geeksify_config&proc=delete_marca", { nuevo:ides } , function( data ) {

update_marcas();

});

}

update_marcas();
</script>

</script>




<?php
load_template('partial','footer');
}

?>
