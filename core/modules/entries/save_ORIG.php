<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){
$rid=$_GET['req_id'];
$datos=$_POST;

$rq=array(
'state'=>'Ingresado a Bodega'
);

update_mysql('requisitions',$rq,"requisitionId=$rid");

for($x=1;$x<$datos['cuantos'];$x++){

$trans_items=$datos['item_id-'.$x];
$serial=$datos['serial-'.$x];
$status="Ingresado a Bodega Principal";
$state="Disponible";

$inve=array(
'trans_items'=>$trans_items,
'trans_comment'=>$status,
'trans_inventory'=>1,
'serialNumber'=>$serial,
'state'=>$state,
'requisitionId'=>$rid,
'trans_date'=>date('Y-m-d H:i:s'),
'trans_user'=>$user_array['person_id'],
'location_id'=>'1'

);

$d=insert_mysql('inventory',$inve);
log_me($d['query']);
}

?>

<script>
alert('Informacion Guardada');
window.location.href = '?mod=entries&proc=main';
</script>

<?php

}
load_template('partial','footer');

?>
