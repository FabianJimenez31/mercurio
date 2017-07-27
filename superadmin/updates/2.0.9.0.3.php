<?php

global $server;
global $x;

$server[$x]['version']='2.0.9.0.3 - Actualizacion para permitir etiquetas en tiers';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de nombres de tiers en items';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'tier_1_name'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."items` ADD  `tier_1_name` TEXT NOT NULL ,
ADD  `tier_2_name` TEXT NOT NULL ,
ADD  `tier_3_name` TEXT NOT NULL ,
ADD  `tier_4_name` TEXT NOT NULL ,
ADD  `tier_5_name` TEXT NOT NULL ,
ADD  `tier_6_name` TEXT NOT NULL ,
ADD  `tier_7_name` TEXT NOT NULL ,
ADD  `tier_8_name` TEXT NOT NULL ,
ADD  `tier_9_name` TEXT NOT NULL ,
ADD  `tier_10_name` TEXT NOT NULL ;
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}
}




?>
