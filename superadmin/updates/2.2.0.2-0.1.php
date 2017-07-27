<?php

global $server;
global $x;

$server[$x]['version']='2.2.0.2-0.1 - Nuevo Renglon para Invoice';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo config_invoice_second_title';


$result = ejecutar("SELECT * FROM `".$tt['prefix']."app_config` where `key` = 'config_invoice_second_title'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."app_config (`key`,`value`) values ('config_invoice_second_title','')");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}

?>
