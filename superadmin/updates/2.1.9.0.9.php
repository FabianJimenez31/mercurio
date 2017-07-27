<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.9 - Agrega Fecha de Creacion a Usuarios y campo de factura de proveedor a recepcion de pedidos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo creacion_fecha';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."employees` LIKE 'creacion_fecha'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==TRUE){
$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."employees` LIKE 'creacion_fecha_real'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

}

if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."employees add creacion_fecha timestamp not null");
ejecutar("alter table ".$tt['prefix']."employees add creacion_fecha_real timestamp not null");
ejecutar("alter table ".$tt['prefix']."requisitions add provider_id int not null");
ejecutar("alter table ".$tt['prefix']."requisitions add provider_invoice varchar(50) not null");
ejecutar("INSERT INTO ".$tt['prefix']."app_config (`key` , `value` ) values ('force_provider_invoice' , 'N') ");
ejecutar("alter table ".$tt['prefix']."esquemas add periodical int not null");
ejecutar("alter table ".$tt['prefix']."esquemas add month_start int not null");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}

}








?>
