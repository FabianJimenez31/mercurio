<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";
session_start();
$_SESSION['requisition']=$current_requisition_array;
session_write_close ();
$line=0;

$requisition_info=array(
'eta'=>$current_requisition_array['eta'],
'comment'=>$current_requisition_array['comment'],
'userCreator'=>$user_array['person_id'],
'state'=>'Solicitud Enviada',
'requisitionNumber'=>$current_requisition_array['req_id'],
'requisitionDate' => date('Y-m-d H:i:s'),
'provider_id'=>$current_requisition_array['customer']

);

$requisition_a=insert_mysql('requisitions',$requisition_info);
$final=$requisition_a['query'];
$r_id=$requisition_a['last_id'];
foreach($current_requisition_array['cart']['items'] as $k=>$i){

$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];

$quantity= (isset($i['quantity'])) ? $i['quantity'] : 1;
$cost=(isset($i['cost'])) ? $i['cost'] : $info['cost_price'];

$item_complete=array(

'item_id'=>$i['item_id'],
'quantity'=>$quantity,
'cost_price'=>$cost,
'requisitionId'=>$r_id

);

insert_mysql('requisitions_items',$item_complete);

$line++;
}

session_start();
unset($_SESSION['requisition']);
unset($current_requisition_array);
session_write_close ();

$current_requisition_array=array();
$actualiza=array('message'=>'Informacion Guardada','message_header'=>'Éxito <br>','success'=>true,'req_id'=>$r_id);


echo json_encode($actualiza);
}

?>
