<?php

global $server;
global $x;

$server[$x]['version']='2.1.1 - Actualizacion para permitir alias de tiendas';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';



$server[$x]['status'].='<br/> - Revisando por campo aliases  en tiendas';

$result = ejecutar("SHOW COLUMNS FROM tiendas LIKE 'aliases'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `tiendas` ADD  `aliases` VARCHAR(50) NOT NULL;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}





?>
