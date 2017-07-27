<?php
global $user_array;
global $application_config;
global $user_box;
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

$caja_c=select_mysql('*','sessions','status=0');
$options="";
for($x=1;$x<=$application_config['company_logo'];$x++){
$op=true;
foreach($caja_c['result'] as $r){

if($r['session_box']==$x){
$op=false;
$used_by=$r['employee_is'];
}

}
if($op==true){

$options.="<option value=$x>Caja $x";

}else{
$employee=select_mysql("*","people","person_id=".$used_by);
$options.="<option value=$x disabled>".label_me('cash_line')." $x - ".label_me('used_by')." ".$employee['result'][0]['first_name']." ".$employee['result'][0]['last_name']."</option>";

}

}


?>


<form action="?mod=sales&proc=end_day_save" onsubmit="javascript:return confirm('¿<?php echo label_me('end_day'); ?>?');" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5><?php echo label_me('closure_of'); ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


<?php 
$total_types=0;
foreach($payment_types as $pt){
$total_types++;
$ammount=select_mysql("sum(payment_amount) as ammount","sales_payments",'session_box='.$user_box." and payment_type='".$pt."'");
$initial_am=select_mysql("sum(start) as ammount","closures",'session_box='.$user_box." and payment_type='".$pt."'");
 ?>

 					<div class="form-group">
					<label for="payment_type_<?php echo $total_types?>" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $pt . " [ $ ".number_format($ammount['result'][0]['ammount']+$initial_am['result'][0]['ammount'],2,",",".")." ] "; ?></label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="payment_type_<?php echo $total_types?>" value="0" id="first_name" class="form-control form-inps"  />						</div>
					</div>
			
<?php
}
?>


<input type="hidden" name='campos' value='<?php echo $total_types;?>'/>

					


				


				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" value="<?php echo label_me('accept'); ?>" class="submit_button btn btn-primary"  />				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>
		

<script type='text/javascript'>


</script>




		
		
<?php
load_template('partial','footer');
}


?>
