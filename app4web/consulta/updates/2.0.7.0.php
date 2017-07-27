<?php

echo "<br>2.0.7 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campo postpay en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_items` LIKE 'postpay'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_items` 
ADD  `postpay` INT NOT NULL
;");

echo "<br>Creacion > [ OK ]";
}




?>
