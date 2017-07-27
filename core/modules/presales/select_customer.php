<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$id=$_POST['customer_id'];

$current_presale_array['customer']=$id;

load_process("presales","reload_sale");
}

?>
