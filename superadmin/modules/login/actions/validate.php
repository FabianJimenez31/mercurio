<?php

global $var_array;

if($_POST['username']=='tiendasadmin' && $_POST['password']=='tiendasadminMaster2015$$$'){

$newURL='?';
session_start();
$_SESSION['username']='tiendasadmin';
$_SESSION['session_uuid']=guid();

header('Location: '.$newURL);



}else{

$var_array['login']['error']="Usuario no existe en este dominio o la Contraseña es Incorrecta";

load_module_view('login','window');


}


?>
