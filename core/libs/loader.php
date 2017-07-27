<?php


function load_process($module="home",$process="dashboard"){
if(!$module){
$module="home";
$process="dashboard";
}
include(MODULES.$module."/".$process.".php");

return true;
}

function load_template($category='',$item){
include(TEMPLATES.$category."/".$item.".php");
return true;
}




///////////////USER SESSION



function user_array($uid){
$r=false;

$j=select_mysql("*","employees","person_id=".$uid);

if($j['count']==1){
$r=$j['result'][0];
}

return $r;
}

function user_info($uid){
$r=false;

$j=select_mysql("*","people","person_id=".$uid);

if($j['count']==1){
$r=$j['result'][0];
}

return $r;
}


function permitido($uid,$module){
$r=false;

$j=select_mysql("*","permissions","module_id='$module' and person_id=".$uid);

if($j['count']==1){
$r=true;
}

return $r;
}

function username_array($uid){
$r=false;

$j=select_mysql("*","users","username='".$uid."'");

if($j['count']==1){
$r=$j['result'][0];
}

return $r;
}

///////////// API VALIDATION


function api_array($uid){
$r=false;

$j=select_mysql("*","users","api_code='".$uid."'");

if($j['count']==1){
$r=$j['result'][0];
}

return $r;
}


function api_check($uid){
$r=false;

$j=select_mysql("*","users","api_code='".$uid."'");

if($j['count']==1){
$r=true;
}

return $r;
}

function grab_dump($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

function item_info($id){

$in=select_mysql("*","items","item_id=".$id);
$cuantos=select_mysql("*","inventory","state='Disponible' AND trans_items=".$id);
$f=array('info'=>$in['result'][0],'count'=>$cuantos['count']);
return  $f;

}

function location_info($id){

$in=select_mysql("*","locations","location_id=".$id);
$f=array('info'=>$in['result'][0]);
return  $f;

}

function log_me($message){

$file = fopen(APPDIR."general.log", "a");
$dump= "\n\nLOG ".date("Y-m-d H:i:s").": \n".$message."\n\nEND LOG" ;
fwrite($file, $dump);
fclose($file);

}


?>
