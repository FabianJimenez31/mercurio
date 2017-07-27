<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$info_a=select_mysql("*","requisitions","requisitionId='".$_GET['req_id']."'");
$info['info']=$info_a['result'][0];

?>


<form action="?mod=accepts&proc=save_new" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">

<input type="hidden" name="parent" value="<?php echo $_GET['req_id']; ?>"/>
<input type="hidden" name="main" value="<?php echo ($info['info']['main_id']>0)?$info['info']['main_id']:$_GET['req_id']; ?>"/>
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Nueva Orden de Pedido</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">
					<div class="form-group">
						<label for="req_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Numero de Orden:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="req_id" value="<?php echo $info['info']['requisitionNumber']; ?>-00SUB" id="req_id" class="form-control form-inps"  />						</div>
					</div>

					
					<div class="form-group">
					<label for="comment" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Comentarios:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="comment" cols="17" rows="5" id="comment" class="form-control  form-textarea" ><?php echo $info['info']['comment']; ?></textarea>						</div>
					</div>


					<div class="form-group offset1">
					<label for="eta" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">ETA:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					   
			
				    <div class="input-group date datepicker" data-date="" data-date-format="mm\/dd\/yyyy">
  					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="eta" value="<?php echo $info['info']['eta']; ?>" id="start_date" class="form-control form-inps"  /> </div>

				    </div>
				</div>

                    <div class="clear"></div>
				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Aceptar" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>
		

<script type='text/javascript'>
//validation and submit handling
$(document).ready(function()
{

	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"	});
   	

});

</script>




		
		
<?php
load_template('partial','footer');
}


?>
