<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$rid=$_POST['req_id'];

$rq=array(
'state'=>'Ingresado a Bodega'
);

update_mysql('requisitions',$rq,"requisitionId=$rid");




}


?>
