<?php

global $server;
global $x;

$server[$x]['version']='2.2.0.0 - Actualizacion de Modulo de Traslados';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Traslados';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='traslados'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_traslados','module_traslados_desc','90','truck','traslados');");

ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('traslados','1');");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por tablas para módulo de Traslados';


$result = ejecutar("show tables like '".$tt['prefix']."traslados' ");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("CREATE TABLE ".$tt['prefix']."traslados
(

traslados_id int(10) NOT NULL AUTO_INCREMENT,
referencial varchar(55) NOT NULL ,
comments text NOT NULL ,
created_by int(10) NOT NULL,
created_at DATETIME NOT NULL,
sent_by int(10) NOT NULL,
sent_at DATETIME NOT NULL,
received_by int(10) NOT NULL,
received_at DATETIME NOT NULL,
state varchar(32) NOT NULL DEFAULT 'Solicitado',
 PRIMARY KEY (`traslados_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");


ejecutar("CREATE TABLE ".$tt['prefix']."traslados_items
(

traslados_id int(10) NOT NULL,
inventory_id int(10) NOT NULL 

);
");

ejecutar("alter table ".$tt['prefix']."inventory add traslados_id int(10) NOT NULL ");



$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
