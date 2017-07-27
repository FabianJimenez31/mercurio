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
				<h5><label for="report_date_range_label"><?php echo label_me('date_rank'); ?> <?php echo label_me('for'); ?> <?php echo label_me('export'); ?> <?php echo label_me('csv_file'); ?></label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles" target="_blank" action="?mod=contable&proc=export" method='POST'>
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
				<input type="submit" name="submitf" value="<?php echo label_me('generate'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>
<script>

	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"	});

</script>
<?php



}
load_template('partial','footer');
?>
