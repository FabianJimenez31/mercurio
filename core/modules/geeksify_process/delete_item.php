<?php
global $user_array;
global $req_error;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){


$trans_id=$_POST['serial_id'];
$requisitionId=$_POST['ver_trans'];

$existe=select_mysql("*","inventory"," requisitionId='$requisitionId' and trans_id=".$trans_id);

if($existe['count']>0 && $requisitionId>=1 && $trans_id>=1 ){

$data=delete_mysql("inventory"," requisitionId='$requisitionId' and trans_id=".$trans_id);

}else{

$req_error="Error en la Solicitud. El registro ya fue eliminado previamente.";

}


load_process('entries','request_form');





}




?>
