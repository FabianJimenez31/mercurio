<?php

global $server;
global $x;

$server[$x]['version']='2.1.9.0 - Comisiones y Supernumerarios';
$server[$x]['type']='MySQL';
$server[$x]['status']='Iniciando Revisión';

$tiendas_a=select_mysql("*","tiendas","deleted!=1");

foreach($tiendas_a['result'] as $tt){

$server[$x]['status'].='<br/> - Revisando en tienda '.$tt['name'] . ' por campos de comisiones';


$result = ejecutar("SHOW TABLES LIKE '".$tt['prefix']."esquemas';");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){

ejecutar("CREATE TABLE ".$tt['prefix']."esquemas (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
name VARCHAR(50) NOT NULL,
description TEXT NOT NULL

)");

ejecutar("CREATE TABLE ".$tt['prefix']."rangos (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
name VARCHAR(50) NOT NULL,
description TEXT NOT NULL,
maximo FLOAT(10) NOT NULL,
minimo FLOAT(10) NOT NULL

)");

ejecutar("CREATE TABLE ".$tt['prefix']."categorias (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
name VARCHAR(50) NOT NULL,
description TEXT NOT NULL
)");

ejecutar("CREATE TABLE ".$tt['prefix']."metas (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
name VARCHAR(50) NOT NULL,
description TEXT NOT NULL
)");

ejecutar("CREATE TABLE ".$tt['prefix']."metas_asignar (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
meta float(10) NOT NULL,
meta_id INT(10) NOT NULL,
categoria_id INT(10) NOT NULL
)");

ejecutar("CREATE TABLE ".$tt['prefix']."esquema_asignar (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
status INT(3) NOT NULL,
comision float(10) NOT NULL,
es_porcentaje int(3) NOT NULL,
rango_id INT(10) NOT NULL,
categoria_id INT(10) NOT NULL,
esquema_id INT(10) NOT NULL
)");

ejecutar("ALTER TABLE ".$tt['prefix']."items

ADD categoria_id INT(10) NOT NULL,
ADD supernum_id INT(10) NOT NULL

");

ejecutar("ALTER TABLE ".$tt['prefix']."employees

ADD metas_id INT(10) NOT NULL,
ADD esquema_id INT(10) NOT NULL

");

ejecutar("ALTER TABLE ".$tt['prefix']."sales_items

ADD is_aprobada INT(3) NOT NULL,
ADD cajero_supernumerario INT(10) NOT NULL,
ADD vendedor_supernumerario INT(10) NOT NULL,
ADD is_supernumerario INT(3) NOT NULL,
ADD aprobada_por INT(3) NOT NULL

");


ejecutar("CREATE TABLE ".$tt['prefix']."logger (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
horafecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
modulo varchar(20) NOT NULL,
proceso varchar(20) NOT NULL,
post_variables TEXT NOT NULL,
get_variables TEXT NOT NULL,
archivos TEXT NOT NULL,
usuario_id varchar(50) NOT NULL,
ip_acceso varchar(50) NOT NULL,
servidor TEXT NOT NULL

)");




$server[$x]['status'].=" - Necesita Actualizar";
}else{

$server[$x]['status'].=" - Actualizado";

}


}

$server[$x]['status'].='<br/> - ¿Existe Tabla de Supernumerarios?';


$result = ejecutar("SHOW TABLES LIKE 'supernumerarios'");
$exists = (mysqli_num_rows($result))?TRUE:FALSE;

if($exists==FALSE){


ejecutar("CREATE TABLE supernumerarios (

id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username varchar(50) NOT NULL,
password varchar(50) NOT NULL,
status INT(10) NOT NULL,
first_name varchar(50) NOT NULL,
last_name varchar(50) NOT NULL

)");



$server[$x]['status'].="NO - Necesita Actualizar";
}else{

$server[$x]['status'].="SI - Actualizado";

}






?>
