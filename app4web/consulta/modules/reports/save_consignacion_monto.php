<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){
$efectivo=$_POST['to_be_report'];
$consignado=$_POST['new_value'];
$valido_monto="";
if($consignado>0 && $consignado<$efectivo){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO FALTAN $ ".number_format($efectivo-$consignado,2,',','.')."</span><br/>";
}

if($consignado>0 && $consignado>$efectivo){
$valido_monto="<br/><span style='color:red;'>NO COINCIDE EL MONTO CONSIGNADO SOBRAN $ ".number_format($consignado-$efectivo,2,',','.')."</span><br/>";
}

$f=update_mysql('sessions',array('consignado'=>$_POST['new_value']),'session_id='.$_POST['session_id']);
log_me(grab_dump($f));
echo  "[ ".number_format($consignado,2,',','.')." ] $valido_monto <a onclick=\"javascript:delete_folio_monto('".$_POST['container']."',".$_POST['session_id'].",'$efectivo');\">Eliminar</a>";

}else{

echo "NO TIENE PERMISOS PARA INGRESAR EN ESTE SITIO";

}

?>
