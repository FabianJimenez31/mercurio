<?php

global $user_array;
global $current_requisition_array;



if(permitido($user_array['person_id'],$_GET['mod'])){

$id=$_POST['customer_id'];

$current_requisition_array['customer']=$id;
log_me(grab_dump($current_requisition_array));

load_process("requisitions","reload_sale");
}

?>
