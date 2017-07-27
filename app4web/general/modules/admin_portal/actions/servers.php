<?php
global $var_array;
global $server;
global $x;
if($var_array['username']=='tiendasadmin'){


$git_result=exec("git pull https://overvoiplatam:KoRnAle77@bitbucket.org/fabian_jimenez/mercurio-pangea.git master");

$server[0]['version']='0 - CODIGO FUENTE';
$server[0]['type']='GIT';
$server[0]['status']=$git_result;

if(strpos($git_result,'eady up-to-dat')!=false){

$dir=APPDIR."updates/";

$files1 = scandir($dir);
$x=0;
foreach($files1 as $update){

if($update!='index.php' && (substr($update,-1,1)!="~") && $update!='.' && $update!='..'){
$x++;
include_once($dir.$update);
}
}


}else{

$server[0]['status'].=" Pendiente de Actualizar";


}
$x=0;
foreach($server as $ss){

if(strpos($ss['status'],"Actualizar")!=false){
//.$ss['status']
$server[$x]['status'] = "<br/><P style=\"color:red;\">NECESITA ACTUALIZAR</P><br/><br/>";
}else{
//.$ss['status']
$server[$x]['status'] = "<br/><P style=\"color:green;\">OK</P><br/><br/>";

}
$x++;
}
dynamic_module_view("admin_portal",'servers',array('servers'=>$server));




}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
