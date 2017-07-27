<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
$cat=array();
$nombre=select_mysql("*","people","first_name LIKE '%".$_GET['term']."%' or last_name LIKE '%".$_GET['term']."%' or email LIKE '%".$_GET['term']."%' or phone_number LIKE '%".$_GET['term']."%' ");



foreach($nombre['result'] as $i){

$cliente=select_mysql("*","customers","deleted=0 and person_id=".$i['person_id']);
if($cliente['count']>0){

$cat[]=array('value'=>$cliente['result'][0]['person_id'],'label'=>" ".utf8_encode($i['first_name']).",".utf8_encode($i['last_name']));
}

}



echo json_encode($cat);

}


?>
