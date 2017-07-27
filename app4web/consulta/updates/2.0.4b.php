<?php

echo "<br>2.0.4b Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Campos de cuentas inventario existen en contable? ";

////validate if colummn exists

$result = ejecutar("SHOW COLUMNS FROM `phppos_cuentascontables` LIKE 'i_credito'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

echo ($exists)?"SI":"NO [creando...]";

if($exists==FALSE){

ejecutar("ALTER TABLE  `phppos_cuentascontables` ADD  `i_credito` VARCHAR( 100 ) NOT NULL ,
ADD  `i_debito` VARCHAR( 100 ) NOT NULL ;");

echo "<br>Creacion > [ OK ]";
}





?>
