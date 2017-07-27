<?php

global $server;
global $x;

$server[$x]['version']='2.0.3b - Actualizacion adicional para Consignaciones y Datafonos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo consignado_datafonos en sessions';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sessions` LIKE 'consignado_datafonos'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

$server[$x]['status'].=" - Necesita Actualizar";

ejecutar("ALTER TABLE  `".$tt['prefix']."sessions` ADD  `consignado_datafonos` DOUBLE NOT NULL ;
");

}else{
$server[$x]['status'].=" - Actualizado";

}




}








?>
