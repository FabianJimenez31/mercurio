<?php
global $user_array;
global $current_traslado;
if(permitido($user_array['person_id'],$_GET['mod'])){
if($_POST['term']!="" && str_replace(array("\n","\t","\r"," "),"",$_POST['term'])!=""){
$cat=array();

$omitir="";
foreach($current_traslado['articulos'] as $sku=>$inf){


foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

$omitir.=" AND trans_id!=".$val." ";

}
}

}



$items=select_mysql("*","items","name LIKE '%".$_POST['term']."%' or description LIKE '%".$_POST['term']."%' or item_number LIKE '%".$_POST['term']."%' or product_id LIKE '%".$_POST['term']."%' or item_id LIKE '%".$_POST['term']."%' or color like '%".$_POST['term']."%'",'item_id ASC','10');


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'sku'=>$i['product_id'],'descripcion'=>utf8_encode($i['name']."( ".$i['category'].",".$i['color']." )"));

}

$seriales=select_mysql("*","inventory","serialNumber like '%".$_POST['term']."%' and state='Disponible'".$omitir,'trans_items ASC',3);

foreach($seriales['result'] as $s){

$items=select_mysql("*","items","item_id=".$s['trans_items']);


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'sku'=>$i['product_id'],'descripcion'=>utf8_encode($i['name']."( ".$i['category'].",".$i['color']." )") , 'serial'=>$s['serialNumber'],'inventory_id'=>$s['trans_id'],'is_direct'=>'directo');

}


}

if(count($cat)>0){

?>

<table class="table table-striped table-bordered" id="traslado">
<thead>
<tr>
<th>SKU</th>
<th>Descripción</th>
<th></th>
</tr>
</thead>
<tbody>
<?php

foreach($cat as $art){
if($art['is_direct']=='directo'){

echo "<tr id=\"resultados_".$art['inventory_id']."\">
<td>".$art['sku']."</td>
<td>".$art['descripcion']."</td>
<td><a href=\"#\" onclick=\"javascript: agrega_serial('".$art['inventory_id']."','".$art['sku']."','".$art['serial']."');\">Agregar Serial [ ".$art['serial']." ] </a></td>

</tr>";


}else{
echo "<tr>
<td>".$art['sku']."</td>
<td>".$art['descripcion']."</td>
<td><a href=\"#\" onclick=\"javascript: activo_sku('".$art['value']."','".$art['sku']."');\">Seleccionar</a></td>

</tr>";
}
}

?>
</tbody>
</table>


<?php






}else{

echo "<small><strong><i style=\"color:red;\">No se encontraron Resultados</i></strong></small>";
}

}
}


?>
