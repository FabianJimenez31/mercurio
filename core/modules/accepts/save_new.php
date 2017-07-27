<?php

global $user_array;
global $current_requisition_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
$body="";

$line=0;

$requisition_info=array(
'eta'=>$_POST['eta'],
'comment'=>$_POST['comment'],
'prev_id'=>$_POST['parent'],
'main_id'=>$_POST['main_id'],
'userCreator'=>$user_array['person_id'],
'state'=>'Solicitud Enviada',
'requisitionNumber'=>$_POST['req_id'],
'requisitionDate' => date('Y-m-d H:i:s')

);

$requisition_a=insert_mysql('requisitions',$requisition_info);
$final=$requisition_a['query'];
$r_id=$requisition_a['last_id'];

$update_parent=update_mysql("requisitions",array('force_close'=>1),"requisitionId='".$_POST['parent']."'");

$items_now=select_mysql("*","requisitions_items","requisitionId='".$_POST['parent']."' and (quantity-quantity_accepts)>0");

foreach($items_now['result'] as $i){

$item_info=select_mysql("*","items","item_id=".$i['item_id']);

$info=$item_info['result']['0'];

$quantity= (($i['quantity']-$i['quantity_accepts'])>0) ? $i['quantity']-$i['quantity_accepts'] : 1;
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


echo "<script>alert('Exito!!\\n Informacion Guardada con ID $r_id');</script><meta http-equiv=\"refresh\" content=\"0;url=?mod=accepts&proc=main\" />";

}

?>
