<h2>EDITANDO CLIENTE [ {[username]} ] {[name]} {[last_name]}</h2>


<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form('create-user','?module=admin_portal&action=update_user');">


<div class="ui-field-contain ">
    <label for="name">Nombre(s):</label>
    <input id="name"  name="name" type="text"  value="{[name]}"/>
</div>

<div class="ui-field-contain ">
    <label for="last_name">Apellido(s):</label>
    <input id="last_name"  name="last_name" type="text"  value="{[last_name]}"/>
</div>

<div class="ui-field-contain ">
    <label for="address_1">Calle y Número:</label>
    <input id="address_1"  name="address_1" type="text"  value="{[address_1]}" />
</div>	

<div class="ui-field-contain ">
    <label for="address_2">Colonia/Barrio:</label>
    <input id="address_2"  name="address_2" type="text"  value="{[address_2]}"/>
</div>

<div class="ui-field-contain ">
    <label for="state">Estado/Departamento:</label>
    <input id="state"  name="state" type="text"  value="{[state]}" />
</div>

<div class="ui-field-contain ">
    <label for="citi">Municipio/Ciudad:</label>
    <input id="citi"  name="citi" type="text" value="{[citi]}" />
</div>

<div class="ui-field-contain ">
    <label for="postal_code">Código Postal:</label>
    <input id="postal_code"  name="postal_code" type="number" value="{[postal_code]}"  />
</div>


<div class="ui-field-contain ">
    <label for="country">País:</label>
<select name="country" id="country" data-native-menu="false">
	<option value="Mexico" {[mexico_sel]} >México</option>
	<option value="Colombia" {[colombia_sel]}>Colombia</option>
</select>
</div>

<div class="ui-field-contain ">
    <label for="email_address">Dirección de Correo Electrónico:</label>
    <input id="email_address"  name="email_address" type="email" value="{[email_address]}" />
</div>

<div class="ui-field-contain ">
    <label for="phone_1">Teléfono de Contacto 1:</label>
    <input id="phone_1"  name="phone_1" type="tel" value="{[phone_1]}" />
</div>

<div class="ui-field-contain ">
    <label for="phone_2">Teléfono de Contacto 2:</label>
    <input id="phone_2"  name="phone_2" type="tel" value="{[phone_2]}" />
</div>

<input type="hidden" name="id" value="{[id]}">

<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Guardar Cambios" /></div>
<br/>
</form>
</div>
