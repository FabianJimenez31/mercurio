<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

if($_GET['same_ending']=='yes'){
$_POST['ffinal']=$_POST['finicio'];
}

if($_GET['split_date']=='yes'){
$_POST['ffinal']=substr($_POST['periodo'],-10,10);
$_POST['finicio']=substr($_POST['periodo'],0,10);
}
if($_GET['enable_prorat']=='yes'){
$duracion_completa_periodo=floor((((strtotime($_POST['ffinal']." 23:59:59")-strtotime($_POST['finicio']." 00:00:00"))/60)/60)/24);
}

if($_GET['id_esquema']>0){
$esquema_info_main=select_mysql("*","esquemas","id=".$_GET['id_esquema']);
$tipo_prorrateo=$esquema_info_main['result'][0]['periodical'];
}
?>
    <button class="btn btn-primary text-white hidden-print" id="print_button" onClick="window.print()" > Imprimir </button>
<h3 class="page-header text-info">Reporte de Comisiones del <?php echo ((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio']);?> al <?php echo ((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal']);?></h3>



<?php

$finicio=((isset($_POST['finicio'])) ? $_POST['finicio'] : $_GET['finicio'])." 00:00:00";
$ffinal=((isset($_POST['ffinal'])) ? $_POST['ffinal'] : $_GET['ffinal'])." 23:59:59";
$usuario_especifico=(isset($_GET['check_mine']) && $_GET['check_mine']='yes')?' and t6.person_id='.$user_array['person_id']:'';
$is_offtime=($_POST['offtime']==1)?'':" OR  (t1.aprobacion_fecha_real>='$finicio' and t1.aprobacion_fecha_real<='$ffinal') ";
$query="

SELECT 
t1.item_id as item_id,
t2.iva as iva,
if(t1.item_unit_price=0 , t1.real_item_unit_price ,t1.item_unit_price) as precio,
t5.customer_id as customer_id,
t5.salesman as employee_id,
t1.aprobada_por as aprobada_id,
t1.line as line,
t2.product_id as sku , 
t1.serialnumber as contrato,
t1.num_tel as telefono,
t1.sale_id as factura,
t1.aprobacion_fecha_real as fecha_aprobacion,
t5.sale_time as fecha_venta,
t1.razon_rechazo as razon_rechazo,
if(t1.aprobacion_fecha_real>'$ffinal' , '0', t1.is_aprobada) as estado_actual,
concat(t3.first_name , ' ' , t3.last_name) as cliente,
concat(t4.first_name , ' ' , t4.last_name) as vendedor,
concat(t7.first_name , ' ' , t7.last_name) as aprobada_por,
if( t2.is_serialized=1 AND t2.is_service=1, if(t1.contrato='' , 'NO' , 'SI'),'N/A') as subido , 
t5.sale_time as fecha,
t6.esquema_id as esquema_vendedor,
t6.metas_id as metas_vendedor,
t6.creacion_fecha_real as ingreso_agente,
t2.categoria_id as categoria_item,
t8.name as categoria_item_name,
if((t5.sale_time<'$finicio' or t5.sale_time>'$ffinal'),1,0) as fuera_tiempo

from

".DBPREFIX."sales_items AS t1 

LEFT JOIN ".DBPREFIX."items AS t2 ON t1.item_id = t2.item_id
LEFT JOIN ".DBPREFIX."sales AS t5 ON t1.sale_id = t5.sale_id
LEFT JOIN ".DBPREFIX."people AS t3 ON t5.customer_id = t3.person_id
LEFT JOIN ".DBPREFIX."people AS t4 ON t5.salesman = t4.person_id
LEFT JOIN ".DBPREFIX."people AS t7 ON t1.aprobada_por = t7.person_id
LEFT JOIN ".DBPREFIX."employees AS t6 ON t5.salesman = t6.person_id
LEFT JOIN ".DBPREFIX."categorias AS t8 ON t2.categoria_id = t8.id


WHERE

t2.categoria_id>0 and t6.metas_id>0 

and t6.esquema_id=".$_GET['id_esquema']."

and t6.esquema_id>0 $usuario_especifico

and ((t5.sale_time>='$finicio' and t5.sale_time<='$ffinal') $is_offtime)

";


$completo_a=ejecutar($query);

$result=ejecutar($query);
$array=mostrar($result);
$count=contar($result);

