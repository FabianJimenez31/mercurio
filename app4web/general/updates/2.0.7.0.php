<?php

global $server;
global $x;

$server[$x]['version']='2.0.7 - Actualizacion para permitir Post-Pago';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo postpay en items';

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'postpay'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."items` 
ADD  `postpay` INT NOT NULL
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}

}


?>
