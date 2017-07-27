<?php

echo "<br>2.0.3a Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de consignado existen en sessions? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sessions` LIKE 'consignado'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sessions` ADD  `consignado` DOUBLE NOT NULL ;
");

echo "<br>Creacion > [ OK ]";
}





?>
