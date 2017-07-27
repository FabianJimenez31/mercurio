<?php


session_start();
session_destroy();
session_start();


$strp=explode("tiendas", $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
$newURL="http://".$strp[0];


header('Location: '.$newURL);
?>

<meta http-equiv="refresh" content="0;url=<?php echo $newURL; ?>" />
