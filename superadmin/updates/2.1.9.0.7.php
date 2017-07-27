<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.7 - Agrega Razon de Rechazo';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo razon_rechazo';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sales_items` LIKE 'razon_rechazo'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."sales_items add razon_rechazo TEXT");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}

}








?>
