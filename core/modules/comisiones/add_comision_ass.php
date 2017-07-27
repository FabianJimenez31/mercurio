<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$cate=select_mysql("*","esquema_asignar","id=".$_GET['id']);
$cc=$cate['result'][0];

$final=json_encode(

array(

'comision'=>$cc['comision'],
'es_porcentaje'=>$cc['es_porcentaje'],
'rango_id'=>$cc['rango_id'],
'categoria_id'=>$cc['categoria_id'],
'ids'=>$cc['id'],

)

);

echo $final;

}

?>
