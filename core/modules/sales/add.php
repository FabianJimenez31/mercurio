<?php

global $user_array;
global $current_sale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['item_id'];


$current_sale_array['cart']['items'][]=array('item_id'=>$item_id,'quantity'=>1);


load_process("sales","reload_sale");
}

?>
