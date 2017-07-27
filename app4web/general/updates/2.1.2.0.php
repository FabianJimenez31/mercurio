<?php

global $server;
global $x;

$server[$x]['version']='2.1.2 - Actualizacion para Reporte de Ventas de Usuario';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de meta_diaria';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."employees` LIKE 'meta_diaria'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."employees` ADD  `meta_diaria` INT NOT NULL ,
ADD  `meta_mensual` INT NOT NULL ;
;");


$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}
}




?>
