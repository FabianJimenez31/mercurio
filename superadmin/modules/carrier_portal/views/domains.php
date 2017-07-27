<h2>DOMINIOS</h2>

<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('carrier_portal','new_domain');">Nuevo Dominio</a>
<br/>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th>Nombre</th>
         <th data-priority="3">Dominio</th>
         <th data-priority="1">Extensiones</th>
         <th data-priority="1">Estado</th>
       </tr>
     </thead>
     <tbody>

!foreach {[servers]} as ser!
<tr>
<td><a href="#" onclick="javascript:load_page_get('carrier_portal','edit_domain','&domain_id={[ser:id]}');" >{[ser:name]}</td>
<td>{[ser:domain]}</td>
<td>{[ser:extensions]}</td>
<td>{[ser:status]}</td>
</tr>
!end ser!

     </tbody>
</table>

<script>
$(document).ready(function() {
    $('#server-table').DataTable({
});
} );
</script>
