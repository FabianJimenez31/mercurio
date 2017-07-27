<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
global $application_config;

$marcas=select_mysql("*","geeksify_marcas","status=1");

?>

<div style="opacity: 0.8;z-index:999999999;background-color:#000000;color:#FFFFFF;position:fixed;top:0;left:0;right:0;bottom:0;display:none;" id="subiendo_archivo">
<br/><br/><br/><br/><br/><br/><br/>
<center><b>Procesando solicitud...<br/>
Espere un momento por favor</b>
</center>
</div>


Seleccione la Marca <select onchange="javascript: update_model(this.value);">
<option value="-1">Marca del Dispositivo a Recibir</option>
<?php

foreach ($marcas['result'] as $m){

echo "<option value=\"".$m['marcas_id']."\">".$m['valor']."</option>";

}

?>

</select>

<div id="modelo">
</div>

<script>
function update_model(marca){
document.getElementById("subiendo_archivo").style.display="block";
$.post( "?mod=geeksify_receive&proc=reload_model", { model: marca }, function( data ) {

$("#modelo").html(data);
document.getElementById("subiendo_archivo").style.display="none";
});



}


function update_form(marca){
document.getElementById("subiendo_archivo").style.display="block";
$.post( "?mod=geeksify_receive&proc=reload_forma", { model: marca }, function( data ) {

$("#calificar").html(data);
document.getElementById("subiendo_archivo").style.display="none";
});



}

function cotizar_form(){
document.getElementById("subiendo_archivo").style.display="block";
$.post( "?mod=geeksify_receive&proc=cotiza", $( "#item_form" ).serialize(), function( data ) {

$("#resultado").html(data);
document.getElementById("subiendo_archivo").style.display="none";
});

return false;

}

function completar_form(){
document.getElementById("subiendo_archivo").style.display="block";
$.post( "?mod=geeksify_receive&proc=termina", $( "#n_form2" ).serialize(), function( data ) {

$("#end_aqui").html(data);
document.getElementById("subiendo_archivo").style.display="none";
});

return false;

}
</script>

<?php
load_template('partial','footer');}else{
?>
<script>
window.location.href="?";
</script>
<?php

}

?>
