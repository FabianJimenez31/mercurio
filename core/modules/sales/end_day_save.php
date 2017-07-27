<?php
global $user_array;
global $user_box;
global $application_config;
if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');



$payment_types=array(

'Efectivo'

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}
$x=1;

foreach($payment_types as $pt){
$ammount=select_mysql("sum(payment_amount) as ammount","sales_payments",'session_box='.$user_box." and payment_type='".$pt."'");
$initial_am=select_mysql("sum(start) as ammount","closures",'session_box='.$user_box." and payment_type='".$pt."'");
$init=array(

'end' =>$_POST['payment_type_'.$x],
'system_end' =>$ammount['result'][0]['ammount']+$initial_am['result'][0]['ammount']

);
$g[$x]=update_mysql('closures',$init,'session_box='.$user_box." and payment_type='".$pt."'");
log_me($g[$x]['query']);
$x++;
}

$u=update_mysql('sessions',array('status'=>'1','date_end'=>date("Y-m-d H:i:s")),'session_id='.$user_box);


?>
<script>
window.location.href="?mod=sales&proc=main";
</script>


		
<?php
load_template('partial','footer');
}


?>
