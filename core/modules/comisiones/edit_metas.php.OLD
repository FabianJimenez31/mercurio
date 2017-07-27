<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$inf=select_mysql("*","categorias","id=".$_GET['item_id']);
$info=$inf['result'][0];
?>


<form action="?mod=comisiones&proc=save_cat&item_id=<?php echo $_GET['item_id']?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			<?php echo label_me('red_fields'); ?> <?php echo label_me('are'); ?> <?php echo label_me('required'); ?>	
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5><?php echo label_me('informaiton'); ?> <?php echo label_me('of_account'); ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">
					<div class="form-group">
						<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="name" value="<?php echo $info['name'] ?>" id="name" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="description" class="col-sm-3 col-md-3 col-lg-2 control-label  wide"><?php echo label_me('description'); ?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="description" value="" id="description" class="form-control" rows="3" ><?php echo $info['description'] ?></textarea>
									</div>
					</div>




					
					
				</div>


								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('save_changes'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>
		





		
		
<?php
load_template('partial','footer');
}


?>
