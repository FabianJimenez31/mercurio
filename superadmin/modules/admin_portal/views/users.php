<h2>TIENDAS</h2>


<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','new_client');">Nueva Tienda</a>
<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','import_client');">Importar Tienda (Desde Archivo)</a>
<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','import_client_mysql');">Importar Tienda (MySQL)</a>
<br/>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th data-priority="2">ID</th>
         <th>Nombre</th>
         <th data-priority="3">Prefijo DB</th>
         <th data-priority="4">Ubicación</th>
         <th data-priority="4">Alias</th>
         <th data-priority="4">Operaciones</th>
       </tr>
     </thead>
     <tbody>

!foreach {[users]} as plan!
<tr>
<td>{[plan:id]}</td>
<td><a href="#" onclick="javascript:load_page_get('admin_portal','plan_edit','&plan_id={[plan:id]}');" >{[plan:name]}</a></td>
<td>{[plan:prefix]}</td>
<td>{[plan:shortname]}</td>
<td>{[plan:aliases]}</td>
<td><a href="?module=admin_portal&action=export_store&store_id={[plan:id]}" target="_blank" >Exportar Tienda (Archivo)</a>

| <a href="#" onclick="javascript:load_page_get('admin_portal','delete_store','&store_id={[plan:id]}');"  >Eliminar Tienda</a>
<!--<a href="#" onclick="javascript:load_page_get('admin_portal','plan_edit','&plan_id={[plan:id]}');" >Exportar Catálogo</a>
<a href="#" onclick="javascript:load_page_get('admin_portal','plan_edit','&plan_id={[plan:id]}');" >Importar Catálogo</a>-->
</td>
</tr>
!end plan!

     </tbody>
</table>

<script>
$(document).ready(function() {
    $('#server-table').DataTable({
});
} );
</script>
