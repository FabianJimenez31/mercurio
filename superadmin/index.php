<?php

ini_set("session.save_path", "/tmp/"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 
session_start();
define('DEBUGMODE','ON');
date_default_timezone_set("America/Bogota");
define('APPDIR', str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']));
include(APPDIR."core/loader.php");
include(APPDIR."../config.php");
include(APPDIR."core/mysql.php");
include(APPDIR."core/permissions.php");
include(APPDIR."core/uuid.php");
include(APPDIR."core/logger.php");
include(APPDIR."core/class.phpmailer.php");
include(APPDIR."core/class.smtp.php");
include(APPDIR."core/mail.php");

global $var_array;
$var_array=array();
$var_array['username']=$_SESSION['username'];
$var_array['domain']=$_SESSION['domain'];
$var_array['session_uuid']=$_SESSION['session_uuid'];
$var_array['post']=$_POST;
$var_array['get']=$_GET;
$var_array['complete']=$_SESSION;
session_write_close ();

/*ACTIVA LOGGER DE HTML, USAR EN PRODUCCION PARA RASTREO DE SOLICITUDES*/
//mysql_log($var_array['username'],$var_array['domain'],$var_array['post'],$var_array['get'],$_SERVER['REMOTE_ADDR']);

if(isset($var_array['session_uuid']) && $var_array['session_uuid']!='' && $var_array['get']['module']!='login'){
$var_array['get']['module']=($var_array['get']['module']!='' && isset($var_array['get']['module']))?$var_array['get']['module']:'home';
$var_array['get']['action']=($var_array['get']['action']!='' && isset($var_array['get']['action']))?$var_array['get']['action']:'dashboard';
load_action($var_array['get']['module'],$var_array['get']['action']);

}else{

if($var_array['get']['action']!='validate'){

load_action('login','window');
}else{
load_action($var_array['get']['module'],$var_array['get']['action']);
}

}




?>
