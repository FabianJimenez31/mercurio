<?php

echo "<br>2.0.3b Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de consignado_datafonos existen en sessions? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sessions` LIKE 'consignado_datafonos'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sessions` ADD  `consignado_datafonos` DOUBLE NOT NULL ;
");

echo "<br>Creacion > [ OK ]";
}





?>
