<?php

echo "<br>2.0.9.0.2 Ejecutando Revision de Sistema de Bases de Datos SalesMan";
echo "<br><br>Campos de salesman en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sales` LIKE 'salesman'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sales` ADD  `salesman` INT NOT NULL ;");

echo "<br>Creacion > [ OK ]";
}




?>
