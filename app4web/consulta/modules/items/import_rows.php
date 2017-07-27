<?php
global $user_array;
load_template('partial','header');
load_template('partial','menu');
if(permitido($user_array['person_id'],$_GET['mod'])){



$inputFileName=$_FILES["import"]["tmp_name"];

try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

$row=1;

$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);

$opciones="<option value='-1'></option>";
foreach($rowData[0] as $m=>$v){

if($v && $v!=''){$opciones.="<option value='$m'>$v</option>";}

}
$target_file=guid().".xlsx";
move_uploaded_file($_FILES["import"]["tmp_name"], APPDIR."tmp/".$target_file);
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





<form data-ajax="false" action="?mod=items&proc=import_complete" method="POST" enctype="multipart/form-data">
Seleccione los Campos correspondientes a Tomar en cuenta:
 
<input type='hidden' value='<?php echo $target_file; ?>' name='filetoimport'/>


						<div class="control-group">
							<label for="item_number" class="wide control-label"><b>UPC/EAN/ISBN:</b></label>
							<div class="controls">
								<select  name="item_number" id="item_number">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="product_id" class="wide control-label"><b>Identificación del producto:</b></label>
							<div class="controls">
								<select  name="product_id" id="product_id">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="name" class="wide control-label"><b>Nombre:</b></label>
							<div class="controls">
								<select  name="name" id="name">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="category" class="wide control-label"><b>Categoría:</b></label>
							<div class="controls">
								<select  name="category" id="category">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>


						<div class="control-group">
							<label for="size" class="wide control-label"><b>Tamaño:</b></label>
							<div class="controls">
								<select  name="size" id="size">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="supplier_id" class="wide control-label"><b>Proveedor:</b></label>
							<div class="controls">
								<select  name="supplier_id" id="supplier_id">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>


						<div class="control-group">
							<label for="reorder_level" class="wide control-label"><b>Mínimo de productos:</b></label>
							<div class="controls">
								<select  name="reorder_level" id="reorder_level">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>


						<div class="control-group">
							<label for="description" class="wide control-label"><b>Descripción:</b></label>
							<div class="controls">
								<select  name="description" id="description">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="color" class="wide control-label"><b>Color:</b></label>
							<div class="controls">
								<select  name="color" id="color">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="is_serialized" class="wide control-label"><b>Tiene Numero de Serie:</b></label>
							<div class="controls">
								<select  name="is_serialized" id="is_serialized">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>


						<div class="control-group">
							<label for="cost_price" class="wide control-label"><b>Costo (Sin Impuesto):</b></label>
							<div class="controls">
								<select  name="cost_price" id="cost_price">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="unit_price" class="wide control-label"><b>Precio de Venta:</b></label>
							<div class="controls">
								<select  name="unit_price" id="unit_price">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="promo_price" class="wide control-label"><b>Precio Promocional:</b></label>
							<div class="controls">
								<select  name="promo_price" id="promo_price">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="start_date" class="wide control-label"><b>Promo Fecha de Inicio:</b></label>
							<div class="controls">
								<select  name="start_date" id="start_date">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="end_date" class="wide control-label"><b>Promo Fecha de Finalización:</b></label>
							<div class="controls">
								<select  name="end_date" id="end_date">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="iva" class="wide control-label"><b>IVA (Se agregará en Venta):</b></label>
							<div class="controls">
								<select  name="iva" id="iva">
									<?php echo $opciones; ?>
								</select>								
							</div>
						</div>

						<div class="control-group">
							<label for="item_id" class="wide control-label"><b>ID de Articulo:</b></label>
							<div class="controls">
								<select  name="item_id" id="item_id">
									<?php echo $opciones; ?>
								</select>								
							</div>
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
}
load_template('partial','footer');
 ?>
