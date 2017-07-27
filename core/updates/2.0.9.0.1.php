<?php

echo "<br>2.0.9.0.1 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de Tiers en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_items` LIKE 'tier_1'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_items` ADD  `tier_1` DOUBLE NOT NULL ,
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

echo "<br>Creacion > [ OK ]";
}




?>
