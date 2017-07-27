<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$cate=select_mysql("*","metas_asignar","id=".$_GET['id']);
$cc=$cate['result'][0];

$final=json_encode(

array(

'meta'=>$cc['meta'],
'categoria_id'=>$cc['categoria_id'],
'ids'=>$cc['id'],

)

);

echo $final;

}

?>
