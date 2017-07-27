<?php
global $user_array;
global $current_traslado;

if(permitido($user_array['person_id'],$_GET['mod'])){
if($_POST['term']!="" && str_replace(array("\n","\t","\r"," "),"",$_POST['term'])!=""){

$omitir="";

foreach($current_traslado['articulos'] as $sku=>$inf){


foreach($inf as $serial=>$id){

foreach($id as $r=>$val){

$omitir.=" AND trans_id!=".$val." ";

}
}

}




$cat=array();


$seriales=select_mysql("*","inventory","trans_items='".$_POST['term']."' and state='Disponible'".$omitir,'trans_items ASC');

foreach($seriales['result'] as $s){

$items=select_mysql("*","items","item_id=".$s['trans_items']);


foreach($items['result'] as $i){

$cat[]=array('value'=>$i['item_id'],'sku'=>$i['product_id'],'serial'=>$s['serialNumber'],'inventory_id'=>$s['trans_id']);

}


}



if(count($cat)>0){

?>

<table class="table table-striped table-bordered" id="traslado">
<thead>
<tr>
<th>Serial</th>
<th></th>
</tr>
</thead>
<tbody>
<?php

foreach($cat as $art){

echo "<tr id=\"resultados_".$art['inventory_id']."\">
<td>".$art['serial']."</td>
<td><a href=\"#\" onclick=\"javascript: agrega_serial('".$art['inventory_id']."','".$art['sku']."','".$art['serial']."');\">Agregar Serial</a></td>

</tr>";
}

?>
</tbody>
</table>


<?php






}else{

echo "<small><strong><i style=\"color:red;\">No se encontraron Seriales para este SKU</i></strong></small>";
}

}
}


?>
