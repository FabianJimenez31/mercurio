<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['modes'];

$current_sale_array['is_manual']=($item_id=='yes') ? true:false;
$current_sale_array['show_manual']=($item_id=='yes') ? 'block':'none';


load_process("sales","reload_sale");
}

?>
