<?php

global $server;
global $x;

$server[$x]['version']='2.0.4b - Actualizacion adicional de Módulo Contable';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo i_credito en cuentascontables';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."cuentascontables` LIKE 'i_credito'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."cuentascontables` ADD  `i_credito` VARCHAR( 100 ) NOT NULL ,
ADD  `i_debito` VARCHAR( 100 ) NOT NULL ;");
$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}




}








?>
