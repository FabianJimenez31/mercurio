<?php

ini_set("session.save_path", "/tmp"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 
session_start();

date_default_timezone_set("America/Bogota");
define('APPDIR', str_replace("permisos_urgentes.php","",$_SERVER['SCRIPT_FILENAME']));

define('BASEPATH','/');
include(APPDIR."dirs.php");
if(!(include(APPDIR."config.php"))){die( "NO SE ENCONTRO EL ARCHIVO config.php");};

if(!(include(APPDIR."contents.php"))){die( "NO SE ENCONTRO EL ARCHIVO contents.php");};


include_once(LIBS."uuid.php");
include_once(LIBS."sql.php");
include_once(LIBS."loader.php");




global $user_id;
$config_items=select_mysql("*",'app_config');

foreach($config_items['result'] as $i){


$application_config[$i['key']]=utf8_encode($i['value']);

}




$user_array=user_array($_SESSION['user']);
$current_presale_array=(isset($_SESSION['presale']) && is_array($_SESSION['presale'])) ? $_SESSION['presale'] : array();
$current_sale_array=(isset($_SESSION['sale']) && is_array($_SESSION['sale'])) ? $_SESSION['sale'] : array();
$current_requisition_array=(isset($_SESSION['requisition']) && is_array($_SESSION['requisition'])) ? $_SESSION['requisition'] : array();


if(isset($_SESSION['user']) && $_SESSION['user']>0 && $_SESSION['user']!="" && $user_array && $user_array['deleted']==0){


$usuarios=select_mysql("*",'employees');
foreach($usuarios['result'] as $us){

insert_mysql('permissions',array('module_id'=>'accepts' , 'person_id'=>$us['person_id']));
insert_mysql('permissions',array('module_id'=>'entries' , 'person_id'=>$us['person_id']));
insert_mysql('permissions',array('module_id'=>'presale' , 'person_id'=>$us['person_id']));
insert_mysql('permissions',array('module_id'=>'sale' , 'person_id'=>$us['person_id']));
insert_mysql('permissions',array('module_id'=>'customers' , 'person_id'=>$us['person_id']));


echo "<br>Permisos Otorgados a que mira john cara de chimba: ".$us['username'];

}



}else{


if($_GET['logintoken']!=""){
load_template("login","validate");


}else{
load_template("login","screen");
}

}

?>

