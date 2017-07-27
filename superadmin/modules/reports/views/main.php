<h2>REPORTES DE PRODUCCIÓN</h2>

<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form('create-user','?module=reports&action=generated');" enctype="multipart/form-data" >


					<h5>Seleccione un Rango de Fechas</h5>

					<div class="ui-field-contain offset1">
					<label for="start_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Fecha de Inicio:</label>					
					   
			
				    <input type="date" name="start_date" value="{[now]}" id="start_date"   /> 
				</div>


					<div class="ui-field-contain offset1">
					<label for="end_date" class="col-sm-3 col-md-3 col-lg-2 control-label text-info wide">Fecha de Finalización:</label>								  
					<input type="date" name="end_date" value="{[now]}" id="end_date"   /> 
				</div>
				
					
							
<div class="ui-field-contain">
    <label for="rep_type">Tipo de Reporte:</label>
    <select name="rep_type" id="rep_type" data-mini="true" data-native-menu="false">
        <option value="store">Ventas por Tienda</option>
        <option value="salesman">Ventas por Vendedor</option>
        <option value="inventory">Inventario Global</option>
    </select>
</div>
<div class="ui-field-contain">
    <label>
        <input type="checkbox" name="by_date" value='1'>Separar Por Día (puede demorar un poco mas)
    </label>
</div>
		
				
			
<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Continuar..." /></div>
			</form>			


</div>
		





		
		
<?php
load_template('partial','footer');
}


?>
