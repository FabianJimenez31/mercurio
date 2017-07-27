<?php
global $user_array;
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
$options.="<option value=$x disabled>Caja $x - Usada por ".$employee['result'][0]['first_name']." ".$employee['result'][0]['last_name']."</option>";

}

}


?>


<form action="?mod=sales&proc=start_day_save" onsubmit="javascript:return confirm('¿Desea Iniciar el Día con estos montos?');" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Apertura de Caja</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


 					<div class="form-group">
					<label for="session_box" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Caja de Cobro</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="session_box" class="form-control form-inps">
							<?php echo $options; ?>
						</select>
						</div>
					</div>


<?php 
$total_types=0;
foreach($payment_types as $pt){
$total_types++;

 ?>

 					<div class="form-group">
					<label for="payment_type_<?php echo $total_types?>" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $pt; ?></label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="payment_type_<?php echo $total_types?>" value="0" id="first_name" class="form-control form-inps"  />						</div>
					</div>
			
<?php
}
?>


<input type="hidden" name='campos' value='<?php echo $total_types;?>'/>

					


				


				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" value="Aceptar" class="submit_button btn btn-primary"  />				</div>
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
