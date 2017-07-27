<?php

global $var_array;

$validate_user=select_mysql("*","users","username='".$var_array['post']['username']."' and password='".md5($var_array['post']['password'])."' and domain='".$var_array['post']['domain']."'");

if($validate_user['count']>0){

if($validate_user['result'][0]['status']!=1){

$var_array['login']['error']="El usuario no se encuentra Activo";

load_module_view('login','window');


}else{

$var_array['login']['error']="INGRESAR";

load_module_view('login','window');


}

}else{

$var_array['login']['error']="Usuario no existe en este dominio o la Contraseña es Incorrecta";

load_module_view('login','window');


}


?>
