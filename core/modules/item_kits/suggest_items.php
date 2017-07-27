<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$items=select_mysql("*","items","name LIKE '%".$_GET['term']."%' or description LIKE '%".$_GET['term']."%' or item_number LIKE '%".$_GET['term']."%' or product_id LIKE '%".$_GET['term']."%' or item_id LIKE '%".$_GET['term']."%' or color like '%".$_GET['term']."%'");


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'label'=>$i['name']."( ".$i['category'].",".$i['color']." )");

}

$seriales=select_mysql("*","inventory","serialNumber like '%".$_GET['term']."%' and state='Disponible'");

foreach($seriales['result'] as $s){

$items=select_mysql("*","items","item_id=".$s['trans_items']);


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'label'=>$i['name']."( ".$i['category'].",".$i['color']." )");

}


}

echo json_encode($cat);

}


?>
