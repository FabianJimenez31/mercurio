<?php

global $var_array;

session_start();
$_SESSION=NULL;
foreach($_SESSION as $k=>$m){

unset($_SESSION[$k]);

}
session_destroy();
$var_array['login']['error']="Lo sentimos, solo puede tener una sesión abierta";

load_module_view('login','window');

?>
