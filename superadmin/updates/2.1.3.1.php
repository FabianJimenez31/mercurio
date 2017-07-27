<?php

global $server;
global $x;

$server[$x]['version']='2.1.3.1 - Actualizacion para Permitir el Catalogo de Items General';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';



$result=ejecutar("SHOW COLUMNS FROM `permanent_items` LIKE 'tier_1_allow'");
$server[$x]['status'].='<br/> - Revisando existencia de allow de tiers en permanent_items';
$exists = (mysqli_num_rows($result)>0)?TRUE:FALSE;


if($exists==FALSE){

ejecutar("ALTER TABLE  `permanent_items` ADD  `tier_1_allow` TEXT NOT NULL ,
ADD  `tier_2_allow` TEXT NOT NULL ,
ADD  `tier_3_allow` TEXT NOT NULL ,
ADD  `tier_4_allow` TEXT NOT NULL ,
ADD  `tier_5_allow` TEXT NOT NULL ,
ADD  `tier_6_allow` TEXT NOT NULL ,
ADD  `tier_7_allow` TEXT NOT NULL ,
ADD  `tier_8_allow` TEXT NOT NULL ,
ADD  `tier_9_allow` TEXT NOT NULL ,
ADD  `tier_10_allow` TEXT NOT NULL;");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}








?>
