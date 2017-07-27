<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$cat=array();
$items=select_mysql("*","items","name LIKE '%".$_GET['term']."%' or description LIKE '%".$_GET['term']."%' or item_number LIKE '%".$_GET['term']."%' or product_id LIKE '%".$_GET['term']."%' or item_id LIKE '%".$_GET['term']."%' or color like '%".$_GET['term']."%'",'item_id ASC','10');


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'label'=>utf8_encode($i['name']."( ".$i['category'].",".$i['color']." )"));

}

$seriales=select_mysql("*","inventory","serialNumber like '%".$_GET['term']."%' and state='Disponible'",'trans_items ASC','10');

foreach($seriales['result'] as $s){

$items=select_mysql("*","items","item_id=".$s['trans_items']);


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'label'=>utf8_encode($i['name']."( ".$i['category'].",".$i['color']." )"));

}


}

$item_kits=select_mysql("*","item_kits","name LIKE '%".$_GET['term']."%' or description LIKE '%".$_GET['term']."%' or item_kit_number LIKE '%".$_GET['term']."%' or product_id LIKE '%".$_GET['term']."%' or item_kit_id LIKE '%".$_GET['term']."%' ",'item_kit_id ASC','10');


foreach($item_kits['result'] as $i){

$cat[]=array('value'=>'K'.$i['item_kit_id'],'label'=>utf8_encode($i['name']."( ".$i['category']." )"));

}


echo json_encode($cat);

}


?>
