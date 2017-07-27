<?php

global $server;
global $x;

$server[$x]['version']='2.0.5a - Actualizacion de Contratos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo num_tel en sales_items';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."sales_items` LIKE 'num_tel'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."sales_items` 
ADD  `num_tel` VARCHAR(130) NOT NULL
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}


}

////validate if colummn exists





?>
