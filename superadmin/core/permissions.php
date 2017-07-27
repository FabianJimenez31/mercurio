<?php
function validate_permissions($user,$domain,$module,$action){
$response=array();
$container=select_mysql("*",'permissions',"username='$user' and domain='$domain' and module='$module' and action='$action' and permissions=1");

$response['pass']=($container['count']>0)?true:false;
$response['additional']=($container['count']>0)?$container['result'][0]['additional']:null;

return $response;

}

function validate_online_http($user,$domain,$session){

$response=array();
$container=select_mysql("*","http_session","username='$user' and domain='$domain' and unique_session='$session' and active=1");
$container_2=select_mysql("*","http_session","username='$user' and domain='$domain' and unique_session!='$session' and active=1");
$response['active']=($container['count']>0)?true:false;
$response['others']=($container_2['count']>0)?true:false;
if(DEBUGMODE=='ON'){$response['active']=false;$response['others']=false;}
return $response;
}

function validate_active_user($user,$domain){
$container=select_mysql("*","users","username='$user' and domain='$domain' and status=1");
$response=($container['count']>0)?true:false;

return $response;
}

function get_user_profile($user,$domain){

$container=select_mysql("profile","users","username='$user' and domain='$domain' and status=1");
$response=($container['count']==1)?$container['result'][0]['profile'] : false;
return (int)$response;
}

function get_user_id($user,$domain){

$container=select_mysql("id","users","username='$user' and domain='$domain' and status=1");
$response=($container['count']==1)?$container['result'][0]['id'] : false;
return (int)$response;
}


?>
