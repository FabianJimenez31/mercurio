<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['line'];
$new_cost=$_POST['quantity'];

ejecutar("DELETE FROM  ".DBPREFIX."temporal_contratos  where unique_id='".$new_cost."'");

unset($current_sale_array['cart']['items'][$item_id]['temp_contrato']);


load_process("sales","reload_sale");
}

?>
