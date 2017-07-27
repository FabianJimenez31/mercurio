<?php


global $server;
global $x;

$server[$x]['version']='2.0.6 - Actualizacion parcial de Item Kits';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo iva en item_kits';


$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."item_kits` LIKE 'iva'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."item_kits` 
ADD  `iva` INT NOT NULL
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}



}







?>
