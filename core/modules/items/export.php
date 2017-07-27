<?php

global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

$objPHPExcel = new PHPExcel();


$objPHPExcel->getProperties()->setCreator("Generado Por Sistema")
							 ->setLastModifiedBy("Generado Por Sistema")
							 ->setTitle("Inventario - Generado Por Sistema")
							 ->setSubject("Generado Por Sistema")
							 ->setDescription("Archivo de Lista de Inventario Generado Por Sistema")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Generado Por Sistema");


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'UPC/EAN/ISBN')
            ->setCellValue('B1', 'Identificación del producto')
            ->setCellValue('C1', 'Nombre')
            ->setCellValue('D1', 'Categoria')
            ->setCellValue('E1', 'Tamaño')
            ->setCellValue('F1', 'Proveedor')
            ->setCellValue('G1', 'Mínimo de productos')
            ->setCellValue('H1', 'Descripción')
            ->setCellValue('I1', 'Color')
            ->setCellValue('J1', 'Tiene Numero de Serie')
            ->setCellValue('K1', 'Costo (Sin Impuesto)')
            ->setCellValue('L1', 'Precio de Venta')
            ->setCellValue('M1', 'Precio promocional')
            ->setCellValue('N1', 'Promo Fecha de Inicio')
            ->setCellValue('O1', 'Promo Fecha de finalización')
            ->setCellValue('P1', 'IVA (Se agregará en Venta)')
            ->setCellValue('Q1', 'Cantidad')
            ->setCellValue('R1', 'ID de Articulo');

// Miscellaneous glyphs, UTF-8

$items=select_mysql("*","items","deleted=0");
$x=2;
foreach($items['result'] as $k){

		$cantidad=select_mysql("*","inventory","trans_items='".$k['item_id']."' and state='Disponible'");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$x, $k['item_number'])
            ->setCellValue('B'.$x, $k['product_id'])
            ->setCellValue('C'.$x, $k['name'])
            ->setCellValue('D'.$x, $k['category'])
            ->setCellValue('E'.$x, $k['size'])
            ->setCellValue('F'.$x, $k['supplier_id'])
            ->setCellValue('G'.$x, $k['reorder_level'])
            ->setCellValue('H'.$x, $k['description'])
            ->setCellValue('I'.$x, $k['color'])
            ->setCellValue('J'.$x, ($k['is_serialized']==1) ? 'SI' : 'NO'  )
            ->setCellValue('K'.$x, $k['cost_price'])
            ->setCellValue('L'.$x, $k['unit_price'])
            ->setCellValue('M'.$x, $k['promo_price'])
            ->setCellValue('N'.$x, $k['start_date'])
            ->setCellValue('O'.$x, $k['end_date'])
            ->setCellValue('P'.$x, $k['iva']>0)
            ->setCellValue('Q'.$x, $cantidad['count'])
            ->setCellValue('R'.$x, $k['item_id']);


$x++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Inventario');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inventario_exportado.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


}
?>
