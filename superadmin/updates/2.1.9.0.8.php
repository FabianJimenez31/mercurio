<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0.8 - Agrega Índices en Tabla sessions';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo razon_rechazo';


$result = ejecutar("show index from `".$tt['prefix']."sessions` where Column_name like 'employee_is' ");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `session_id` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `employee_is` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `status` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `date_start` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `date_end` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `force_closed` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `is_general` ) ");
ejecutar("alter table ".$tt['prefix']."sessions ADD INDEX (  `global_id` ) ");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}

}








?>
