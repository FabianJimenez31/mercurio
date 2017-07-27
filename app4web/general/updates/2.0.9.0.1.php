<?php

global $server;
global $x;

$server[$x]['version']='2.0.9.0.1 - Actualizacion para permitir multiples precios';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de tiers en items';

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."items` LIKE 'tier_1'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `".$tt['prefix']."items` ADD  `tier_1` DOUBLE NOT NULL ,
ADD  `tier_2` DOUBLE NOT NULL ,
ADD  `tier_3` DOUBLE NOT NULL ,
ADD  `tier_4` DOUBLE NOT NULL ,
ADD  `tier_5` DOUBLE NOT NULL ,
ADD  `tier_6` DOUBLE NOT NULL ,
ADD  `tier_7` DOUBLE NOT NULL ,
ADD  `tier_8` DOUBLE NOT NULL ,
ADD  `tier_9` DOUBLE NOT NULL ,
ADD  `tier_10` DOUBLE NOT NULL ;
;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}
}




?>
