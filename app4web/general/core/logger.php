<?php

function grab_dump($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

function log_me($message){

$file = fopen(APPDIR."logs/general.log", "a");
$dump= "\n\nLOG ".date("Y-m-d H:i:s").": \n".$message."\n\nEND LOG" ;
fwrite($file, $dump);
fclose($file);

}

function mysql_log($username,$domain,$post,$get,$ip){

$array=array(

'username'=>$username,
'domain'=>$domain,
'post' => json_encode($post),
'get'=>json_encode($get),
'remote_ip'=>$ip

);

$m=insert_mysql("http_logger",$array);

return $m;
}

?>
