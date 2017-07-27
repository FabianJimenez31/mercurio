<h2>NUEVA TIENDA</h2>


<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form('create-user','?module=admin_portal&action=import_client_mysql_check');" enctype="multipart/form-data" >
<br/>
{[resp]}
<br/><br/>
<div class="ui-field-contain ">
    <label for="user">Usuario MySQL:</label>
    <input id="user"  name="user" type="text" value="{[user]}"  />
</div>

<div class="ui-field-contain ">
    <label for="password">Contraseña MySQL:</label>
    <input id="password"  name="password" type="text" value="{[password]}" />
</div>


<div class="ui-field-contain ">
    <label for="host">Host MySQL:</label>
    <input id="host"  name="host" type="text" value="{[host]}" />
</div>

<div class="ui-field-contain ">
    <label for="database">Nombre de Base de Datos MySQL:</label>
    <input id="database"  name="database" type="text" value="{[database]}"  />
</div>

<div class="ui-field-contain ">
    <label for="prefix">Prefijo de Tablas MySQL:</label>
    <input id="prefix"  name="prefix" type="text" value="{[prefix]}"  />
</div>

<div class="ui-field-contain ">
    <label for="name">Nombre de la Nueva Tienda:</label>
    <input id="name"  name="name" type="text" value="{[name]}"  />
</div>

<div class="ui-field-contain ">
    <label for="aliases">Alias de la Nueva Tienda:</label>
    <input id="aliases"  name="aliases" type="text" value="{[aliases]}"  />
</div>



<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Continuar" /></div>
<br/>
</form>
</div>
