<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['line'];
$new_cost=$_POST['cost'];


$current_requisition_array['cart']['items'][$item_id]['cost']=$new_cost;


load_process("requisitions","reload_sale");
}

?>
