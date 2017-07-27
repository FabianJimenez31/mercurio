<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;
unset($datos['submitf']);
if(isset($_GET['location_id'])){

update_mysql('locations',$datos,'location_id='.$_GET['location_id']);
echo json_encode(array('success'=>true , 'location_id'=>$_GET['location_id'] , 'message'=>"Informacion Guardada Exitosamente con ID ".$_GET['location_id']));


}else{

$m=insert_mysql("locations",$datos);


echo json_encode(array('success'=>true , 'location_id'=>$m['last_id'] , 'message'=>"Información Guardada Exitosamente con ID ".$m['last_id']));

}
}


?>
