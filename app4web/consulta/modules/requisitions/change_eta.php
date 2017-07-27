<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['eta'];

$current_requisition_array['eta']=$item_id;


load_process("requisitions","reload_sale");
}

?>
