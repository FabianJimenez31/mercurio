<h2>Actualizaciones</h2>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th data-priority="2">Actualizacion</th>
         <th>Tipo</th>
         <th data-priority="3">Estado</th>
       </tr>
     </thead>
     <tbody>

!foreach {[servers]} as ser!
<tr>
<td>{[ser:version]}</td>
<td>{[ser:type]}</td>
<td>{[ser:status]}</td>
!end ser!

     </tbody>
</table>


       <a href="#main_content" onclick="javascript:load_page('admin_portal','servers');">Actualizar</a>

<script>
$(document).ready(function() {
    $('#server-table').DataTable({
	"bPaginate": false
});
} );
</script>
