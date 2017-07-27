<?php

echo "<br>2.0.5a Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campo num_tel en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sales_items` LIKE 'num_tel'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sales_items` 
ADD  `num_tel` VARCHAR(130) NOT NULL
;");

echo "<br>Creacion > [ OK ]";
}




?>
