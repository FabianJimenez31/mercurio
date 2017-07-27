<?php

global $user_array;
global $application_config;


if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

$traslado_arr=select_mysql("*","traslados","traslados_id=".$_GET['traslados_id']);
$traslado=$traslado_arr['result'][0];

$person_array=select_mysql("*","people","person_id=".$traslado['created_by']);
$person=$person_array['result'][0];
?>

        <div class="container">
          <div class="row">
            <div class="col-md-12">

 
                  <div class="padd invoice">
                    
                    <div class="row">


                      <div class="col-md-4">
                        <h4><strong>Origen:</strong></h4>

<div id="location_text">

<?php

if($traslado['location_id']>0){

$direccion=select_mysql("*","locations","location_id=".$traslado['location_id']);

echo str_replace(array("\n","\r"),"<br/>",$direccion['result'][0]['address'])."<br/>".$direccion['result'][0]['phone']."<br/>".$direccion['result'][0]['email'];

}


?>

</div>

                      </div>





                      <div class="col-md-4">
                        <p>
  <label for="comment">Destino:</label><p>
<?php

echo str_replace(array("\n","\r"),"<br/>",$traslado['send_address']);

?>
</p>

                        </p>
                      </div>


                      <div class="col-md-4">
                        <p>
                          Creado por: <?php echo $person['first_name']." ".$person['last_name']; ?><br/>
                          <?php echo $traslado['created_at']; ?><br/>


<?php
if($traslado['sent_by']>0){
$person2_array=select_mysql("*","people","person_id=".$traslado['sent_by']);
$person2=$person2_array['result'][0];
?>

                          Enviado por: <?php echo $person2['first_name']." ".$person2['last_name']; ?><br/>
                          <?php echo $traslado['sent_at']; ?><br/>


<?php

}
?>

<?php
if($traslado['received_by']>0){
?>

                          Recibido por: <?php echo $traslado['received_por']; ?><br/>
                          <?php echo $traslado['received_at']; ?><br/>


<?php

}
?>

<p><strong># Traslado: </strong> <?php echo $traslado['referencial']; ?> </p>

                        </p>


                      </div>



<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="traslado" width="100%">
<thead>
<tr>
<th>SKU</th>
<th>Cantidad</th>
<th>Números de Serie</th>
</tr>
</thead>
<tbody id="articulos" class="sa">
<?php

$articulos=select_mysql("*","traslados_items","traslados_id=".$traslado['traslados_id']);
$current_traslado=array();

foreach($articulos['result'] as $ttt){
$current_traslado['articulos'][$ttt['sku']][$ttt['serial']][$ttt['inventory_id']]=$ttt['inventory_id'];

}
$responder="";
if(count($current_traslado['articulos'])>0){
//$current_traslado['articulos'][$_POST['referencia']][$_POST['numero']]=$_POST['inventario'];
foreach($current_traslado['articulos'] as $sku=>$inf){

$responder.= "<tr>";

$responder.= "<td>".$sku."</td><td>".count($current_traslado['articulos'][$sku])."</td><td>";

foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

$responder.="<p>$serial</p>";

}
}

$responder.= "</td></tr>";
}
}else{
$responder="<tr><td colspan=\"4\">No se han Agregado Artículos a este Apartado</td></tr>";
}

echo $responder;

?>
</tbody>
</table>




                    </div>

                    <div class="row">

                      <div class="col-md-12">
                        <hr />
			                      <div class="col-md-4">
                        <p>

  <label for="comments">Comentarios:</label><p>
<?php echo str_replace(array("\n","\r"),"<br/>",$traslado['comments']); ?></p>

                        </p>
                      </div>			
							
                      </div>

                    </div>







                  </div>
                  <div class="widget-foot">
					<div class="pull-right">
					<a href="#" onclick="javascript:window.print();" class="hidden-print btn btn-info btn-sm">Imprimir</a>&nbsp; 
						<a href="#" onclick="javascript:window.history.back();" title="Cancelar" class="hidden-print btn btn-default btn-sm">Regresar</a>
					</div>
                    <div class="clearfix"></div>

              
            </div>
          </div>

                    <div class="row hidden-print">

                      <div class="col-md-12">
                        <hr />
			                      <div class="col-md-4">
                        <p>

  <label for="actividades">Bitácora de Actividades</label><p id="bitacora">
<?php 

$actividades=select_mysql("*","traslados_history","traslados_id=".$_GET['traslados_id']);

foreach($actividades['result'] as $bita)
echo "<p>".str_replace(array("\n","\r"),"<br/>",$bita['comments'])."</p>"; 


?></p>

                        </p>
                      </div>			
							
                      </div>

                    </div>


        </div>

<?php
if($_GET['print_now']=='print'){

?>

<script>
window.print();
</script>
<?php

}
?>


<?php

load_template('partial','footer');
}?>
