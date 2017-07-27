<?php

echo "<br>2.0.3 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de consignacion y datafono existen en sessions? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sessions` LIKE 'consignacion_file'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sessions` ADD  `consignacion` TEXT NOT NULL ,
ADD  `consignacion_file` INT NOT NULL ,
ADD  `consignacion_content` LONGBLOB NOT NULL ,
ADD  `consignacion_type` VARCHAR( 32 ) NOT NULL ,
ADD  `datafono` TEXT NOT NULL ,
ADD  `datafono_file` INT NOT NULL ,
ADD  `datafono_content` LONGBLOB NOT NULL ,
ADD  `datafono_type` VARCHAR( 32 ) NOT NULL ;");

echo "<br>Creacion > [ OK ]";
}





?>
