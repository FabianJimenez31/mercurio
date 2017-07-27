<?php
global $user_array;
global $req_error;
if(permitido($user_array['person_id'],$_GET['mod'])){


$trans_items=$_POST['item_id'];
$serial=$_POST['serial_number'];
$costo=$_POST['cost'];
$status="Ingresado a Bodega Principal";
$state="Disponible";

$inve=array(
'trans_items'=>$trans_items,
'trans_comment'=>$status,
'trans_inventory'=>1,
'serialNumber'=>$serial,
'state'=>$state,
'requisitionId'=>$_POST['requisition_id'],
'trans_date'=>date('Y-m-d H:i:s'),
'requisition_fecha'=>date('Y-m-d H:i:s'),
'trans_user'=>$user_array['person_id'],
'location_id'=>'1',
'cost_price'=>$costo

);

$actuales=select_mysql("*","inventory"," serialNumber='$serial' and trans_items=".$trans_items);
if($actuales['count']>0){
$req_error="El Número de Serie '$serial' ya Existe, Por favor verifique la información";
}else{
$d=insert_mysql('inventory',$inve);
}
load_process('entries','request_form');





}




?>
