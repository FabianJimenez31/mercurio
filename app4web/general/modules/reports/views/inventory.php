<h2>INFORMACION DE INVENTARIO DE PRODUCTO CON SKU {[sku]}</h2>

<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
         <th data-priority="2">Tienda</th>
         <th>Producto</th>
         <th data-priority="3">Cantidad</th>
       </tr>
     </thead>
     <tbody>

!foreach {[results]} as ser!
<tr>
<td>{[ser:tienda]}</td>
<td>{[ser:producto]}</td>
<td>{[ser:cuantos]}</td>
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




