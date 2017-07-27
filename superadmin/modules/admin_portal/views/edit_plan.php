<h2>EDITANDO TIENDA: {[name]} </h2>


<div class="form-responsive">

<form id="edit-plan" onsubmit="javascript:return submit_form('edit-plan','?module=admin_portal&action=update_plan');">

    <input name="id" type="hidden" value="{[id]}"  />
    <input name="shortname" type="hidden" value="{[shortname]}"  />
<div class="ui-field-contain ">
    <label for="name">Nombre:</label>
    <input id="name"  name="name" type="text" value="{[name]}" />
</div>

<div class="ui-field-contain ">
    <label for="aliases">Alias:</label>
    <input id="aliases"  name="aliases" type="text" value="{[aliases]}" />
</div>

<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Guardar Cambios" /></div>
<br/>
</form>
</div>
