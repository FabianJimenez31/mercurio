<?php
global $user_array;
global $application_config;
if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');


////////////INICIA SESION NUEVA ESPECIAL
$ses_arr=array(

'employee_is' =>$user_array['person_id'],
'session_box' =>'0',
'status'=>'1',
'date_end'=>date("Y-m-d H:i:s"),
'force_closed'=>$user_array['person_id'],
'is_general'=>'1'

);

$session_new=insert_mysql('sessions',$ses_arr);

///////////




$payment_types=array(

'Efectivo'

);

$additional_payments=explode(";",$application_config['additional_payment_types']);

foreach($additional_payments as $a_p){

$n_p=str_replace(":voucher","",$a_p);
array_push($payment_types,$n_p );

}
$x=1;

$pagos_completos_array=array();


$sesiones_abiertas=select_mysql("*","sessions","status=0");

foreach($sesiones_abiertas['result'] as $sess){

$user_box=$sess['session_id'];

foreach($payment_types as $pt){
$ammount=select_mysql("sum(payment_amount) as ammount","sales_payments",'session_box='.$user_box." and payment_type='".$pt."'");
$initial_am=select_mysql("sum(start) as ammount","closures",'session_box='.$user_box." and payment_type='".$pt."'");
$init=array(

'end' =>$ammount['result'][0]['ammount']+$initial_am['result'][0]['ammount'],
'system_end' =>$ammount['result'][0]['ammount']+$initial_am['result'][0]['ammount'],
'force_closed'=>$user_array['person_id'],
'global_id'=>$session_new['last_id']

);
$g[$x]=update_mysql('closures',$init,'session_box='.$user_box." and payment_type='".$pt."'");


$pagos_completos_array[$pt]['start']+=$initial_am['result'][0]['ammount'];
$pagos_completos_array[$pt]['end']+=$ammount['result'][0]['ammount']+$initial_am['result'][0]['ammount'];

log_me($g[$x]['query']);
$x++;
}

$u=update_mysql('sessions',array('status'=>'1','date_end'=>date("Y-m-d H:i:s"),'force_closed'=>$user_array['person_id'],'global_id'=>$session_new['last_id']),'session_id='.$user_box);

}


///LLENA LA SESIÓN ESPECIAL

foreach($pagos_completos_array as $k=>$v){

$init=array(

'employee_id' =>$user_array['person_id'],
'session_box' =>$session_new['last_id'],
'start' =>$pagos_completos_array[$k]['start'],
'payment_type' =>$k,
'end' =>$pagos_completos_array[$k]['end'],
'system_end' =>$pagos_completos_array[$k]['end'],
'force_closed'=>$user_array['person_id'],
'is_general'=>'1'

);
$g[]=insert_mysql('closures',$init);


}


?>
<script>
alert("Todas las Sesiones de Caja Activas se han Cerrado!!!");
window.location.href="?mod=cierre_general&proc=main";
</script>


		
<?php
load_template('partial','footer');
}


?>
