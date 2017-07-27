<h2>IMPORTACION DE INVENTARIO GENERAL DESDE TIENDA CREADA</h2>


<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form_file('create-user','?module=admin_portal&action=import_store_existing');" enctype="multipart/form-data" >


<div class="ui-field-contain ">
    <label for="tienda">Tienda:</label>
    <select id="tienda"  name="tienda" >
	{[options]}
	</select>
</div>


<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Importar" /></div>
<br/>
</form>
</div>
