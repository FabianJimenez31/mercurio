<?php

global $user_array;
global $current_presale_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['presale']=$current_presale_array;
session_write_close ();
$line=0;

$presale_info=array(

'customer_id'=>$current_presale_array['customer'],
'employee_id'=>$user_array['person_id'],
'suspended'=>'1',
'location_id'=>1

);

$presale_a=insert_mysql('presales',$presale_info);
$final=$presale_a['query'];
foreach($current_presale_array['cart']['items'] as $k=>$i){
if(substr($i['item_id'],0,1)=='K'){

$ik_id=str_replace('K','',$i['item_id']);
$item_kit_info=select_mysql("*","item_kits","item_kit_id=".$ik_id);

$sql=insert_mysql('presales_item_kits',array('presale_id'=>$presale_a['last_id'],'item_kit_id'=>$ik_id,'quantity_purchased'=>1,'item_kit_unit_price'=>$item_kit_info['result'][0]['unit_price'],'description'=>$item_kit_info['result'][0]['description']));
$final.="=>".$sql['query'];
}else{
$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];

$promo_inicio=strtotime($info['start_date']." 00:00:00");
$promo_final=strtotime($info['end_date']." 23:59:59");

$current_price=($promo_final>0 && $promo_inicio>0 && ($promo_final-$promo_inicio)>0) ? $info['promo_price'] : $info['unit_price'];


$sql=insert_mysql('presales_items',array('presale_id'=>$presale_a['last_id'],'item_id'=>$i['item_id'],'quantity_purchased'=>1,'item_unit_price'=>$current_price,'description'=>$info['description']));

$final.="=>".$sql['query'];

}
$line++;
}

session_start();
unset($_SESSION['presale']);
unset($current_presale_array);
session_write_close ();

$current_presale_array=array();
$actualiza=array('message'=>'Venta enviada a Caja<br>','message_header'=>'Éxito <br>','success'=>true);


echo json_encode($actualiza);
}

?>
