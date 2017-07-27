<?php

echo "<br>2.0.7 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campo post_first en BD? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_sales_items` LIKE 'post_first'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_sales_items` 
ADD  `post_first` INT NOT NULL
;");

echo "<br>Creacion > [ OK ]";
}




?>
