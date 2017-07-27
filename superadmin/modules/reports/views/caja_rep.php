<h2>Reporte de Sesiones de Caja del {[start]} al {[end]}</h2>

{[update_repo]}

<ul data-role="listview" data-inset="true" data-shadow="false">


  <li>
<h2>Reporte</h2>
<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th data-priority="2">Tienda</th>
         <th>ID de Sesión</th>
         <th data-priority="3">Cajero</th>
         <th data-priority="3">Caja de Cobro</th>
         <th data-priority="3">Inicio</th>
         <th data-priority="3">Final</th>
         <th data-priority="3">Estado</th>
       </tr>
     </thead>
     <tbody>

!foreach {[results]} as ser!
<tr>
<td>{[ser:tienda]}</td>
<td>{[ser:id_sesion]}</td>
<td>{[ser:cajero_name]}</td>
<td>{[ser:caja]}</td>
<td>{[ser:inicio]}</td>
<td>{[ser:final]}</td>
<td><a title="{[ser:adicional_cerrado]}" >{[ser:estado]}</a> </td>
</tr>
!end ser!

     </tbody>
</table>


<script>
$(document).ready(function() {
    $('#server-table').DataTable({
	"bPaginate": false
});
} );
</script>

</li>

</ul>


