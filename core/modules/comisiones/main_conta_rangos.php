<?php

global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){

$esquema=select_mysql("*","esquemas","id=".$_GET['esquema_id']);

if($esquema['count']==1){

if($esquema['result'][0]['month_start']==0){


?>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label">Seleccione un Rango de Fechas</label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles" action="?mod=comisiones&proc=reporte&id_esquema=<?php echo $_GET['esquema_id']; ?>" method='POST'>
					<div class="form-group">
						<label for="finicio" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('start_date'); ?> :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="finicio" class='datepicker' value="<?php echo date("Y-m-d"); ?>" >
						</div>
					</div>



					<div class="form-group">
						<label for="ffinal" class="col-sm-3 col-md-3 col-lg-2 control-label   "><?php echo label_me('end_date'); ?> :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="ffinal" class='datepicker' value="<?php echo date("Y-m-d"); ?>" >
						</div>
					</div>


					<div class="form-group">
						<label for="ffinal" class="col-sm-3 col-md-3 col-lg-2 control-label   ">No Incluir Aprobaciones de ventas fuera del Periodo :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="checkbox" name="offtime" value="1" /> 
						</div>
					</div>
										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('generate'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>
<script>

	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"	});

</script>
<?php

}elseif($esquema['result'][0]['month_start']==1){


?>


<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label">Seleccione una Fecha</label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles" action="?mod=comisiones&proc=reporte&same_ending=yes&id_esquema=<?php echo $_GET['esquema_id']; ?>" method='POST'>
					<div class="form-group">
						<label for="finicio" class="col-sm-3 col-md-3 col-lg-2 control-label   ">Fecha :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="finicio" class='datepicker' value="<?php echo date("Y-m-d"); ?>" >
						</div>
					</div>




					<div class="form-group">
						<label for="ffinal" class="col-sm-3 col-md-3 col-lg-2 control-label   ">No Incluir Aprobaciones de ventas fuera del Periodo :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="checkbox" name="offtime" value="1" /> 
						</div>
					</div>
										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('generate'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>
<script>

	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"	});

</script>

<?php


}else{
?>




<div class="row">
	<div class="col-md-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5><label for="report_date_range_label">Seleccione un Periodo:</label>				</h5>
			</div>
			<div class="widget-content nopadding">
					<form  class="form-horizontal form-horizontal-mobiles" action="?mod=comisiones&proc=reporte&split_date=yes&enable_prorat=yes&id_esquema=<?php echo $_GET['esquema_id']; ?>" method='POST'>
					<div class="form-group">
						<label for="finicio" class="col-sm-3 col-md-3 col-lg-2 control-label   ">Periodo:</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<select name="periodo" >

<?php

$par=0;
$salto=365;
$periodos=2;

if($esquema['result'][0]['month_start']==2){$periodos=$periodos*52;$salto=7;}
if($esquema['result'][0]['month_start']==3){$periodos=$periodos*27;$salto=15;}
if($esquema['result'][0]['month_start']==4){$periodos=$periodos*12;$salto=30;}
if($esquema['result'][0]['month_start']==5){$periodos=$periodos*6;$salto=60;$par=1;}
if($esquema['result'][0]['month_start']==6){$periodos=$periodos*6;$salto=60;}
if($esquema['result'][0]['month_start']==7){$periodos=$periodos*2;$salto=180;}

for($x=1;$x<=$periodos;$x++){
$per_final='';

if($x==1){

if($esquema['result'][0]['month_start']==2){
$desfase="-".(date('N')-1)." days";
$inicio=date('Y-m-d H:i:s',strtotime($desfase));
$final=date('Y-m-d H:i:s',strtotime("+6 days",strtotime($inicio)));
}

if($esquema['result'][0]['month_start']==3){
$hoy=date("j");
if($hoy>15){
$inicio=date('Y-m')."-16 ".date('H:i:s');
$final=date('Y-m-d H:i:s',strtotime("-1 day",strtotime("+1 month",strtotime(str_replace("-16 ","-01 ",$inicio)))));
}else{
$inicio=date('Y-m')."-01 ".date('H:i:s');
$final=date('Y-m')."-15 ".date('H:i:s');
}
}

if($esquema['result'][0]['month_start']==4){
$inicio=date('Y-m')."-01 ".date('H:i:s');
$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+1 month",strtotime(date('Y-m')."-01 ".date('H:i:s')))));
}

if($esquema['result'][0]['month_start']==5 || $esquema['result'][0]['month_start']==6){

$tipo_mes=(date("n") % 2 == 0)?'0':'1';

if($tipo_mes==0 && $par==1){$inicio=date("Y-m")."-01 ".date("H:i:s");}
if($tipo_mes==1 && $par==1){$inicio=date("Y-m-d H:i:s",strtotime("-1 month",strtotime(date("Y-m")."-01 ".date("H:i:s"))));}
if($tipo_mes==0 && $par==0){$inicio=date("Y-m-d H:i:s",strtotime("-1 month",strtotime(date("Y-m")."-01 ".date("H:i:s"))));}
if($tipo_mes==1 && $par==0){$inicio=date("Y-m")."-01 ".date("H:i:s");}
$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+2 months",strtotime($inicio))));
}


if($esquema['result'][0]['month_start']==7){
$donde=date('n');

if($donde<7){
$inicio=date("Y")."-01-01 00:00:00";
}else{
$inicio=date("Y")."-07-01 00:00:00";
}

$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+6 months",strtotime($inicio))));

}


if($esquema['result'][0]['month_start']==8){
$inicio=date("Y")."-01-01 00:00:00";
$final=date("Y")."-12-31 00:00:00";
}


}else{
////LOS QUE NO SON INICIALES

if($esquema['result'][0]['month_start']==2){
$inicio=date('Y-m-d H:i:s',strtotime("-7 day",strtotime($inicio)));
$final=date('Y-m-d H:i:s',strtotime("+6 days",strtotime($inicio)));
}

if($esquema['result'][0]['month_start']==3){
$hoy=date("j",strtotime("-1 day",strtotime($inicio)));
if($hoy>15){
$inicio=date('Y-m',strtotime("-1 day",strtotime($inicio)))."-16 ".date('H:i:s',strtotime("-1 day",strtotime($inicio)));
$final=date('Y-m-d H:i:s',strtotime("-1 day",strtotime("+1 month",strtotime(str_replace("-16 ","-01 ",$inicio)))));
}else{
$inicio=date('Y-m',strtotime("-1 day",strtotime($inicio)))."-01 ".date('H:i:s',strtotime("-1 day",strtotime($inicio)));
$final=date('Y-m',strtotime("-1 day",strtotime($inicio)))."-15 ".date('H:i:s',strtotime("-1 day",strtotime($inicio)));
}
}

if($esquema['result'][0]['month_start']==4){
$inicio=date('Y-m',strtotime("-1 day",strtotime($inicio)))."-01 ".date('H:i:s',strtotime("-1 day",strtotime($inicio)));
$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+1 month",strtotime(date('Y-m',strtotime($inicio))."-01 ".date('H:i:s',strtotime($inicio))))));
}

if($esquema['result'][0]['month_start']==5 || $esquema['result'][0]['month_start']==6){

$tipo_mes=(date("n",strtotime("-1 day",strtotime($inicio))) % 2 == 0)?'0':'1';

if($tipo_mes==0 && $par==1){$inicio=date("Y-m",strtotime("-1 day",strtotime($inicio)))."-01 ".date("H:i:s",strtotime("-1 day",strtotime($inicio)));}
if($tipo_mes==1 && $par==1){$inicio=date("Y-m-d H:i:s",strtotime("-1 month",strtotime(date("Y-m",strtotime("-1 day",strtotime($inicio)))."-01 ".date("H:i:s",strtotime("-1 day",strtotime($inicio))))));}
if($tipo_mes==0 && $par==0){$inicio=date("Y-m-d H:i:s",strtotime("-1 month",strtotime(date("Y-m",strtotime("-1 day",strtotime($inicio)))."-01 ".date("H:i:s",strtotime("-1 day",strtotime($inicio))))));}
if($tipo_mes==1 && $par==0){$inicio=date("Y-m",strtotime("-1 day",strtotime($inicio)))."-01 ".date("H:i:s",strtotime("-1 day",strtotime($inicio)));}
$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+2 months",strtotime($inicio))));
}


if($esquema['result'][0]['month_start']==7){
$donde=date('n',strtotime("-1 day",strtotime($inicio)));

if($donde<7){
$inicio=date("Y",strtotime("-1 day",strtotime($inicio)))."-01-01 00:00:00";
}else{
$inicio=date("Y",strtotime("-1 day",strtotime($inicio)))."-07-01 00:00:00";
}

$final=date("Y-m-d H:i:s",strtotime("-1 day",strtotime("+6 months",strtotime($inicio))));

}


if($esquema['result'][0]['month_start']==8){
$inicio=date("Y",strtotime("-1 day",strtotime($inicio)))."-01-01 00:00:00";
$final=date("Y",strtotime($inicio))."-12-31 00:00:00";
}

}

$per_final="
<option value=\"".substr($inicio,0,10)."/".substr($final,0,10)."\">".substr($inicio,0,10)." al ".substr($final,0,10)."</option>";

echo $per_final;
}

?>

							</select>
						</div>
					</div>




					<div class="form-group">
						<label for="ffinal" class="col-sm-3 col-md-3 col-lg-2 control-label   ">No Incluir Aprobaciones de ventas fuera del Periodo :</label>
						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="checkbox" name="offtime" value="1" /> 
						</div>
					</div>
										<div class="form-actions">
				<input type="submit" name="submitf" value="<?php echo label_me('generate'); ?>" id="submitf" class="submit_button btn btn-primary"  />				</div>
					</form>
					
			</div>
		</div>
	</div>
</div>




<?php

}

}


}

?>
