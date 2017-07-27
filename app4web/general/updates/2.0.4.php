<?php

global $server;
global $x;

$server[$x]['version']='2.0.4 - Actualizacion de Modulo Contable';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo tabla en cuentascontables';


$result = ejecutar("SHOW TABLES LIKE '".$tt['prefix']."cuentascontables'");
$tableExists = (mysqli_num_rows($result) > 0)?TRUE:FALSE;


if($tableExists==FALSE){
$server[$x]['status'].=" - Necesita Actualizar";
ejecutar("CREATE TABLE IF NOT EXISTS `".$tt['prefix']."cuentascontables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `debito` varchar(100) NOT NULL,
  `credito` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");

}else{
$server[$x]['status'].=" - Actualizado";

}


}











?>
