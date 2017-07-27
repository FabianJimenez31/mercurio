<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$info=item_info($_GET['item_id']);

$metass=select_mysql("*","categorias","status!=3");
$metas_opciones="<option value='0'>Ninguno</option>";
foreach($metass['result'] as $met){
$selected=($met['id']==$info['info']['categoria_id'])?' SELECTED ':'';
$metas_opciones.="<option value='".$met['id']."' $selected>".$met['name']."</option>";

}
?>


<form action="?mod=items&proc=save&item_id=<?php echo $_GET['item_id'];?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			Los campos en rojo son requeridos			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Infomación del Artículo <?php echo $info['info']['name']; ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">
					<div class="form-group">
						<label for="item_number" class="col-sm-3 col-md-3 col-lg-2 control-label wide">UPC/EAN/ISBN:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="item_number" value="<?php echo $info['info']['item_number']; ?>" id="item_number" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
						<label for="product_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Identificación del producto:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="product_id" value="<?php echo $info['info']['product_id']; ?>" id="product_id" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="name" value="<?php echo $info['info']['name']; ?>" id="name" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
					<label for="category" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Categoría:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="category" value="<?php echo $info['info']['category']; ?>" id="category" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
				<label for="categoria_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Categoria de Comisiones:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="categoria_id"  id="categoria_id">
							<?php echo $metas_opciones; ?>
						</select>
						</div>
					</div>



					<div class="form-group">
					<label for="size" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Tamaño:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="size" value="<?php echo $info['info']['size']; ?>" id="size" class="form-control form-inps"  />						</div>
					</div>


					<div class="form-group">
					<label for="supplier" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Proveedor:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="supplier_id" class="span3">
<?php

$prov=select_mysql("*","suppliers");

foreach($prov['result'] as $p){
$checked=($info['info']['supplier_id']==$p['person_id']) ? 'selected' : '';
echo "<option value=\"".$p['person_id']."\" $checked >".$p['company_name']."</option>";

}

?>
</select>						</div>
					</div>
					
					<div class="form-group reorder-input ">
					<label for="reorder_level" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mínimo de productos:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="reorder_level" value="<?php echo number_format($info['info']['reorder_level'],0); ?>" id="reorder_level" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
					<label for="description" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Descripción:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="description" cols="17" rows="5" id="description" class="form-control  form-textarea" ><?php echo $info['info']['description']; ?></textarea>						</div>
					</div>


					<div class="form-group">
					<label for="description" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Color:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="color" value="<?php echo $info['info']['color']; ?>" id="color" class="form-control form-inps"  />						</div>
					</div>


					<div class="form-group">
					<label for="is_serialized" class="col-sm-3 col-md-3 col-lg-2 control-label wide">El Artículo tiene Número de Serie o Requiere Número de Contrato (Servicios):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="checkbox" name="is_serialized" <?php echo ($info['info']['is_serialized'])==1 ? 'checked' : '' ; ?> value="1" id="is_serialized" class="form-control delete-checkbox"  />						</div>
					</div>

					<div class="form-group">
					<label for="is_service" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Es Servicio:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="checkbox" name="is_service" <?php echo ($info['info']['is_service'])==1 ? 'checked' : '' ; ?> value="1" id="is_service" class="form-control delete-checkbox"  />						</div>
					</div>

					<div class="form-group">
					<label for="postpay" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Es Post-pago <small>(El primer pago aparecerá con costo 0)</small>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="checkbox" name="postpay" <?php echo ($info['info']['postpay'])==1 ? 'checked' : '' ; ?> value="1" id="postpay" class="form-control delete-checkbox"  />						</div>
					</div>
					
			


					<div class="form-group">
					<label for="val_serial" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Validar Serial en Venta:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="checkbox" name="val_serial" <?php echo ($info['info']['val_serial'])==1 ? 'checked' : '' ; ?> value="1" id="val_serial" class="form-control delete-checkbox"  />						</div>
					</div>
					
				</div>


			<div class="widget-title widget-title1 pricing-widget">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5>Precios e Inventario</h5>
			</div>
											<div class="form-group">
							<label for="cost_price" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Costo (Sin Impuesto):</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="text" name="cost_price" value="<?php echo number_format($info['info']['cost_price'],2,".",""); ?>" size="8" id="cost_price" class="form-control form-inps"  />								</div>
						</div>
					
				<div class="form-group">
				<label for="unit_price" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Precio de venta:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					<input type="text" name="unit_price" value="<?php echo number_format($info['info']['unit_price'],2,".",""); ?>" size="8" id="unit_price" class="form-control form-inps"  />					</div>
				</div>

				
				<div class="form-group">
				<label for="promo_price" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Precio promocional:</label>				    <div class="col-sm-9 col-md-9 col-lg-10">
				    <input type="text" name="promo_price" value="<?php echo number_format($info['info']['promo_price'],2,".",""); ?>" size="8" class="form-inps" id="promo_price"  />				    </div>
				</div>

					<div class="form-group offset1">
					<label for="start_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Promo Fecha de Inicio:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					   
			
				    <div class="input-group" >
  					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="start_date" value="<?php echo $info['info']['start_date']; ?>" id="start_date" class="datepicker"  /> </div>

				    </div>
				</div>


					<div class="form-group offset1">
					<label for="end_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Promo Fecha de finalización:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					   
			
				    <div class="input-group" >
  					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="end_date" value="<?php echo $info['info']['end_date']; ?>" id="end_date" class="datepicker"  /> </div>

				    </div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">IVA (Se agregará en Venta):</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" value="<?php echo $info['info']['iva']; ?>" name="iva"  class="form-control form-inps" />
					</div>
				</div>



