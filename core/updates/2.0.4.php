<?php

echo "<br>2.0.4 Ejecutando Revision de Sistema de Bases de Datos";
echo "<br><br>Tabla contable existe? ";

////validate if colummn exists

$result = ejecutar("SHOW TABLES LIKE 'phppos_cuentascontables'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;
echo ($tableExists)?"SI":"NO [Creando ...]";


if($tableExists==FALSE){

ejecutar("CREATE TABLE IF NOT EXISTS `phppos_cuentascontables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `debito` varchar(100) NOT NULL,
  `credito` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");

echo "<br>Creacion > [ OK ]";
}





?>
