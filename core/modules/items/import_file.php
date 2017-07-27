<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){

?>


<div class="clear"></div>
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Importación en lote de archivo Excel</h5>
					
				</div>
				<div class="widget-content">
					<ul class="text-error" id="error_message_box"></ul>
					<form action="?mod=items&proc=import_rows" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal" enctype="multipart/form-data">					<h2>Paso 1: </h2>
					<p>Descargue el Archivo de Artículos Actual para agregar / actualizar su inventario.</p>
					
					<a class="btn btn-info btn-sm " href="?mod=items&proc=export">Descargar Excel Plantilla</a>
						
					<h2>Paso 2: </h2>
					<p>Cargue el archivo del paso 1 para completar sus adiciones inventario / actualizaciones</p>
						<div class="control-group">
							<label for="name" class="wide control-label">La ruta del archivo:</label>							<div class="controls">
								<input type="file" name="import" value="" id="import"  />							</div>
						</div>
						<div class="form-actions">
							<input type="submit" name="submitf" value="Aceptar" id="submitf" class="btn btn-primary"  />	
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>




<?php 
load_template('partial','footer');
} ?>
