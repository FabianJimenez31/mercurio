<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$items=select_mysql("DISTINCT category","items","category LIKE '%".$_GET['term']."%'");
$cat=array();
foreach($items['result'] as $n){

$cat[]=$n['category'];

}

echo json_encode($cat);

}


?>
