<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['eta'];

$current_sale_array['eta']=$item_id;


load_process("sales","reload_sale");
}

?>
