<?php
ini_set("session.save_path", "/tmp"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 
session_start();

date_default_timezone_set("America/Bogota");
define('APPDIR', str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']));

define('BASEPATH','/');
include(APPDIR."dirs.php");
if(!(include(APPDIR."config.php"))){die( "NO SE ENCONTRO EL ARCHIVO config.php");};

if(!(include(APPDIR."contents.php"))){die( "NO SE ENCONTRO EL ARCHIVO contents.php");};


include_once(LIBS."uuid.php");
include_once(LIBS."sql.php");
include_once(LIBS."loader.php");
include_once(LIBS."tables.php");
include_once(LIBS."PHPExcel.php");
include_once(LIBS."translation.php");


global $user_id;
global $current_sale_array;
global $current_presale_array;
global $current_requisition_array;
global $current_traslado;
global $application_config;
global $user_box;
global $user_array;

$config_items=select_mysql("*",'app_config');

foreach($config_items['result'] as $i){


$application_config[$i['key']]=utf8_encode($i['value']);

}


///UPDATE_SESSIONBOX

$csb=select_mysql('*','sessions','status=0 AND employee_is='.$_SESSION['user'],'session_id desc','1');
$_SESSION['box']=($csb['count']>=1)? $csb['result'][0]['session_id']:0;
///

$user_id=$_SESSION['user'];
$user_box=$_SESSION['box'];
$user_array=user_array($_SESSION['user']);
$current_presale_array=(isset($_SESSION['presale']) && is_array($_SESSION['presale'])) ? $_SESSION['presale'] : array();
$current_sale_array=(isset($_SESSION['sale']) && is_array($_SESSION['sale'])) ? $_SESSION['sale'] : array();
$current_requisition_array=(isset($_SESSION['requisition']) && is_array($_SESSION['requisition'])) ? $_SESSION['requisition'] : array();
$current_traslado=(isset($_SESSION['traslado']) && is_array($_SESSION['traslado'])) ? $_SESSION['traslado'] : array();
if($_GET['mod']!='logger'){

$post_v="";

foreach($_POST as $k=>$v){
$post_v.="\n[ ".$k." ] ::: ".$v;
}

$get_v="";

foreach($_GET as $k=>$v){
$get_v.="\n[ ".$k." ] ::: ".$v;
}


insert_mysql("logger",
array(
'modulo'=>$_GET['mod'],
'proceso'=>$_GET['proc'],
'post_variables'=> $post_v,
'get_variables'=> $get_v,
'usuario_id'=>$_SESSION['user'],
'ip_acceso'=>$_SERVER['REMOTE_ADDR']
)
);
}

if(isset($_SESSION['user']) && $_SESSION['user']>0 && $_SESSION['user']!="" && $user_array && $user_array['deleted']==0){

session_write_close ();





load_process($_GET['mod'],$_GET['proc']);




}elseif($_SESSION['user']=='offlineuser'){

session_write_close ();





load_process($_GET['mod'],$_GET['proc']);


}else{


if($_GET['logintoken']!=""){
load_template("login","validate");


}else{
load_template("login","screen");
}

}



?>
