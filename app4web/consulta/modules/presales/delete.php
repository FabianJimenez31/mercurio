<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$line=$_POST['line'];

unset($current_presale_array['cart']['items'][$line]);

load_process("presales","reload_sale");
}

?>
