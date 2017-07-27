<?php

global $server;
global $x;

$server[$x]['version']='2.1.4.0 - Actualizacion para permitir seriales no registrados';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo de val_serial en tabla items';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'val_serial'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."items` ADD  `val_serial` INT NOT NULL ;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}
}




?>
