<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$id=$_POST['customer_id'];

$current_sale_array['customer']=$id;

load_process("sales","reload_sale");
}

?>
