<h2>CLIENTES</h2>


<a href="#" class="ui-shadow ui-btn ui-corner-all ui-btn-inline ui-btn-icon-left ui-icon-plus" onclick="javascript:load_page('admin_portal','new_client');">Nuevo Cliente</a>
<br/>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th data-priority="2">ID</th>
         <th>Nombre</th>
         <th data-priority="3">Dominios</th>
         <th data-priority="4">País</th>
         <th data-priority="3">Estado</th>
       </tr>
     </thead>
     <tbody>

!foreach {[users]} as plan!
<tr>
<td>{[plan:id]}</td>
<td><a href="#" onclick="javascript:load_page_get('admin_portal','plan_edit','&plan_id={[plan:id]}');" >{[plan:name]}</td>
<td>{[plan:domains]}</td>
<td>{[plan:country]}</td>
<td>{[plan:status]}</td>
!end plan!

     </tbody>
</table>

<script>
$(document).ready(function() {
    $('#server-table').DataTable({
});
} );
</script>
