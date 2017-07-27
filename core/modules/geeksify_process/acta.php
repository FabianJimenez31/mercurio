<?php
global $user_array;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
if($_GET['id']!="-1"){

$informacion=select_mysql("*","geeksify_envio","envios_id=".$_GET['id']);
$respuestas=select_mysql("*","geeksify_respuestas","envio_id=".$_GET['id']);
$marca=select_mysql("*","geeksify_marcas","marcas_id=".$informacion['result'][0]['marca_id']);
$modelo=select_mysql("*","geeksify_modelos","modelos_id=".$informacion['result'][0]['modelo_id']);
$vendedor=select_mysql("*","people","person_id=".$informacion['result'][0]['person_id']);
$cliente=select_mysql("*","people","person_id=".$informacion['result'][0]['client_id']);
$cliente_i=select_mysql("*","customers","person_id=".$informacion['result'][0]['client_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0//EN" "http://www.w3.org/Math/DTD/mathml2/xhtml-math11-f.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<title xml:lang="en-US"> </title>
<style type="text/css">
	@page {  }
	table { border-collapse:collapse; border-spacing:0; empty-cells:show }
	td, th { vertical-align:top; font-size:12pt;}
	h1, h2, h3, h4, h5, h6 { clear:both }
	ol, ul { margin:0; padding:0;}
	li { list-style: none; margin:0; padding:0;}
	<!-- "li span.odfLiEnd" - IE 7 issue-->
	li span. { clear: both; line-height:0; width:0; height:0; margin:0; padding:0; }
	span.footnodeNumber { padding-right:1em; }
	span.annotation_style_by_filter { font-size:95%; font-family:Arial; background-color:#fff000;  margin:0; border:0; padding:0;  }
	* { margin:0;}
	.fr1 { font-size:12pt; font-family:Liberation Serif; text-align:center; vertical-align:top; writing-mode:lr-tb; margin-left:0cm; margin-right:0cm; padding:0.002cm; border-style:none; }
	.Footer { font-size:12pt; font-family:Times New Roman; writing-mode:lr-tb; }
	.Normal_20__28_Web_29_ { font-size:12pt; font-family:Times New Roman; writing-mode:lr-tb; margin-top:0.494cm; margin-bottom:0.494cm; line-height:100%; }
	.P1 { font-size:12pt; font-family:Times New Roman; writing-mode:lr-tb; margin-left:5.943cm; margin-right:0cm; text-indent:7.795cm; }
	.P2 { font-size:11pt; font-family:Tahoma; writing-mode:lr-tb; }
	.P3 { font-size:12pt; font-family:Tahoma; writing-mode:lr-tb; }
	.P4 { font-size:12pt; font-family:Times New Roman; writing-mode:lr-tb; text-align:justify ! important; }
	.P5 { font-size:12pt; line-height:100%; margin-bottom:0.494cm; margin-top:0.494cm; font-family:Tahoma; writing-mode:lr-tb; }
	.P6 { font-size:14pt; line-height:100%; margin-bottom:0.494cm; margin-top:0cm; font-family:Tahoma; writing-mode:lr-tb; text-align:center ! important; font-weight:bold; }
	.P7 { font-size:12pt; line-height:100%; margin-bottom:0.494cm; margin-top:0.494cm; font-family:Tahoma; writing-mode:lr-tb; margin-left:8.731cm; margin-right:0cm; text-indent:-8.731cm; }
	.P8 { font-size:12pt; line-height:100%; margin-bottom:0.494cm; margin-top:0.494cm; font-family:Times New Roman; writing-mode:lr-tb; margin-left:8.731cm; margin-right:0cm; text-indent:-8.731cm; }
	.Standard { font-size:12pt; font-family:Times New Roman; writing-mode:lr-tb; }
	.T2 { font-family:Tahoma; }
	.T3 { font-family:Tahoma; font-size:11pt; }
	.T4 { font-family:Tahoma; font-weight:bold; }
	.T5 { color:#222222; font-family:Arial; background-color:#ffffff; }
	.T8 { font-size:16pt; }
	.WW8Num1z0 { font-family:Symbol; }
	.WW8Num1z2 { font-family:Courier New; }
	.WW8Num1z3 { font-family:Wingdings; }
	<!-- ODF styles with no properties representable as CSS -->
	.T9 .WW8Num2z0 .WW8Num2z1 .WW8Num2z2 .WW8Num2z3 .WW8Num2z4 .WW8Num2z5 .WW8Num2z6 .WW8Num2z7 .WW8Num2z8  { }
	</style>
</head>

<body dir="ltr" style="max-width:21.59cm;margin-top:0.751cm; margin-bottom:0cm; margin-left:1cm; margin-right:1cm; ">
<p class="P6">FORMATO DE CONSTANCIA PARA LA TRANSFERENCIA DE PROPIEDAD DE UN EQUIPO TERMINAL MÓVIL USADO</p>
<p class="Normal_20__28_Web_29_">
<span class="T2">Información del Equipo Terminal Móvil (usado)</span></p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Marca: [ <?php echo $marca['result'][0]['valor']; ?> ]    /    Modelo: [ <?php echo $modelo['result'][0]['valor']; ?> ]</span>
</p>

<p class="Standard">
<span class="T3">IMEI: [ <?php echo $informacion['result'][0]['imei']; ?> ]</span>
</p>

<p class="P2"> 
</p>
<p class="P4">
<span class="T2">En la ciudad de Bogotá  a las <u><?php echo substr($informacion['result'][0]['creacion_fecha_real'],-8,8); ?></u>  horas, del día <u><?php echo substr($informacion['result'][0]['creacion_fecha_real'],-11,2); ?></u> del mes <u><?php echo substr($informacion['result'][0]['creacion_fecha_real'],-14,2); ?></u> del año <u><?php echo substr($informacion['result'][0]['creacion_fecha_real'],0,4); ?></u>, se produjo la transferencia de propiedad del equipo terminal móvil usado entre el propietario del equipo vendedor <u><?php echo strtoupper($cliente['result'][0]['first_name']." ".$cliente['result'][0]['last_name']); ?></u> con número C.C. <u><?php echo $cliente_i['result'][0]['account_number']; ?></u> Y el (comprador) Geeksify SAS identificado con Nit. 900.812.934-3 y con autorización para la venta de terminales móviles No 000917 de 14 de agosto de 2015 y bajo el número de verificación 0031001012 expedido por el Ministerio de Tecnologías de la Información y las Comunicaciones.</span>
</p>

<p class="Normal_20__28_Web_29_">
<span class="T4">EL VENDEDOR (Quien autoriza el traspaso) </span>
</p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Nombre: <u><?php echo strtoupper($cliente['result'][0]['first_name']." ".$cliente['result'][0]['last_name']); ?></u></span>
</p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Teléfono: </span>
<span class="T5"><u><?php echo strtoupper($cliente['result'][0]['phone_number']); ?></u></span>
</p>

<p class="Standard">
<span class="T2">Dirección: <u><?php echo strtoupper($cliente['result'][0]['address_1']." ".$cliente['result'][0]['address_2']); ?></u></span>
</p>

<p class="P3"> 
</p>
<p class="Standard">
<span class="T2">Ciudad: Bogotá</span>
</p>

<p class="P3"> </p>

<p class="Standard">
<span class="T2">Correo Electrónico: <u><?php echo strtoupper($cliente['result'][0]['email']); ?></u></span>
<span class="T8">  </span>
</p>

<p class="Standard">
<span class="T8">  </span>
</p>

<p class="Standard">
<span class="T2">Firma:         </span>
</p>

<p class="P7">
<span class="T9">                                                                    </span>Espacio para Huella Dactilar del vendedor (índice derecho) 
</p>

<p class="Normal_20__28_Web_29_">
<span class="T4">EL COMPRADOR (Quien acepta el traspaso) </span>
</p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Nombre: Geeksify S.A.S</span>
</p>

<p class="P5">Teléfono: 5484337
</p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Dirección: Carrera 29C No 75-22</span>
</p>

<p class="Normal_20__28_Web_29_">
<span class="T2">Ciudad: Bogotá</span>
</p>

<p class="P8">
<span class="T2">Firma:
<span class="T9">                                                           </span>Espacio para Huella Dactilar del   comprador    (índice derecho) </span>
</p>

</body>

</html>

<?php
}
}

?>
