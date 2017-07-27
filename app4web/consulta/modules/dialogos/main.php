<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$config_items=select_mysql("*",'messages');
$items=$config_items['result'];
?>


<form action="?mod=dialogos&proc=create" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Creación de Etiquetas</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


					<div class="form-group">
						<label for="tag" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Nombre de Etiqueta:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="tag" value="" id="tag" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
						<label for="tag" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Valor de Etiqueta:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="label" value="" id="label" class="form-control form-inps"  />						</div>
					</div>


                    <div class="clear"></div>
				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" value="Crear"  class="submit_button btn btn-primary"  />				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>

</div>
<form action="?mod=dialogos&proc=save" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Configuración de Etiquetas</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


<?php 

foreach($items as $i){





?>
					<div class="form-group">
						<label for="<?php echo $i['tag'];?>" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $i['tag'];?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="<?php echo $i['tag'];?>" value="<?php echo utf8_decode($i['label']);?>" id="product_id" class="form-control form-inps"  />						</div>
					</div>



<?php
}






?>


 


					
                    <div class="clear"></div>
				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Guardar Cambios" id="submitf" class="submit_button btn btn-primary"  />				</div>
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
