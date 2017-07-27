<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$datos=$_POST;

if(isset($_GET['person_id'])){


$customer=array(
'account_number'=>$datos['account_number'],
'cc_token'=>$datos['cc_token'],
'company_name'=>$datos['company_name'],
'card_issuer'=>$datos['card_issuer'],
'cc_preview'=>$datos['cc_preview'],
);

$person=array(
'first_name'=>$datos['first_name'],
'last_name'=>$datos['last_name'],
'comments'=>$datos['comments'],
'phone_number'=>$datos['phone_number'],
'email'=>$datos['email'],
'address_1'=>$datos['address_1'],
'city'=>$datos['city'],
'state'=>$datos['state']
);


$f=update_mysql('customers',$customer,'person_id='.$_GET['person_id']);
$g=update_mysql('people',$person,'person_id='.$_GET['person_id']);


$redirect=($datos['redirect']=='') ? 'none' : $datos['redirect'];
echo json_encode(array('success'=>true , 'location_id'=>$_GET['person_id'] , 'redirect'=>$redirect ,'message'=>"Informacion Guardada Exitosamente con ID ".$_GET['person_id']));


}else{


$customer=array(
'account_number'=>$datos['account_number'],
'cc_token'=>$datos['cc_token'],
'company_name'=>$datos['company_name'],
'card_issuer'=>$datos['card_issuer'],
'cc_preview'=>$datos['cc_preview'],
);

$person=array(
'first_name'=>$datos['first_name'],
'last_name'=>$datos['last_name'],
'comments'=>$datos['comments'],
'phone_number'=>$datos['phone_number'],
'email'=>$datos['email'],
'address_1'=>$datos['address_1'],
'city'=>$datos['city'],
'state'=>$datos['state']
);


$g=insert_mysql('people',$person);
$customer['person_id']=$g['last_id'];
$f=insert_mysql('customers',$customer);



$redirect=($datos['redirect']=='') ? 'none' : $datos['redirect'];
echo json_encode(array('success'=>true , 'location_id'=>$g['last_id'] , 'redirect'=>$redirect ,'message'=>"Informacion Guardada Exitosamente con ID ".$g['last_id']));
}
}


?>
