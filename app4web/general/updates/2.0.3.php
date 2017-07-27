<?php

global $server;
global $x;

$server[$x]['version']='2.0.3 - Actualizacion de ingreso de datafonos y consignaciones';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por consignacion_file';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sessions` LIKE 'consignacion_file'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."sessions` ADD  `consignacion` TEXT NOT NULL ,
ADD  `consignacion_file` INT NOT NULL ,
ADD  `consignacion_content` LONGBLOB NOT NULL ,
ADD  `consignacion_type` VARCHAR( 32 ) NOT NULL ,
ADD  `datafono` TEXT NOT NULL ,
ADD  `datafono_file` INT NOT NULL ,
ADD  `datafono_content` LONGBLOB NOT NULL ,
ADD  `datafono_type` VARCHAR( 32 ) NOT NULL ;");

$server[$x]['status'].=" - Necesita Actualizar";
}else{
$server[$x]['status'].=" - Actualizado";

}





}








?>
