<h2>{[main_label]}</h2>
{[error_log]}
<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form('create-user','?module=admin_portal&action=create_item');" enctype="multipart/form-data" >
{[item_id_field]}

					<h5>Infomación del Artículo</h5>
			

					<div class="ui-field-contain">
						<label for="item_number" >UPC/EAN/ISBN:</label>
						<input type="text" name="item_number" value="{[item_number]}" id="item_number" />
					</div>

					<div class="ui-field-contain">
						<label for="product_id" >Identificación del producto:</label>						
							<input type="text" name="product_id" value="{[product_id]}" id="product_id"   />
					</div>

 					<div class="ui-field-contain">
					<label for="name" >Nombre:</label>						
						<input type="text" name="name" value="{[name]}" id="name"   />
					</div>

					<div class="ui-field-contain">
					<label for="category" >Categoría:</label>						
						<input type="text" name="category" value="{[category]}" id="category"   />
					</div>

					<div class="ui-field-contain">
					<label for="size" >Tamaño:</label>						
						<input type="text" name="size" value="{[size]}" id="size"   />
					</div>

					<input type="hidden"  name='supplier_id' value="1">
					
					<div class="ui-field-contain reorder-input ">
					<label for="reorder_level" >Mínimo de productos:</label>						
						<input type="text" name="reorder_level" value="{[reorder_level]}" id="reorder_level"   />
					</div>

					<div class="ui-field-contain">
					<label for="description" >Descripción:</label>						
						<textarea name="description" cols="17" rows="5" id="description">{[description]}</textarea>
					</div>


					<div class="ui-field-contain">
					<label for="description" >Color:</label>						
						<input type="text" name="color" value="{[color]}" id="color"   />
					</div>


					<div class="ui-field-contain">
					<label for="is_serialized" >El Artículo tiene Número de Serie o Requiere Número de Contrato (Servicios):</label>						
						<input type="checkbox" {[ck_serialized]} name="is_serialized" value="1" id="is_serialized" class="form-control delete-checkbox"  />
					</div>

					<div class="ui-field-contain">
					<label for="is_service" >Es Servicio:</label>						
						<input type="checkbox" name="is_service" {[ck_service]} value="1" id="is_service" class="form-control delete-checkbox"  />
					</div>


					<div class="ui-field-contain">
					<label for="postpay" >Es Post-pago <small>(El primer pago aparecerá con costo 0)</small>:</label>						
						<input type="checkbox" name="postpay" {[ck_postpay]} value="1" id="postpay" class="form-control delete-checkbox"  />
					</div>

					<div class="ui-field-contain">
					<label for="val_serial" >Validar Serial en Venta:</label>						
						<input type="checkbox" name="val_serial" {[ck_val_serial]} value="1" id="val_serial" class="form-control delete-checkbox"  />
					</div>
					



			<div class="ui-widget-header">

				<h5>Precios e Inventario</h5>
			</div>
											<div class="ui-field-contain">
							<label for="cost_price" >Costo (Sin Impuesto):</label>								
									<input type="text" name="cost_price" value="{[cost_price]}" size="8" id="cost_price"   />								
						</div>
					
				<div class="ui-field-contain">
				<label for="unit_price" >Precio de venta:</label>					
					<input type="text" name="unit_price" value="{[unit_price]}" size="8" id="unit_price"   />					
				</div>

				
				<div class="ui-field-contain">
				<label for="promo_price" >Precio promocional:</label>				    
				    <input type="text" name="promo_price" value="{[promo_price]}" size="8" class="form-inps" id="promo_price"  />				    
				</div>

					<div class="ui-field-contain offset1">
					<label for="start_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Promo Fecha de Inicio:</label>					
					   
			
				    <input type="date" name="start_date" value="{[start_date]}" id="start_date"   /> 
				</div>


					<div class="ui-field-contain offset1">
					<label for="end_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Promo Fecha de finalización:</label>					
					   
			
				  
					<input type="date" name="end_date" value="{[end_date]}" id="end_date"   /> 
				</div>
				
				<div class="ui-field-contain override-taxes-container">
					<label >IVA (Se agregará en Venta):</label>					
					
						<input type="input" name="iva"  value="{[iva]}" />
					
				</div>


!foreach {[special_prices]} as sp!

				<div class="ui-field-contain">
					<label >Precio especial {[sp:label]}:</label>					
					
						<input type="text" value="{[tier_{[sp:label]}]}" name="tier_{[sp:label]}"   />
					
				</div>



				<div class="ui-field-contain">
					<label >Etiqueta para Precio especial {[sp:label]}:</label>					
					
						<input type="text" value="{[tier_{[sp:label]}_name]}" name="tier_{[sp:label]}_name"   />
					
				</div>


				<div class="ui-field-contain">
					<label >Mostrar Precio especial {[sp:label]}:</label>					
					
						<select name="tier_{[sp:label]}_allow"   >
						  <option value="Y" {[tier_{[sp:label]}_allch]} >Si</option>
						  <option value="N" {[tier_{[sp:label]}_alln]} >No</option>
						</select>
					
				</div>

!end sp!


					
								
		
				
			
<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Continuar..." /></div>
			</form>			


</div>
		





		
		
<?php
load_template('partial','footer');
}


?>
