<?php
ini_set("session.save_path", "/tmp/appoverpym"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 
session_start();

date_default_timezone_set("America/Bogota");
define('APPDIR', str_replace("api.php","",$_SERVER['SCRIPT_FILENAME']));

define('BASEPATH','/');
include(APPDIR."dirs.php");


define('MYSQLHOST','localhost');
define('MYSQLUSER','root');
define('MYSQLPSSWD','KoRnAle77');
define('MYSQLDB','procesos');
include_once(LIBS."uuid.php");
include_once(LIBS."sql.php");
include_once(LIBS."loader.php");


global $user_id;
global $current_sale_array;
global $user_array;
$user_array=user_array($_SESSION['user']);
$current_sale_array=$_SESSION['sale'];

if($_GET['method']=="get_apicode"){

$validar=select_mysql("*","users","username='".$_POST['username']."' and password='".md5($_POST['password'])."' and status=1");

if($validar['count']>=1){


echo $validar['result'][0]['api_code'];
}else{

echo "ERROR";

}


}else{

if(api_array($_GET['token'])){
$user_array=api_array($_GET['token']);
session_write_close ();
load_process($_GET['mod'],$_GET['proc']);


}else{
////COMENTARIO ALEATORIO

if($_GET['logintoken']!=""){
//load_template("login","validate");
echo "ERROR";

}else{
//load_template("login","screen");
echo "ERROR";
}

}

}


?>
