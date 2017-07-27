<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$w=select_mysql("*","geeksify_envio","envios_id='".$_GET['id']."'");
if($w['result'][0]['status']==1){
update_mysql("geeksify_envio",array('envio_fecha'=>date("Y-m-d H:i:s")),"envios_id='".$_GET['id']."'");
}
$f=update_mysql("geeksify_envio",array('status'=>($w['result'][0]['status']+1)),"envios_id='".$_GET['id']."'");
echo "Espere un momento por favor...    <META http-equiv=\"refresh\" content=\"1;URL=?mod=geeksify_process&proc=main\">";
}

?>

