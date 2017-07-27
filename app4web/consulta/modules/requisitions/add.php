<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['item_id'];


$current_requisition_array['cart']['items'][]=array('item_id'=>$item_id,'quantity'=>1);


load_process("requisitions","reload_sale");
}

?>
