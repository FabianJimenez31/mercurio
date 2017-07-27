<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;

if(isset($_GET['supplier_id'])){

$f=update_mysql('suppliers',array('company_name'=>$datos['name']),'supplier_id='.$_GET['supplier_id']);
$g=update_mysql('people',array('phone_number'=>$datos['phone'],'email'=>$datos['email']),'person_id='.$_GET['person_id']);



echo json_encode(array('success'=>true , 'location_id'=>$_GET['supplier_id'] , 'message'=>"Informacion Guardada Exitosamente con ID ".$_GET['supplier_id']));


}else{


$m1=insert_mysql('people',array('phone_number'=>$datos['phone'],'email'=>$datos['email']));
$m=insert_mysql('suppliers',array('company_name'=>$datos['name'],'person_id'=>$m1['last_id']));


echo json_encode(array('success'=>true , 'location_id'=>$m['last_id'] , 'message'=>"Información Guardada Exitosamente con ID ".$m1['last_id']));

}
}


?>
