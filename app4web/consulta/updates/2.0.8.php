<?php

echo "<br>2.0.8 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Existe BD para Temporales de Contratos? ";

////validate if colummn exists

$result = ejecutar("SHOW TABLES LIKE 'phppos_temporal_contratos'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
echo ($tableExists)?"SI":"NO";

if($tableExists==FALSE){

ejecutar("

CREATE TABLE IF NOT EXISTS `phppos_temporal_contratos` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `name` varchar(120) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `meta` varchar(50) NOT NULL,
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

");

echo "<br>Creacion > [ OK ]";
}




?>