<?php for($xt=1;$xt<=10;$xt++){


?>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Precio especial <?php echo $xt?>:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" value="<?php echo number_format($info['info']['tier_'.$xt],2,".",""); ?>" name="tier_<?php echo $xt; ?>"  class="form-control form-inps" />
					</div>
				</div>



				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Etiqueta para Precio especial <?php echo $xt?>:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" value="<?php echo $info['info']['tier_'.$xt.'_name']; ?>" name="tier_<?php echo $xt; ?>_name"  class="form-control form-inps" />
					</div>
				</div>


				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mostrar Precio especial <?php echo $xt?>:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="tier_<?php echo $xt; ?>_allow"  class="form-control form-inps" >
						  <option value="Y" <?php echo ($info['info']['tier_'.$xt.'_allow']=="Y")?" selected ":"";?> >Si</option>
						  <option value="N" <?php echo ($info['info']['tier_'.$xt.'_allow']=="Y")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

<?php


}?>

				





			<div class="widget-title widget-title1 pricing-widget">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5>Reservaciones</h5>
			</div>
											<div class="form-group">
							<label for="precio_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Precio de Reservación:</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="number" name="precio_preventa" value="<?php echo number_format($info['info']['precio_preventa'],2,".",""); ?>" size="8"  class="form-control form-inps"  />								</div>
						</div>


											<div class="form-group">
							<label for="precio_preventa_agotada" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Precio de Reservación [Agotado]:</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="number" name="precio_preventa_agotada" value="<?php echo number_format($info['info']['precio_preventa_agotada'],2,".",""); ?>" size="8" class="form-control form-inps"  />								</div>
						</div>
					

											<div class="form-group">
							<label for="preventa_disponibles" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Disponibles para Reservación:</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="number" name="preventa_disponibles" value="<?php echo number_format($info['info']['preventa_disponibles'],2,".",""); ?>" size="8"  class="form-control form-inps"  />								</div>
						</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mostrar en Reservación:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="mostrar_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['mostrar_preventa']=="1")?" selected ":"";?> >Si</option>
						  <option value="0" <?php echo ($info['info']['mostrar_preventa']=="1")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Permitir Reservar Sin Disponibles:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="bloquear_na_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['bloquear_na_preventa']=="1")?" selected ":"";?> >No</option>
						  <option value="0" <?php echo ($info['info']['bloquear_na_preventa']=="1")?"":" selected ";?>>Si</option>
						</select>
					</div>
				</div>


					<div class="form-group">
					<label for="mensaje_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mensaje Previo Reservación:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="mensaje_preventa" cols="17" rows="5" id="mensaje_preventa" class="form-control  form-textarea" ><?php echo $info['info']['mensaje_preventa']; ?></textarea>						</div>
					</div>
				

					<div class="form-group">
					<label for="mensaje_exito" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mensaje Reservación Exitosa:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="mensaje_exito" cols="17" rows="5" id="mensaje_exito" class="form-control  form-textarea" ><?php echo $info['info']['mensaje_exito']; ?></textarea>						</div>
					</div>


					<div class="form-group">
					<label for="mensaje_agotado" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mensaje Reservación Fallida:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="mensaje_agotado" cols="17" rows="5" id="mensaje_agotado" class="form-control  form-textarea" ><?php echo $info['info']['mensaje_agotado']; ?></textarea>						</div>
					</div>
				

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mostrar Disponibles:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="mostrar_disponibles_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['mostrar_disponibles_preventa']=="1")?" selected ":"";?> >Si</option>
						  <option value="0" <?php echo ($info['info']['mostrar_disponibles_preventa']=="1")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Mostrar Turno:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="mostrar_turno_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['mostrar_turno_preventa']=="1")?" selected ":"";?> >Si</option>
						  <option value="0" <?php echo ($info['info']['mostrar_turno_preventa']=="1")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Limitar Unidades:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="desduplicar_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['desduplicar_preventa']=="1")?" selected ":"";?> >Si</option>
						  <option value="0" <?php echo ($info['info']['desduplicar_preventa']=="1")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

											<div class="form-group">
							<label for="maximo_telefono_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Maximo por Telefono:</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="number" name="maximo_telefono_preventa" value="<?php echo number_format($info['info']['maximo_telefono_preventa'],2,".",""); ?>" size="8"  class="form-control form-inps"  />								</div>
						</div>

											<div class="form-group">
							<label for="maximo_correoelectronico_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Maximo por Correo Electronico:</label>								<div class="col-sm-9 col-md-9 col-lg-10">
									<input type="number" name="maximo_correoelectronico_preventa" value="<?php echo number_format($info['info']['maximo_correoelectronico_preventa'],2,".",""); ?>" size="8"  class="form-control form-inps"  />								</div>
						</div>


				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Permitir Vender Reservados:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="mezclar_disponibles_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['mezclar_disponibles_preventa']=="1")?" selected ":"";?> >No</option>
						  <option value="0" <?php echo ($info['info']['mezclar_disponibles_preventa']=="1")?"":" selected ";?>>Si</option>
						</select>
					</div>
				</div>


				<div class="form-group">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Permitir Reservar Fuera de Fecha:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<select name="mostrar_afterfecha_preventa"  class="form-control form-inps" >
						  <option value="1" <?php echo ($info['info']['mostrar_afterfecha_preventa']=="1")?" selected ":"";?> >Si</option>
						  <option value="0" <?php echo ($info['info']['mostrar_afterfecha_preventa']=="1")?"":" selected ";?>>No</option>
						</select>
					</div>
				</div>

					<div class="form-group offset1">
					<label for="mostrar_inicio_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Fecha de Inicio de Reservaciones:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					   
			
				    <div class="input-group" >
  					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="mostrar_inicio_preventa" value="<?php echo $info['info']['mostrar_inicio_preventa']; ?>" id="mostrar_inicio_preventa" class="datepicker"  /> </div>

				    </div>
				</div>


					<div class="form-group offset1">
					<label for="mostrar_final_preventa" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Fecha de Cierre de Reservaciones:</label>					<div class="col-sm-9 col-md-9 col-lg-10">
					   
			
				    <div class="input-group" >
  					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="mostrar_final_preventa" value="<?php echo $info['info']['mostrar_final_preventa']; ?>" id="mostrar_final_preventa" class="datepicker"  /> </div>

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
   	

	
	$( "#category" ).autocomplete({
		source: "?mod=items&proc=suggest_category",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});

	$('#item_form').validate({
		submitHandler:function(form)
		{
			$.post('?mod=items&proc=check_duplicate&item_id=<?php echo $_GET['item_id'];?>', {term: $('#name').val()},function(data) {
						if(data.duplicate)
				{
					
					if(confirm("Ya existe un \u00edtem con ese nombre. Continuar?"))
					{
						doItemSubmit(form);
					}
					else 
					{
						return false;
					}
				}
						 {
				doItemSubmit(form);
			 }} , "json")
		     .error(function() {
		 });
		},
		errorClass: "text-danger",
		errorElement: "span",
			highlight:function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			},
		rules:
		{
					item_number:
			{
				remote: 
				    { 
					url: "?mod=items&proc=item_number_exists&item_number=<?php echo $_GET['item_id'];?>",  
					type: "post"
					
				    } 
			},
				
				
			name:"required",
			category:"required",
			cost_price:
			{
				required:true,
				number:true
			},

			unit_price:
			{
				required:true,
				number:true
			},
			promo_price:
			{
				number: true
			},
			reorder_level:
			{
				number:true
			},
   		},
		messages:
		{			
						item_number:
			{
				remote: "UPC \/ EAN \/ ISBN que ya existe"				   
			},
						
						
												
			name:"Nombre de Art\u00edculo es requerido",
			category:"Categor\u00eda es requerido",
			cost_price:
			{
				required:"Costo es requerido",
				number:"Costo debe ser n\u00famero"			},
			unit_price:
			{
				required:"Precio es requerido",
				number:"Precio unitario debe ser n\u00famero"			},
			promo_price:
			{
				number: "Este campo debe ser un n\u00famero"			}
		}
	});
});

var submitting = false;

function doItemSubmit(form)
{
	if (submitting) return;
	submitting = true;
	$("#form").mask("por favor espere ...");
	$(form).ajaxSubmit({
	success:function(response)
	{
		$("#form").unmask();
		submitting = false;
		alert(response.success ? 'Cambios Guardados Exitosamente' : 'No Fue Posible Guardar los Cambios');

		if(response.success)
		{
			alert(response.message);
			window.location.href = '?mod=items&proc=edit&item_id=<?php echo $_GET['item_id']; ?>'
		}

	
			},
		resetForm: true,
		dataType:'json'
	});
}

</script>




		
		
<?php
load_template('partial','footer');
}


?>
