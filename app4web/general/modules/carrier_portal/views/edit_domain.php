<h2>EDITANDO DOMINIO {[shortname]} [ {[domain]} ] </h2>


<div class="form-responsive">

<form id="create-plan" onsubmit="javascript:return submit_form('create-plan','?module=carrier_portal&action=update_domain');">


<div class="ui-field-contain ">
    <label for="shortname">Nombre:</label>
    <input id="shortname"  name="shortname" type="text" value="{[shortname]}" />
</div>

<div class="ui-field-contain ">
    <label for="status">Activo:</label>
	<select id="status"  name="status" >
		<option value="1" {[active_field_yes]} >Si</option>
		<option value="2" {[active_field_no]} >No</option>
		<option value="3">Eliminar</option>
	</select>
</div>

    <input id="id"  name="id" type="hidden" value='{[id]}'  />

<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Guardar Cambios" /></div>
<br/>
</form>
</div>
