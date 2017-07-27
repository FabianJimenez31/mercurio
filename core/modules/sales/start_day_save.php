<?php
global $user_array;
global $application_config;
if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$ses_arr=array(

'employee_is' =>$user_array['person_id'],
'session_box' =>$_POST['session_box']

);

$session_new=insert_mysql('sessions',$ses_arr);


$payment_types=array(

'Efectivo',

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}


$x=1;

foreach($payment_types as $pt){

$init=array(

'employee_id' =>$user_array['person_id'],
'session_box' =>$session_new['last_id'],
'start' =>$_POST['payment_type_'.$x],
'payment_type' =>$pt

);
$g[]=insert_mysql('closures',$init);

$x++;
}


?>
<script>
window.location.href="?mod=sales&proc=main";
</script>


		
<?php
load_template('partial','footer');
}


?>
