<?php

ini_set("session.save_path", "/tmp"); 
ini_set("session.cookie_lifetime", 0); 
ini_set("session.gc_maxlifetime", "360000"); 
session_start();

date_default_timezone_set("America/Bogota");
define('APPDIR', str_replace("update_me.php","",$_SERVER['SCRIPT_FILENAME']));

define('BASEPATH','/');
include(APPDIR."dirs.php");
if(!(include(APPDIR."config.php"))){die( "NO SE ENCONTRO EL ARCHIVO config.php");};

if(!(include(APPDIR."contents.php"))){die( "NO SE ENCONTRO EL ARCHIVO contents.php");};


include_once(LIBS."uuid.php");
include_once(LIBS."sql.php");
include_once(LIBS."loader.php");
include_once(LIBS."translation.php");




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


$dir=APPDIR."updates/";

$files1 = scandir($dir);


//$git_result_2=exec("git fetch --all https://overvoiplatam:KoRnAle77@bitbucket.org/fabian_jimenez/mercurio-pangea.git ");
//$git_result_3=exec("git reset --hard https://overvoiplatam:KoRnAle77@bitbucket.org/fabian_jimenez/mercurio-pangea.git origin/master");
$git_result=exec("git pull https://overvoiplatam:KoRnAle77@bitbucket.org/fabian_jimenez/mercurio-pangea.git master");
echo "<pre>$git_result

</pre>";

foreach($files1 as $update){

if($update!='index.php' && (substr($update,-1,1)!="~") && $update!='.' && $update!='..'){

include_once($dir.$update);

}

}



}else{


if($_GET['logintoken']!=""){
load_template("login","validate");


}else{
load_template("login","screen");
}

}

?>

