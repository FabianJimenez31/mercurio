<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$mm=select_mysql("*","geeksify_marcas",'status=1');

foreach($mm['result'] as $f){

echo "<tr><td>".$f['valor']."</td><td> <a href=\"?mod=geeksify_config&proc=modelos&id=".$f['marcas_id']."\">Ver Modelos</a></td><td> <a onclick=\"javascript: delete_marca(".$f['marcas_id'].");\">Eliminar</a></td></tr>";

}
}

?>
