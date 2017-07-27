<?php

global $user_array;
global $current_traslado;
if(permitido($user_array['person_id'],$_GET['mod'])){
//inventario : idea , referencia : scout , numero : serie
$item_id=$_POST['refo'];

$current_traslado['articulos'][$_POST['referencia']][$_POST['numero']][$_POST['inventario']]=$_POST['inventario'];


load_process("traslados","update_screen");
}

?>
