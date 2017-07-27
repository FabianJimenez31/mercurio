<?php

global $user_array;
global $req_error;

if(permitido($user_array['person_id'],$_GET['mod'])){

$req_id=$_POST['requisition_id'];
$it_id=$_POST['item_id'];

$items=select_mysql("*","requisitions_items","item_id=$it_id and requisitionId=".$req_id);
$pedido=select_mysql("*","requisitions","requisitionId=".$req_id);
$item_arr=select_mysql("*","items","item_id=".$it_id);
$actuales=select_mysql("*","inventory","requisitionId=".$req_id." and trans_items=".$it_id);
$totales=$items['result'][0]['quantity_accepts'];
$costo=$items['result'][0]['cost_price'];
$ingresados=$actuales['count'];
$seriales="";

foreach($actuales['result'] as $act){

$seriales.="<p id=\"trans_id_".$act['trans_id']."\">".$act['serialNumber']."  <a style=\"color:red;\"  href=\"#trans_id_".$act['trans_id']."\" onclick=\"javascript: return eliminar_serial('".$act['trans_id']."' , '$it_id');\"> <i class=\"fa fa-trash\"></i> </a></p>";

}
$error="";
if($req_error!=''){
$error="
<div class=\"btn-danger\"><b>$req_error</div>
";}
$output="
<br/><br/>
<center>
<div class=\"btn-success\"><b>".$item_arr['result'][0]['name']." SKU ".$item_arr['result'][0]['product_id']."</b> Ingresados $ingresados de $totales </div>
</center>
$error
<br /><br />

<form method='POST' action='#' id='save_serial_form' onsubmit=\"javascript:return save_serial();\">
Número de Serie: <input type='text' class=\"btn-default\" name='serial_number' id='serial_number' /> <input type=submit class='btn-info' value='Guardar' />

<input type='hidden' name='item_id' value='$it_id'/>
<input type='hidden' name='requisition_id' value='$req_id'/>
<input type='hidden' name='cost' value='$costo'/>

</form>

<br /><br />

<div><b>Seriales Ingresados de este Artículo: $seriales </div>
";


if($ingresados>=$totales){

$output="

<br/><br/>
<center>
<div class=\"btn-success\"><b>".$item_arr['result'][0]['name']." SKU ".$item_arr['result'][0]['product_id']."</b> Ingresados $ingresados de $totales </div>
</center>
$error
<br /><br />
<div class=\"btn-success\">TODOS LOS NÚMEROS DE SERIE DE ESTE ARTICULO HAN SIDO INGRESADOS</div>
<br /><br />

<div><b>Seriales Ingresados de este Artículo: $seriales </div>

";

}

$response=array('request_saving'=>$output,'complete'=>'');

if($ingresados>=$totales || 1==1){

$response['update_options']=true;




$items=select_mysql("*","requisitions_items","requisitionId=".$_POST['requisition_id']);
$pedido=select_mysql("*","requisitions","requisitionId=".$_POST['requisition_id']);
$item_info=array();


$select_options="<option value=\"0\" ".(($it_id==0)?" selected ":"").">Seleccione un Item</option>";
$pendientes=0;
foreach($items['result'] as $it){


$item_arr=select_mysql("*","items","item_id=".$it['item_id']);
$actuales=select_mysql("*","inventory","requisitionId=".$_POST['requisition_id']." and trans_items=".$it['item_id']);
$totales=$it['quantity_accepts'];
$enabled=(($totales-$actuales['count'])>0)?'':'disabled';
$select_options.="<option value=\"".$it['item_id']."\" ".(($it_id==$it['item_id'])?" selected ":"")." >".$item_arr['result'][0]['name']." | SKU ".$item_arr['result'][0]['product_id']." [Ingresados ".$actuales['count']." de $totales]</option>";
if($enabled=='disabled'){$pendientes++;}

}


$response['new_options']=$select_options;

if((($items['count']-$pendientes)<=0)){

$response['complete']="<br/><button class='btn-success' onclick='javascript:complete_ingress();'>Finalizar Ingreso</button>";

}



}

echo json_encode($response);


}

?>
