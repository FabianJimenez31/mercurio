<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$line=$_POST['line'];

unset($current_requisition_array['cart']['items'][$line]);

load_process("requisitions","reload_sale");
}

?>
