<?php

global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){


?>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label"><?php echo label_me('search_by'); ?> <?php echo label_me('dates'); ?></label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles"  action="?mod=contratos&proc=list" method='POST'>
					<div class="form-group">
						<label for="finicio" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('start_date'); ?> :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="finicio" class='datepicker' value="<?php echo date("Y-m-d"); ?>" >
						</div>
					</div>



					<div class="form-group">
						<label for="ffinal" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('end_date'); ?> :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="ffinal" class='datepicker' value="<?php echo date("Y-m-d"); ?>" >
						</div>
					</div>
										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('search'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>
<script>

	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"	});

</script>




<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label"><?php echo label_me('search_by'); ?> <?php echo label_me('number_of'); ?> <?php echo label_me('contract'); ?></label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles"  action="?mod=contratos&proc=list" method='POST'>
					<div class="form-group">
						<label for="contrato" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('number_of'); ?> <?php echo label_me('contract'); ?>:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="contrato"  value="" >
						</div>
					</div>


										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('search'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label"><?php echo label_me('search_by'); ?> <?php echo label_me('number_of'); ?> <?php echo label_me('invoice'); ?></label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles"  action="?mod=contratos&proc=list" method='POST'>
					<div class="form-group">
						<label for="factura" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('number_of'); ?> <?php echo label_me('invoice'); ?>:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="factura" value="" >
						</div>
					</div>


										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('search'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label"><?php echo label_me('search_by'); ?> <?php echo label_me('phone_number'); ?></label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles"  action="?mod=contratos&proc=list" method='POST'>
					<div class="form-group">
						<label for="telefono" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('phone_number'); ?> :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="telefono"  value="" >
						</div>
					</div>


										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('search'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>

<?php



}
load_template('partial','footer');
?>
