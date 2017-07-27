<?php

global $user_array;
global $current_traslado;
if(permitido($user_array['person_id'],$_GET['mod'])){
//inventario : idea , referencia : scout , numero : serie
$buscando=$_GET['inv_id'];

foreach($current_traslado['articulos'] as $sku=>$inf){


foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

if($val==$buscando){

unset($current_traslado['articulos'][$sku][$serial][$r]);
if(count($current_traslado['articulos'][$sku][$serial])<=0){ unset($current_traslado['articulos'][$sku][$serial]);}
if(count($current_traslado['articulos'][$sku])<=0){ unset($current_traslado['articulos'][$sku]);}

}


}
}

}


load_process("traslados","update_screen");
}

?>
