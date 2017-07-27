<?php

global $server;
global $x;

$server[$x]['version']='2.2.0.1 - Actualizacion Para Módulo de Traslados';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';


$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campo send_address en traslados';

$result = ejecutar("SHOW COLUMNS FROM `".$tt['prefix']."traslados_history` LIKE 'comments'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;
if($exists==FALSE){

ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD location_id INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD send_address TEXT NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD comments TEXT NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD received_por TEXT NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD show_comments INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD regresado INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD regresado_tx INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD sku varchar(55)");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD serial varchar(55) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD cancelacion text NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD extras text NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD is_recibido INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD is_ingresado INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados ADD is_regresado INT(10) NOT NULL");
ejecutar("ALTER TABLE ".$tt['prefix']."traslados_items ADD tx_id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY");


ejecutar("CREATE TABLE ".$tt['prefix']."traslados_history
(

history_id int(10) NOT NULL AUTO_INCREMENT,
traslados_id int(10) NOT NULL ,
cuando TIMESTAMP ,
comments text NOT NULL ,
 PRIMARY KEY (`history_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");


$server[$x]['status'].=" - Necesita Actualizar";

}else{
$server[$x]['status'].=" - Actualizado";

}






}









?>
