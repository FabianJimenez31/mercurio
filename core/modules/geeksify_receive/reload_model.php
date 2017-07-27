<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

if($_POST['model']!="-1"){

$modelos=select_mysql("*","geeksify_modelos","status=1 and marca_id=".$_POST['model']);

?>

<br/>Seleccione el Modelo <select onchange="javascript: update_form(this.value);">
<option value="-1">Modelo del Dispositivo a Recibir</option>
<?php

foreach($modelos['result'] as $i){

echo "<option value=\"".$i['modelos_id']."\">".$i['valor']."</option>";

}

?>

</select>

<div id="calificar">
</div>


<?php
}else{
echo "Seleccione una Marca";
}
}

?>
