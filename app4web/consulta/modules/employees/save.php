<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;

if(isset($_GET['person_id'])){

$employee=array(
'username'=>$datos['username'],
'meta_diaria'=>$datos['meta_diaria'],
'meta_mensual'=>$datos['meta_mensual'],
'supervisor_who'=>$datos['supervisor_who'],
'supervisor'=>(($datos['supervisor']==1)?'1':0)
);
if($datos['password']!=""){$employee['password']=md5($datos['password']);}



$person=array(
'first_name'=>$datos['first_name'],
'last_name'=>$datos['last_name'],
'phone_number'=>$datos['phone_number'],
'email'=>$datos['email']
);


$f=update_mysql('employees',$employee,'person_id='.$_GET['person_id']);
$g=update_mysql('people',$person,'person_id='.$_GET['person_id']);



ejecutar("DELETE FROM ".DBPREFIX."permissions WHERE person_id=".$_GET['person_id']);

foreach($datos['modules'] as $m){

insert_mysql('permissions',array('module_id'=>$m , 'person_id'=>$_GET['person_id']));

}


$redirect=($datos['redirect']=='') ? 'none' : $datos['redirect'];
echo json_encode(array('success'=>true , 'location_id'=>$_GET['person_id'] , 'redirect'=>$redirect ,'message'=>"Informacion Guardada Exitosamente con ID ".$_GET['person_id']));


}else{





$employee=array(
'username'=>$datos['username'],
'meta_diaria'=>$datos['meta_diaria'],
'meta_mensual'=>$datos['meta_mensual'],
'supervisor_who'=>$datos['supervisor_who'],
'supervisor'=>(($datos['supervisor']==1)?'1':0)
);
if($datos['password']!=""){$employee['password']=md5($datos['password']);}

$person=array(
'first_name'=>$datos['first_name'],
'last_name'=>$datos['last_name'],
'phone_number'=>$datos['phone_number'],
'email'=>$datos['email']
);

$g=insert_mysql('people',$person);
$id=$g['last_id'];
$employee['person_id']=$id;
$f=insert_mysql('employees',$employee);



foreach($datos['modules'] as $m){

insert_mysql('permissions',array('module_id'=>$m , 'person_id'=>$id));

}


$redirect=($datos['redirect']=='') ? 'none' : $datos['redirect'];
echo json_encode(array('success'=>true , 'location_id'=>$id , 'redirect'=>$redirect ,'message'=>"Informacion Guardada Exitosamente con ID ".$id));




}
}


?>
