<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$contenido=select_mysql("*","sessions","session_id=".$_GET['session_id']);

header("Content-type: " . $contenido['result'][0]["datafono_type"]);
echo $contenido['result'][0]["datafono_content"];

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
