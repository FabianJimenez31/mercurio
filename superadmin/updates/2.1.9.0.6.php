<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.6 - Agrega precio sin POST';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo real_item_unit_price';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sales_items` LIKE 'real_item_unit_price'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."sales_items add real_item_unit_price decimal(23,10) not null");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}

}








?>
