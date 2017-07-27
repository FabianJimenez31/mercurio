<?php

global $server;
global $x;

$server[$x]['version']='2.1.4.1 - Actualizacion de Items General';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';



$result=ejecutar("SHOW COLUMNS FROM `permanent_items` LIKE 'val_serial'");
$server[$x]['status'].='<br/> - Revisando existencia de allow de val_serial en permanent_items';
$exists = (mysqli_num_rows($result)>0)?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `permanent_items` ADD  `val_serial` INT NOT NULL ;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}








?>
