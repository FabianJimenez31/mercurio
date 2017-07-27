<h2>EDITANDO PLAN DE FACTURACION: {[name]} </h2>


<div class="form-responsive">

<form id="edit-plan" onsubmit="javascript:return submit_form('edit-plan','?module=admin_portal&action=update_plan');">

    <input name="id" type="hidden" value="{[id]}"  />
<div class="ui-field-contain ">
    <label for="name">Nombre:</label>
    <input id="name"  name="name" type="text" value="{[name]}" />
</div>

<div class="ui-field-contain ">
    <label for="description">Descripción:</label>
    <textarea name="description" id=description >{[description]}</textarea>
</div>


<div class="ui-field-contain ">
    <label for="country">País:</label>
<select name="country" id="country" data-native-menu="false">
	<option value="MX" {[mex]} >México</option>
	<option value="CO" {[col]}>COLOMBIA</option>
</select>
</div>

<div class="ui-field-contain ">
    <label for="cost">Costo Mensual:</label>
<input type="number" name="cost" pattern="[0-9]*" id="cost" value="{[cost]}">
</div>

<div class="ui-field-contain ">
    <label for="billing_method">Tipo de Servicio:</label>
<select name="billing_method" id="billing_method" data-native-menu="false">
	<option value="XCANAL" {[chan]}>Por Canal</option>
	<option value="XEXTENSION" {[exte]}>Por Extensión</option>
</select>
</div>

<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Guardar Cambios" /></div>
<br/>
</form>
</div>
