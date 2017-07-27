<h2>Reporte de Tienda del {[start]} al {[end]}</h2>

{[update_repo]}

<ul data-role="listview" data-inset="true" data-shadow="false">

{[graph]}

{[mas_vendidos]}


  <li>
<h2>Reporte</h2>
<table id="server-table"  class="display" width="100%">
     <thead class="ui-bar-a ui-corner-all">
       <tr>
	{[date_th]}
         <th data-priority="2">Tienda</th>
         <th>Ventas</th>
         <th data-priority="3">Articulos Vendidos</th>
         <th data-priority="3">Ingreso</th>
       </tr>
     </thead>
     <tbody>

!foreach {[results]} as ser!
<tr>
{[date_td]}{[ser:fecha]}{[date_td_end]}
<td>{[ser:tienda]}</td>
<td>{[ser:ventas]}</td>
<td>
<a href="#{[ser:unico]}" data-rel="popup" class="ui-btn ui-corner-all ui-shadow ui-btn-inline" data-transition="pop">{[ser:articulos]}</a>
<div data-role="popup" id="{[ser:unico]}" >
    <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
<p>{[ser:extras]}</p>
</div>
</td>
<td>{[ser:ingreso]}</td>
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


