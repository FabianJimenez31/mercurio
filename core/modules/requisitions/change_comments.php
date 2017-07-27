<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['comment'];

$current_requisition_array['comment']=$item_id;


load_process("requisitions","reload_sale");
}

?>
