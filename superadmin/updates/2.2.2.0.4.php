<?php

global $server;
global $x;

$server[$x]['version']='2.2.2.0.4 - Agrega Fecha de Aprobacion';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo imei';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."geeksify_envio` LIKE 'imei'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."geeksify_envio add creacion_fecha timestamp not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add envio_fecha timestamp not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add imei varchar(50) not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add imei_valid int not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add valor float not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add operador varchar(30) not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add factura varchar(30) not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add certificado_registro varchar(30) not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add cedula int not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add documento_traspaso int not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add certificado_registro varchar(30) not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add desenlazar int not null");
ejecutar("alter table ".$tt['prefix']."geeksify_envio add fabrica int not null");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}

}








?>
