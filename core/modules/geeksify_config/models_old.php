<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$m=select_mysql("*","geeksify_marcas","marcas_id=".$_GET['id']);

?>


<h1><?php echo $m['result'][0]['valor']; ?></h1>
<br/>Nuevo Modelo: <input type="text" id="n_marca">  
<br/>Valor Tipo A: <input type="text" id="a_marca">  
<br/>Valor Tipo B: <input type="text" id="b_marca">  
<br/>Valor Tipo C: <input type="text" id="c_marca">  
<br/>Valor Tipo D: <input type="text" id="d_marca">  
<br/>
<a onclick="javascript: new_modelo();">Crear</a>

<br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>Modelo</th>
<th>Valor Tipo A</th>
<th>Valor Tipo B</th>
<th>Valor Tipo C</th>
<th>Valor Tipo D</th>
<th>Eliminar</th>
</tr>
</thead>
<tbody id="modelos">

</tbody>
</form>
</table>


<script>
function update_modelos(){

$.post( "?mod=geeksify_config&proc=modelos", function( data ) {

$("#modelos").html(data);

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
