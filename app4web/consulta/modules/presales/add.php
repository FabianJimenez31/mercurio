<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$item_id=$_POST['item_id'];

if(isset($current_presale_array['cart'])){

$current_presale_array['cart']['items'][]=array('item_id'=>$item_id,'quantity'=>1);

}else{

session_start();

$_SESSION['presale']['vendedor']=$_SESSION['user'];


$_SESSION['presale']['cart']['items'][]=array('item_id'=>$item_id,'quantity'=>1);
$current_presale_array=$_SESSION['presale'];
session_write_close ();

}
load_process("presales","reload_sale");
}

?>
