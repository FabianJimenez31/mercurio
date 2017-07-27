<?php

global $user_array;
global $current_traslado;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['refo'];

$current_traslado['location_id']=$item_id;


load_process("traslados","update_screen");
}

?>
