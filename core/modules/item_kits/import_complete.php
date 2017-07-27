<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){


$no_insertados=array();
$ni=0;

$inputFileName=APPDIR."tmp/".$_POST["filetoimport"];
extract($_POST);

try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error Cargando Archivo "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);

unset($valores);
$valores=array();

//echo $api_code."->".$rowData[0][$api_code];
//////SI EXISTE SE ACTUALIZA SINO SE CREA
if($item_id!=-1 && $rowData[0][$item_id] && $rowData[0][$item_id]!=''){

if($item_number!=-1 && $rowData[0][$item_number] && $rowData[0][$item_number]!=''){$valores['item_number']=$rowData[0][$item_number];}
if($product_id!=-1 && $rowData[0][$product_id] && $rowData[0][$product_id]!=''){$valores['product_id']=$rowData[0][$product_id];}
if($name!=-1 && $rowData[0][$name] && $rowData[0][$name]!=''){$valores['name']=$rowData[0][$name];}
if($category!=-1 && $rowData[0][$category] && $rowData[0][$category]!=''){$valores['category']=$rowData[0][$category];}
if($size!=-1 && $rowData[0][$size] && $rowData[0][$size]!=''){$valores['size']=$rowData[0][$size];}
if($supplier_id!=-1 && $rowData[0][$supplier_id] && $rowData[0][$supplier_id]!=''){$valores['supplier_id']=$rowData[0][$supplier_id];}
if($reorder_level!=-1 && $rowData[0][$reorder_level] && $rowData[0][$reorder_level]!=''){$valores['reorder_level']=$rowData[0][$reorder_level];}
if($description!=-1 && $rowData[0][$description] && $rowData[0][$description]!=''){$valores['description']=$rowData[0][$description];}
if($color!=-1 && $rowData[0][$color] && $rowData[0][$color]!=''){$valores['color']=$rowData[0][$color];}
if($is_serialized!=-1 && $rowData[0][$is_serialized] && $rowData[0][$is_serialized]!=''){$valores['is_serialized']=(strtoupper($rowData[0][$is_serialized])=='SI') ? '1' : '0';}
if($cost_price!=-1 && $rowData[0][$cost_price] && $rowData[0][$cost_price]!=''){$valores['cost_price']=$rowData[0][$cost_price];}
if($unit_price!=-1 && $rowData[0][$unit_price] && $rowData[0][$unit_price]!=''){$valores['unit_price']=$rowData[0][$unit_price];}
if($promo_price!=-1 && $rowData[0][$promo_price] && $rowData[0][$promo_price]!=''){$valores['promo_price']=$rowData[0][$promo_price];}
if($start_date!=-1 && $rowData[0][$start_date] && $rowData[0][$start_date]!=''){$valores['start_date']=$rowData[0][$start_date];}
if($end_date!=-1 && $rowData[0][$end_date] && $rowData[0][$end_date]!=''){$valores['end_date']=$rowData[0][$end_date];}
if($iva!=-1 && $rowData[0][$iva] && $rowData[0][$iva]!=''){if(strtoupper($rowData[0][$iva])=='SI'){$valores['iva']='16';$valores['override_default_tax']=1;}else{$valores['iva']='0';$valores['override_default_tax']=0;}}

update_mysql('items',$valores,'item_id='.$rowData[0][$item_id]);

}else{

if($item_number!=-1 && $rowData[0][$item_number] && $rowData[0][$item_number]!=''){$valores['item_number']=$rowData[0][$item_number];}
if($product_id!=-1 && $rowData[0][$product_id] && $rowData[0][$product_id]!=''){$valores['product_id']=$rowData[0][$product_id];}
if($name!=-1 && $rowData[0][$name] && $rowData[0][$name]!=''){$valores['name']=$rowData[0][$name];}
if($category!=-1 && $rowData[0][$category] && $rowData[0][$category]!=''){$valores['category']=$rowData[0][$category];}
if($size!=-1 && $rowData[0][$size] && $rowData[0][$size]!=''){$valores['size']=$rowData[0][$size];}
if($supplier_id!=-1 && $rowData[0][$supplier_id] && $rowData[0][$supplier_id]!=''){$valores['supplier_id']=$rowData[0][$supplier_id];}
if($reorder_level!=-1 && $rowData[0][$reorder_level] && $rowData[0][$reorder_level]!=''){$valores['reorder_level']=$rowData[0][$reorder_level];}
if($description!=-1 && $rowData[0][$description] && $rowData[0][$description]!=''){$valores['description']=$rowData[0][$description];}
if($color!=-1 && $rowData[0][$color] && $rowData[0][$color]!=''){$valores['color']=$rowData[0][$color];}
if($is_serialized!=-1 && $rowData[0][$is_serialized] && $rowData[0][$is_serialized]!=''){$valores['is_serialized']=(strtoupper($rowData[0][$is_serialized])=='SI') ? '1' : '0';}
if($cost_price!=-1 && $rowData[0][$cost_price] && $rowData[0][$cost_price]!=''){$valores['cost_price']=$rowData[0][$cost_price];}
if($unit_price!=-1 && $rowData[0][$unit_price] && $rowData[0][$unit_price]!=''){$valores['unit_price']=$rowData[0][$unit_price];}
if($promo_price!=-1 && $rowData[0][$promo_price] && $rowData[0][$promo_price]!=''){$valores['promo_price']=$rowData[0][$promo_price];}
if($start_date!=-1 && $rowData[0][$start_date] && $rowData[0][$start_date]!=''){$valores['start_date']=$rowData[0][$start_date];}
if($end_date!=-1 && $rowData[0][$end_date] && $rowData[0][$end_date]!=''){$valores['end_date']=$rowData[0][$end_date];}
if($iva!=-1 && $rowData[0][$iva] && $rowData[0][$iva]!=''){if(strtoupper($rowData[0][$iva])=='SI'){$valores['iva']='16';$valores['override_default_tax']=1;}else{$valores['iva']='0';$valores['override_default_tax']=0;}}

if( !(isset($valores['name'])) || !(isset($valores['category'])) || !(isset($valores['cost_price'])) || !(isset($valores['unit_price'])) ){
$no_inserados[$ni]=$rowData[0];
$no_inserados[$ni]['reason']='Informacion Incompleta: Campos Nombre, Categoria, Costo (Sin Impuestos) y Precio de Venta son Obligatorios';
$ni++;

}else{

insert_mysql("items",$valores);

}

}
   
}
unlink($inputFileName);
if(count($no_inserados)>0){
load_template('partial','header');
load_template('partial','menu');
echo "<b>Los siguientes Registros no se pudieron importar:<b><br/><br/>";

foreach($no_inserados as $k){


foreach($k as $v)
if($v!=''){echo $v."|";}
echo "<br/>";
}
?>
<a href="?mod=items&proc=main" class="ui-btn ui-corner-all" data-ajax="false">Regresar a Inventario</a>
<?php
load_template('partial','footer');

}else{


echo "<script>alert('Importacion Finalizada de Forma Exitosa');</script>";

?>

<script>
window.location = "?mod=items&proc=main";
</script>
<meta http-equiv="refresh" content="1;url=?mod=items&proc=main" />

<?php

}

?>






<?php 

} ?>