$detalles="";
$general="";
$usuarios=array();
if($count>0){


foreach($result as $r){


$usuarios[$r['employee_id']]['nombre']=$r['vendedor'];
$usuarios[$r['employee_id']]['metas_id']=$r['metas_vendedor'];
$usuarios[$r['employee_id']]['esquema_id']=$r['esquema_vendedor'];
if($_GET['enable_prorat']=='yes'){

if($r['ingreso_agente']=="0000-00-00 00:00:00"){
$usuarios[$r['employee_id']]['prorateo']=1;
}else{
$dias_trabajados=((((strtotime($ffinal)-strtotime($r['ingreso_agente']))/60)/60)/24);
$usuarios[$r['employee_id']]['prorateo']=($dias_trabajados>0)?($dias_trabajados / $duracion_completa_periodo):0;
$usuarios[$r['employee_id']]['prorateo']=($usuarios[$r['employee_id']]['prorateo']>1)?1:$usuarios[$r['employee_id']]['prorateo'];
}

}else{
$usuarios[$r['employee_id']]['prorateo']=1;
}


if($r['estado_actual']=="0"){
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['pendientes']++;
}

$usuarios[$r['employee_id']]['prorateo_metas']=($tipo_prorrateo==1 || $tipo_prorrateo==3)?$usuarios[$r['employee_id']]['prorateo']:1;
$usuarios[$r['employee_id']]['prorateo_comision']=($tipo_prorrateo==2 || $tipo_prorrateo==3)?$usuarios[$r['employee_id']]['prorateo']:1;


if($r['estado_actual']=="1" && $r['fuera_tiempo']=='1'){
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['fuera_tiempo']++;
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['cantidad']++;
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['iva']=$r['iva'];
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['precio']=$r['precio'];
}

if($r['estado_actual']=="1" && $r['fuera_tiempo']=='0'){
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['en_tiempo']++;
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['cantidad']++;
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['iva']=$r['iva'];
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['items'][$r['item_id']]['precio']=$r['precio'];
}

if($r['estado_actual']=="2" ){
$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['rechazos']++;
}

$usuarios[$r['employee_id']]['categorias'][$r['categoria_item']]['name']=$r['categoria_item_name'];
/*

Usuarios
	[id]
		[categoria]
			[vendidos on time]
			[vendidos off time]
			[rechazados]
			[pendientes]
		[metas_vendedor]
		[esquema_vendedor]


*/



$detalles.="

<tr>
<td>".$r['vendedor']."</td>
<td>".$r['cliente']."</td>
<td>".$r['sku']."</td>
<td>".$r['categoria_item_name']."</td>
<td>".$r['factura']."</td>
<td>".$r['fecha_venta']."</td>
<td>".$r['fecha_aprobacion']."</td>
<td>".$r['aprobada_por']."</td>
<td>".$r['contrato']."</td>
<td>".$r['telefono']."</td>
<td>".$r['subido']."</td>
<td>".(($r['estado_actual']=="0")?'Pendiente':(($r['estado_actual']==1)?'Aprobada':'Rechazada'))."</td>
<td>".(($r['razon_rechazo']!=null)?$r['razon_rechazo']:'N/A')."</td>
</tr>

";




}


}

