<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$line=$_POST['line'];

unset($current_sale_array['cart']['items'][$line]);

load_process("sales","reload_sale");
}

?>
