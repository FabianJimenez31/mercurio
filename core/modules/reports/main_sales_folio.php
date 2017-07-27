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
				<h5><label for="report_date_range_label">Folio Interno</label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles" action="?mod=reports&proc=sales_report_folio" method='POST'>
					<div class="form-group">
						<label for="finicio" class="col-sm-3 col-md-3 col-lg-2 control-label   ">Folio Interno :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="folio" value="" >
						</div>
					</div>


										<div class="form-actions">
				<input type="submit" name="submitf" value="Generar" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>

<?php



}
load_template('partial','footer');
?>