foreach($usuarios as $k=>$v){


foreach($v['categorias'] as $cat_id=>$vendidos){

$metas_info=select_mysql("meta","metas_asignar","status!=3 and meta_id='".$v['metas_id']."' and categoria_id='$cat_id'",'id desc','1');

if($metas_info['count']>0){

$esquema_info=select_mysql("*","esquema_asignar","status!=3 and esquema_id='".$v['esquema_id']."' and categoria_id='$cat_id'");

if($esquema_info['count']>0){

$meta_aqui=ceil($metas_info['result'][0]['meta']*$v['prorateo_metas']);

$totales_cumplido=$vendidos['fuera_tiempo']+$vendidos['en_tiempo'];

$totales_hechos=$vendidos['fuera_tiempo']+$vendidos['en_tiempo']+$vendidos['pendientes']+$vendidos['rechazos'];

$porcentaje_entiempo=number_format(($vendidos['en_tiempo']*100/$totales_hechos),0,".","");
$porcentaje_fuera_tiempo=number_format(($vendidos['fuera_tiempo']*100/$totales_hechos),0,".","");
$porcentaje_pendientes=number_format(($vendidos['pendientes']*100/$totales_hechos),0,".","");
$porcentaje_rechazos=number_format(($vendidos['rechazos']*100/$totales_hechos),0,".","");

$porcentaje_cumplido=number_format(($totales_cumplido*100/$meta_aqui),0,".","");

$rangos_id="AND";
$msnsn=0;
foreach($esquema_info['result'] as $esinfo){

$rangos_id.=($msnsn==0)?" ( id='".$esinfo['rango_id']."'":" OR id='".$esinfo['rango_id']."'";
$msnsn++;
}

$rangos_id.=")";

if($rangos_id!="AND)"){

$valida_rangos=select_mysql("*","rangos","status!=3  $rangos_id","maximo asc");


$rango_id=0;
if($valida_rangos['result'][0]['maximo']==0){

$rango_nombre=$valida_rangos['result'][0]['name'];
$rango_id=$valida_rangos['result'][0]['id'];

}

foreach($valida_rangos['result'] as $valra){

if($valra['maximo']!=0){

if($valra['maximo']>$porcentaje_cumplido){
$rango_nombre=$valra['name'];
$rango_id=$valra['id'];
break;
}

}

}
if($rango_id>0){

$pago_final_a=select_mysql("*","esquema_asignar","rango_id=$rango_id and status!=3 and esquema_id='".$v['esquema_id']."' and categoria_id='$cat_id'",'id desc','1');

switch($pago_final_a['result'][0]['es_porcentaje']){

case 1:
$pago_final=0;
foreach($vendidos['items'] as $itemso=>$comisura){
$pago_final+=$comisura['cantidad']*$comisura['precio']*$v['prorateo_comision']*$pago_final_a['result'][0]['comision']/100;
}
break;

case 2:
$pago_final=0;
foreach($vendidos['items'] as $itemso=>$comisura){
$pago_final+=$comisura['cantidad']*$comisura['precio']*$v['prorateo_comision']*(($comisura['iva']/100)+1)*($pago_final_a['result'][0]['comision']/100);
}
break;


default:
$pago_final=$totales_cumplido*$pago_final_a['result'][0]['comision']*$v['prorateo_comision'];

}

$usuarios_para_pago[$k]['nombre']=$v['nombre'];
$usuarios_para_pago[$k]['total']+=$pago_final;

$general.="
<tr>
<td>".$v['nombre']."</td>
<td>".$vendidos['name']."</td>
<td>$meta_aqui</td>
<td>$rango_nombre</td>
<td>$totales_cumplido ( $porcentaje_cumplido % ) </td>
<td>".$vendidos['en_tiempo']." ( $porcentaje_entiempo % ) </td>
<td>".$vendidos['fuera_tiempo']." ( $porcentaje_fuera_tiempo % ) </td>
<td>".$vendidos['pendientes']." ( $porcentaje_pendientes % ) </td>
<td>".$vendidos['rechazos']." ( $porcentaje_rechazos % ) </td>
<td>$ ".number_format($pago_final,2,",",".")." </td>
</tr>
";
}

}

}

}

}



}

?>



<h4 class="page-header text-info">Pago Final</h4>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="pagos" width="100%">
<thead>
<tr>
<th>ID de Vendedor</th>
<th>Vendedor</th>
<th>Pago Final</th>
</tr>
</thead>
<tbody>
<?php 

foreach($usuarios_para_pago as $k=>$v){

echo "
<tr>
<td>".$k."</td>
<td>".$v['nombre']."</td>
<td>$ ".number_format($v['total'],2,",",".")."</td>
</tr>
";

}

?>
</tbody>
</table>
<script type="text/javascript" charset="utf-8">


var table =   $('#pagos').DataTable();
</script>








<h4 class="page-header text-info">General</h4>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="general" width="100%">
<thead>
<tr>
<th>Vendedor</th>
<th>Categoria</th>
<th>Meta</th>
<th>Rango Adquirido</th>
<th>Cumplido</th>
<th>Aprobadas de este periodo</th>
<th>Aprobadas de otros periodos</th>
<th>Pendientes</th>
<th>Rechazadas</th>
<th>Comision Actual</th>
</tr>
</thead>
<tbody>
<?php echo $general;?>
</tbody>
</table>
<script type="text/javascript" charset="utf-8">


var table =   $('#general').DataTable();
</script>




<h4 class="page-header text-info">Detallado</h4>

<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered dt-responsive nowrap" id="detallado" width="100%">
<thead>
<tr>
<th>Vendedor</th>
<th>Cliente</th>
<th>SKU</th>
<th>Categoria</th>
<th>Factura</th>
<th>Fecha de Venta</th>
<th>Fecha de Aprobacion</th>
<th>Aprobada Por</th>
<th>Contrato</th>
<th>Numero Telefonico</th>
<th>Contrato Subido</th>
<th>Estado</th>
<th>Motivo de Rechazo</th>
</tr>
</thead>
<tbody>
<?php echo $detalles; ?>
</tbody>
</table>
<script type="text/javascript" charset="utf-8">


var table =   $('#detallado').DataTable();
</script>


<?php

load_template('partial','footer');
}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";

}


?>
