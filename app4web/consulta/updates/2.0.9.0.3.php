<?php

echo "<br>2.0.9.0.1 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de Tiers Name en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_items` LIKE 'tier_1_name'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_items` ADD  `tier_1_name` TEXT NOT NULL ,
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

echo "<br>Creacion > [ OK ]";
}




?>
