<?php

global $server;
global $x;

$server[$x]['version']='2.0.8 - Actualizacion de Módulo de Contratos';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por tabla temporal_contratos';

$result = ejecutar("SHOW TABLES LIKE '".$tt['prefix']."temporal_contratos'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;

if($tableExists==FALSE){

ejecutar("

CREATE TABLE IF NOT EXISTS `".$tt['prefix']."temporal_contratos` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(100) NOT NULL,
  `name` varchar(120) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `meta` varchar(50) NOT NULL,
  `file` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

");

$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}



}

?>
