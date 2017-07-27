<?php
global $user_array;
global $current_sale_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){

$presale_id=$_GET['presale_id'];

foreach($current_sale_array as $k=>$v){

unset($current_sale_array[$k]);

}



$presale_info=select_mysql("*","presales","presale_id=".$presale_id);

$new_sale=array();
$new_sale['customer']=$presale_info['result'][0]['customer_id'];
$new_sale['presale_id']=$presale_id;
$new_sale['salesman']=$presale_info['result'][0]['employee_id'];

$items=select_mysql("*",'presales_items',"presale_id=".$presale_id);

foreach($items['result'] as $i){

$new_sale['cart']['items'][]=array('item_id'=>$i['item_id'],'quantity'=>1);


}

$kits=select_mysql("*",'presales_item_kits',"presale_id=".$presale_id);

foreach($kits['result'] as $i){

$new_sale['cart']['items'][]=array('item_id'=>"K".$i['item_kit_id'],'quantity'=>1);


}

$current_sale_array=$new_sale;

session_start();
$_SESSION['sale']=$current_sale_array;
session_write_close ();


?>

<script>
window.location.href = '?mod=sales&proc=main';
</script>

<?php

}
load_template('partial','footer');

?>
