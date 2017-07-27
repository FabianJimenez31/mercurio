<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){

$f=update_mysql("geeksify_envio",array($_POST['llave']=>$_POST['valor']),"envios_id='".$_POST['registro']."'");
echo " <span style=\"color:green;\">OK</span>";
}

?>

