<h2>NUEVO CLIENTE</h2>


<div class="form-responsive">

<form id="create-user" onsubmit="javascript:return submit_form('create-user','?module=carrier_portal&action=create_extension');">


<div class="ui-field-contain ">
    <label for="username">Número de Extension [Campo numérico]:</label>
    <input id="username"  name="username" type="number"  />
</div>

<div class="ui-field-contain ">
    <label for="related_to">Nombre:</label>
    <input id="related_to"  name="related_to" type="text"  />
</div>

<div class="ui-field-contain ">
    <label for="password">Contraseña:</label>
    <input id="password"  name="password" type="text"  />
</div>

<div class="ui-field-contain ">
    <label for="domain">Dominio:</label>
    <select id="domain"  name="domain" data-native-menu="false"  >{[domain_options]}</select>
</div>

<div class="ui-field-contain ">
    <label for="record_incoming">Grabar Llamadas Entrantes:</label>
    <select id="record_incoming"  name="record_incoming" data-native-menu="false"  ><option value="1">SI</option><option value="2">NO</option></select>
</div>

<div class="ui-field-contain ">
    <label for="record_outgoing">Grabar Llamadas Salientes:</label>
    <select id="record_outgoing"  name="record_outgoing" data-native-menu="false"  ><option value="1">SI</option><option value="2">NO</option></select>
</div>


<div class="ui-field-contain ">
    <label for="voicemail">Habilitar Buzón de Voz:</label>
    <select id="voicemail"  name="voicemail" data-native-menu="false"  ><option value="1">SI</option><option value="2">NO</option></select>
</div>

<div class="ui-field-contain ">
    <label for="email_address">Dirección de Correo Electrónico [Para notificaciones de Buzón de Voz]:</label>
    <input id="email_address"  name="email_address" type="email"  />
</div>	

<div class="ui-field-contain ">
    <label for="vm_password">Contraseña de Buzón de Voz [numérica]:</label>
    <input id="vm_password"  name="vm_password" type="number"  />
</div>
    <input id="status"  name="status" type="hidden"  />
<div class="ui-field-contain ">
    <label for="follow_me">Habilitar Sígueme:</label>
    <select id="follow_me"  name="follow_me" data-native-menu="false"  ><option value="1">SI</option><option value="2">NO</option></select>
</div>

<div class="ui-field-contain ">
    <label for="follow_me_numbers">Destinos de Sígueme <small>[ Ingrese los numeros separados por una coma (,) ]</small>:</label>
    <textarea id="follow_me_numbers"  name="follow_me_numbers" ></textarea>
</div>


<div class="submit_button" ><input type="submit"   data-mini="true" data-inline="true" value="Crear" /></div>
<br/>
</form>
</div>
