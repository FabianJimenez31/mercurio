<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

?>


<h1>Checklist</h1>
<br/>Nuevo Item: <input type="text" id="n_marca">  
<br/>Restar Valor de Cambio: <input type="text" id="a_marca">  
<br/>Cambiar Tipo: <select type="text" id="b_marca">
<option value="0">No Cambiar</option>
<option value="1">Tipo A</option>
<option value="2">Tipo B</option>
<option value="3">Tipo C</option>
<option value="4">Tipo D</option>
</select>

<br/>
<a onclick="javascript: new_pregunta();">Crear</a>

<br/>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="example" width="100%">
<thead>
<tr>
<th>Item</th>
<th>Restar Valor de Cambio</th>
<th>Cambiar Tipo</th>
<th>Eliminar</th>
</tr>
</thead>
<tbody id="preguntas">

</tbody>
</form>
</table>


<script>
function update_preguntas(){

$.post( "?mod=geeksify_cue&proc=preguntas", function( data ) {

$("#preguntas").html(data);

});

}

function new_pregunta(){

var valores=$("#n_marca").val();
var t_a=$("#a_marca").val();
var t_b=$("#b_marca").val();

$.post( "?mod=geeksify_cue&proc=n_pregunta", { nuevo:valores , ti_a: t_a, ti_b: t_b } , function( data ) {

update_preguntas();

});

}

function delete_pregunta(ides){

$.post( "?mod=geeksify_cue&proc=delete_pregunta", { nuevo:ides } , function( data ) {

update_preguntas();

});

}

update_preguntas();
</script>

</script>




<?php
load_template('partial','footer');
}

?>
