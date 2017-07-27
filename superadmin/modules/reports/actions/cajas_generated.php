<?php
global $var_array;
global $server;
global $x;

if($var_array['username']=='tiendasadmin'){

$update_action="

<form id=\"create-user\" onsubmit=\"javascript:return submit_form('create-user','?module=reports&action=cajas_generated');\" enctype=\"multipart/form-data\" >

<input type=\"hidden\" name=\"start_date\" value=\"".$_POST['start_date']."\"    /> 
<input type=\"hidden\" name=\"end_date\" value=\"".$_POST['end_date']."\"    /> 
				
			
<div class=\"submit_button\" ><input type=\"submit\"   data-mini=\"true\" data-inline=\"true\" value=\"Actualizar Reporte\" /></div>
			</form>

";


$f_inicio=$_POST['start_date'];
$f_final=$_POST['end_date'];

$query_core="";

$stores=select_mysql("*","tiendas","deleted!=1");
$m=0;
foreach($stores['result'] as $s){

if($m==0){
$query_core.="SELECT 
'".addslashes($s['name'])."' as tienda,
tsesiones.session_id as id_sesion,
CONCAT(tname.last_name,',',tname.first_name) AS cajero_name ,
tsesiones.session_box AS caja ,
tsesiones.date_start AS inicio ,
tsesiones.date_end AS final ,
if(tsesiones.force_closed=1 , ' [ CERRADO POR MODULO DE CIERRE GENERAL ] ' , '') as adicional_cerrado,
if(
tsesiones.date_end='0000-00-00 00:00:00' , 'Activa' , if (
tsesiones.date_end>'$f_inicio 23:59:59' and tsesiones.date_end>'$f_final 23:59:59' , 'Activa','Finalizada'
)
)
 as estado

FROM ".$s['prefix']."sessions as tsesiones 

LEFT JOIN ".$s['prefix']."people as tname ON tsesiones.employee_is=tname.person_id

WHERE 

(tsesiones.date_start>='$f_inicio 00:00:00' AND tsesiones.date_end<='$f_final 23:59:59' and tsesiones.date_end!='0000-00-00 00:00:00') 
OR (tsesiones.date_start<='$f_inicio 00:00:00' and tsesiones.date_end='0000-00-00 00:00:00') 
OR (tsesiones.date_start>='$f_inicio 00:00:00' and tsesiones.date_end>='$f_final 23:59:59')
OR (tsesiones.date_start<='$f_inicio 00:00:00' and tsesiones.date_end>='$f_final 23:59:59')
OR (tsesiones.date_end>='$f_inicio 00:00:00' and tsesiones.date_end<='$f_final 23:59:59')
OR (tsesiones.date_start>='$f_inicio 00:00:00' and tsesiones.date_start<='$f_final 23:59:59' and tsesiones.date_end='0000-00-00 00:00:00')  

";
$m++;
}else{
$query_core.="
UNION

SELECT 
'".addslashes($s['name'])."' as tienda,
tsesiones.session_id as id_sesion,
CONCAT(tname.last_name,',',tname.first_name) AS cajero_name ,
tsesiones.session_box AS caja ,
tsesiones.date_start AS inicio ,
tsesiones.date_end AS final ,
if(tsesiones.force_closed=1 , ' [ CERRADO POR MODULO DE CIERRE GENERAL ] ' , '') as adicional_cerrado,
if(
tsesiones.date_end='0000-00-00 00:00:00' , 'Activa' , if (
tsesiones.date_end>'$f_inicio 23:59:59' and tsesiones.date_end>'$f_final 23:59:59' , 'Activa','Finalizada'
)
)
 as estado

FROM ".$s['prefix']."sessions as tsesiones 

LEFT JOIN ".$s['prefix']."people as tname ON tsesiones.employee_is=tname.person_id

WHERE 

(tsesiones.date_start>='$f_inicio 00:00:00' AND tsesiones.date_end<='$f_final 23:59:59' and tsesiones.date_end!='0000-00-00 00:00:00') 
OR (tsesiones.date_start<='$f_inicio 00:00:00' and tsesiones.date_end='0000-00-00 00:00:00') 
OR (tsesiones.date_start>='$f_inicio 00:00:00' and tsesiones.date_end>='$f_final 23:59:59')
OR (tsesiones.date_start<='$f_inicio 00:00:00' and tsesiones.date_end>='$f_final 23:59:59')
OR (tsesiones.date_end>='$f_inicio 00:00:00' and tsesiones.date_end<='$f_final 23:59:59')
OR (tsesiones.date_start>='$f_inicio 00:00:00' and tsesiones.date_start<='$f_final 23:59:59' and tsesiones.date_end='0000-00-00 00:00:00')  
";
}




}



if(isset($_POST['end_date'])){

$rm=ejecutar($query_core);
$res=mostrar($rm);

$data=array(
'start'=>$f_inicio,
'end'=>$f_final,
'results'=>$res,
'update_repo'=>$update_action
);

dynamic_module_view("reports",'caja_rep',$data);



}else{

echo "INVALID_REQUEST";

}





}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
