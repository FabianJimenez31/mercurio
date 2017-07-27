<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$mm=select_mysql("*","geeksify_modelos","status=1 and marca_id=".$_GET['model']."");

foreach($mm['result'] as $f){

echo "<tr>
<td>".$f['valor']."</td>
<td> ".$f['tipo_a']."</td>
<td> ".$f['tipo_b']."</td>
<td> ".$f['tipo_c']."</td>
<td> ".$f['tipo_d']."</td>
<td> <a onclick=\"javascript: delete_modelo(".$f['modelos_id'].");\">Eliminar</a></td>
</tr>";

}
}

?>
