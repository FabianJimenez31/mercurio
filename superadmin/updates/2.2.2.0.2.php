<?php

global $server;
global $x;

$server[$x]['version']='2.2.2.0.2 - Actualizacion de Modulo de Geeksify';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por modulo Geeksify';


$result = ejecutar("select * from ".$tt['prefix']."modules where module_id='geeksify_config'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;


if($exists==FALSE){

ejecutar("insert into ".$tt['prefix']."modules (name_lang_key ,  desc_lang_key , sort , icon , module_id) values ('module_geeksify_config','module_geeksify_config_desc','90','calculator','geeksify_config');");
ejecutar("insert into ".$tt['prefix']."permissions (module_id , person_id) values ('geeksify_config','1');");

ejecutar("CREATE TABLE ".$tt['prefix']."geeksify_marcas
(

marcas_id int(10) NOT NULL AUTO_INCREMENT,
valor varchar(55) NOT NULL ,
status INT NOT NULL DEFAULT '1',
 PRIMARY KEY (`marcas_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");

ejecutar("CREATE TABLE ".$tt['prefix']."geeksify_modelos
(
modelos_id int(10) NOT NULL AUTO_INCREMENT,
marca_id int(10) NOT NULL,
valor varchar(55) NOT NULL ,
tipo_a FLOAT NOT NULL ,
tipo_b FLOAT NOT NULL ,
tipo_c FLOAT NOT NULL ,
tipo_d FLOAT NOT NULL ,
status INT NOT NULL DEFAULT '1',
 PRIMARY KEY (`modelos_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");


ejecutar("CREATE TABLE ".$tt['prefix']."geeksify_envio
(
envios_id int(10) NOT NULL AUTO_INCREMENT,
marca_id int(10) NOT NULL,
modelo_id int(10) NOT NULL,
person_id int(10) NOT NULL,
client_id int(10) NOT NULL,
fecha varchar(55) NOT NULL ,
tipo INT NOT NULL ,
quiere INT NOT NULL,
razon varchar(255),
status INT NOT NULL DEFAULT '1',
 PRIMARY KEY (`envios_id`)

)

ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

");


$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}








?>
