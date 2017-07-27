<?php
global $user_array;
global $req_error;
global $application_config;

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
$auxiliar=array('count'=>0);
if($application_config['todos_seriales_diferentes_global']=="Y"){

$auxiliar=select_mysql("*","inventory"," serialNumber='$serial'");


}


if($actuales['count']>0 || $auxiliar['count']>0){
$req_error="El Número de Serie '$serial' ya Existe, Por favor verifique la información";
}else{


if($_POST['serial_number']!='' && str_replace(array("\n"," ","\t","\r"),"",$_POST['serial_number'])!='' && strlen($_POST['serial_number'])>=1){

$d=insert_mysql('inventory',$inve);

}else{
$req_error="El Número de Serie Introducido: '$serial' es Inválido.";
}





}
load_process('entries','request_form');





}




?>
