<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$contenido=select_mysql("*","sales_items",base64_decode($_GET['string']));

header("Content-type: ".$contenido['result'][0]["contrato_type"]);
header('Content-Disposition: attachment; filename=\''.$contenido['result'][0]["contrato_extension"].'\'');
header('Pragma: no-cache');
echo $contenido['result'][0]["contrato"];

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
