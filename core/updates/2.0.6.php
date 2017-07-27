<?php

echo "<br>2.0.6 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campo iva en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_item_kits` LIKE 'iva'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_item_kits` 
ADD  `iva` INT NOT NULL
;");

echo "<br>Creacion > [ OK ]";
}




?>
