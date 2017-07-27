<h2>NUEVO PLAN DE FACTURACION</h2>


<div class="form-responsive">

<form id="create-plan" onsubmit="javascript:return submit_form('create-plan','?module=admin_portal&action=create_plan');">


<div class="ui-field-contain ">
    <label for="name">Nombre:</label>
    <input id="name"  name="name" type="text"  />
</div>

<div class="ui-field-contain ">
    <label for="description">Descripción:</label>
    <textarea name="description" id=description ></textarea>
</div>


<div class="ui-field-contain ">
    <label for="country">País:</label>
<select name="country" id="country" data-native-menu="false">
	<option value="MX">México</option>
	<option value="CO">COLOMBIA</option>
</select>
</div>

<div class="ui-field-contain ">
    <label for="cost">Costo Mensual:</label>
<input type="number" name="cost" pattern="[0-9]*" id="cost" value="">
</div>

<div class="ui-field-contain ">
    <label for="billing_method">Tipo de Servicio:</label>
<select name="billing_method" id="billing_method" data-native-menu="false">
	<option value="XCANAL">Por Canal</option>
	<option value="XEXTENSION">Por Extensión</option>
</select>
</div>

<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Crear" /></div>
<br/>
</form>
</div>
