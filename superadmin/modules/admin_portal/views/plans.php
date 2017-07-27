<h2>CATALOGO GENERAL</h2>

<div data-role="controlgroup" data-type="horizontal">

<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','item_form');">Nuevo Artículo</a>
<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','import_existing');">Importar Artículos (desde una tienda existente)</a>
<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-refresh" onclick="javascript:load_page('admin_portal','sync_items');">Sincronizar Artículos en todas las Tiendas</a>
</div>

<br/>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th >ID de Producto</th>
         <th>Nombre</th>
         <th >Categoria</th>
         <th >Costo</th>
         <th >Precio de Venta</th>
         <th >Editar</th>
       </tr>
     </thead>
     <tbody>

!foreach {[plans]} as plan!
<tr>
<td>{[plan:product_id]}</td>
<td><a href="#" onclick="javascript:load_page_get('admin_portal','item_form','&plan_id={[plan:id]}');" >{[plan:name]}</td>
<td>{[plan:category]}</td>
<td>{[plan:cost]}</td>
<td>{[plan:price]}</td>
<td><a href="#" onclick="javascript:load_page_get('admin_portal','item_form','&plan_id={[plan:id]}');" >Editar</td>
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
