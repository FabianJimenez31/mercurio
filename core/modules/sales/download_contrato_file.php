<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$contenido=select_mysql("*","temporal_contratos",base64_decode($_GET['string']));

header("Content-type: ".$contenido['result'][0]["meta"]);
header('Content-Disposition: attachment; filename=\''.$contenido['result'][0]["name"].'\'');
header('Pragma: no-cache');
echo $contenido['result'][0]["file"];

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
