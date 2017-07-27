<?php

global $server;
global $x;

$server[$x]['version']='2.1.5 - Actualizacion para permitir eliminación de tiendas';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';



$server[$x]['status'].='<br/> - Revisando por campo deleted  en tiendas';

$result = ejecutar("SHOW COLUMNS FROM tiendas LIKE 'deleted'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `tiendas` ADD  `deleted` INT NOT NULL;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}





?>
