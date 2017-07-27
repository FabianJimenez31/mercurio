<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){


$info=item_info($_GET['item_id']);

?>


<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button data-dismiss="modal" class="close" type="button">X</button>
			<h3> Información del Artículo <?php echo $info['info']['name']; ?></h3>
		</div>
		<div class="modal-body ">

			<div class="row">
				<div class="col-md-12">


			<div class="form-group">
				<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label   wide">UPC/EAN/ISBN:</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo $info['info']['item_number']; ?>					
				</div>
			</div>

			<div class="form-group">
				<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label   wide">ID de Producto:</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo $info['info']['product_id']; ?>					
				</div>
			</div>


			<div class="form-group">
				<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label   wide">Nombre:</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo $info['info']['name']; ?>				
				</div>
			</div>



			<div class="form-group">
				<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label   wide">Categoría:</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo $info['info']['category']; ?>				
				</div>
			</div>


			<div class="form-group">
				<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label   wide">Cantidad Actual::</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<?php echo $info['count']; ?>				
				</div>
			</div>
					
				</div>
			</div>
	
			<div class="modal-footer">
				<div class="form-acions">
					<!--<input type="submit" name="submit" value="Aceptar" id="submit" class="submit_button btn btn-primary btn-block"  />-->					<i id="spin" class="fa fa-spinner fa fa-spin fa fa-2x hidden"></i>
					<span id="error_message" class="text-danger">&nbsp;</span>
				</div>
				
			</div>

		
			
		</div>
	</div>
</div>	



<?php

}


?>
