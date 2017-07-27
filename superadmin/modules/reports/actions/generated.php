<?php
global $var_array;
global $server;
global $x;

function create_chart_me($array,$type='store'){


if($_POST['by_date']==1){

$old_array=$array;
$new_array=array();
foreach($array as $km){

$new_array[md5(stripslashes((($type=='store')?$km['tienda']:$km['vendedor'])))]=array(
'tienda'=>$km['tienda'],
'vendedor'=>$km['vendedor']);

$new_array[md5(stripslashes((($type=='store')?$km['tienda']:$km['vendedor'])))]['articulos']+=$km['articulos'];
$new_array[md5(stripslashes((($type=='store')?$km['tienda']:$km['vendedor'])))]['ventas']+=$km['ventas'];
$new_array[md5(stripslashes((($type=='store')?$km['tienda']:$km['vendedor'])))]['ingresw']+=$km['ingresw'];

}

$array=$new_array;

usort($array, function($a, $b) {
    if ($a['ventas'] == $b['ventas']) {
        return 0;
    }
    return ($a['ventas'] < $b['ventas']) ? 1 : -1;
});
}


$s_result=array('s1'=>'' , 's2'=>'' , 's3'=>'');
$mx=0;
$mnd=($type=='store')?"Tienda":"Vendedor";
foreach($array as $rm){
if($rm['vendedor']==NULL || $rm['vendedor']==''){$rm['vendedor']="NO ASIGNADO";}
$s_result['s1'].=($mx==0)?"[[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['ventas']."]":",[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['ventas']."]";
$s_result['s2'].=($mx==0)?"[[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['articulos']."]":",[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['articulos']."]";
$s_result['s3'].=($mx==0)?"[[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['ingresw']."]":",[".(($type=='store')?"'".$rm['tienda']."'":"'".stripslashes($rm['vendedor'])."'").",".$rm['ingresw']."]";

$mx++;
}
$s_result['s1'].="]";
$s_result['s2'].="]";
$s_result['s3'].="]";
$result="  <li>
<h2>Gráfica de Desempeño</h2>
 <div id=\"chart1\" style=\"width:90%; height:110%\"></div>



<script>
\$(document).ready(function () {
    var s1 = ".$s_result['s2'].";
    var s2 = ".$s_result['s1'].";
    var s3 = ".$s_result['s3'].";
 
    plot1 = \$.jqplot(\"chart1\", [s2, s1 , s3], {
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        legend: {
            show: true,
            placement: 'outsideGrid'
        },




        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        series:[

	    {

		
                pointLabels: {
                    show: true
                },
                renderer: \$.jqplot.BarRenderer,
                showHighlight: false,
		label: 'Ventas',
                yaxis: 'y2axis',
                rendererOptions: {
                    // Speed up the animation a little bit.
                    // This is a number of milliseconds.  
                    // Default for bar series is 3000.  
                    animation: {
                        speed: 2500
                    },
                    barWidth: 15,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            }, 
            {
		label: 'Articulos Vendidos',
		yaxis: 'yaxis',
                rendererOptions: {
                    // speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for a line series is 2500.
                    animation: {
                        speed: 2000
                    }
                }
            },

            {
		yaxis: 'y3axis',
		label: 'Ingresos',
                rendererOptions: {
                    // speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for a line series is 2500.
                    animation: {
                        speed: 2000
                    }
                }
            }

        ],
        axesDefaults: {
            pad: 0
        },
        axes: {
            // These options will set up the x axis like a category axis.


			xaxis: {
					label:'".$mnd."',
					labelRenderer: \$.jqplot.CanvasAxisLabelRenderer,
tickRenderer: \$.jqplot.CanvasAxisTickRenderer,
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '8pt',
		angle: -30
          },

 tickOptions: {		angle: -30 },
					renderer: \$.jqplot.CategoryAxisRenderer
			},
            yaxis: {
					
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '8pt'
          },
                tickOptions: {
                    formatString: \"%'d\"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
					
          labelOptions: {

            fontFamily: 'Georgia, Serif',
            fontSize: '8pt'
          },
                tickOptions: {
			show: false, 
			showMark: false,
                    formatString: \"%'d\"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            },

            y3axis: {
					
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '8pt'
          },
                tickOptions: {
			show: false, 
			showMark: false,
                    formatString: \"\$%'d\"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },

        },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });
   
});
</script>

</li>
";


return $result;

}


if($var_array['username']=='tiendasadmin'){

$update_action="

<form id=\"create-user\" onsubmit=\"javascript:return submit_form('create-user','?module=reports&action=generated');\" enctype=\"multipart/form-data\" >

<input type=\"hidden\" name=\"start_date\" value=\"".$_POST['start_date']."\"    /> 
<input type=\"hidden\" name=\"end_date\" value=\"".$_POST['end_date']."\"    /> 
<input type=\"hidden\" name=\"rep_type\" value=\"".$_POST['rep_type']."\"   /> 
<input type=\"hidden\" name=\"by_date\" value=\"".(($_POST['by_date']==1)?1:'0')."\" />
				
			
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

CONCAT(".$s['prefix']."people.last_name,',',".$s['prefix']."people.first_name) AS vendedor ,
CONCAT(".$s['prefix']."T14.last_name,',',".$s['prefix']."T14.first_name) AS supervisor ,
CONCAT(".$s['prefix']."T15.last_name,',',".$s['prefix']."T15.first_name) AS cajero ,
CONCAT(".$s['prefix']."T16.last_name,',',".$s['prefix']."T16.first_name) AS nombre_cliente ,
CONCAT(".$s['prefix']."T17.company_name,' [ ',".$s['prefix']."T17.card_issuer,' ]') AS empresa_cliente ,
CONCAT(".$s['prefix']."T16.comments,' [ ',".$s['prefix']."T17.account_number,' ]') AS identificacion_cliente ,
".$s['prefix']."T16.phone_number AS telefono_cliente ,
".$s['prefix']."T16.email AS correo_electronico_cliente ,
".$s['prefix']."T16.address_1 AS direccion_cliente ,
".$s['prefix']."T16.city AS ciudad_cliente ,
".$s['prefix']."T16.state AS departamento_cliente ,
if(".$s['prefix']."T17.cc_token=1,'SI','NO') as habeas_data_cliente,
 ".$s['prefix']."sales.sale_id AS id_venta  ,
 CAST(".$s['prefix']."sales.sale_time as date) AS fecha ,
 CAST(".$s['prefix']."sales.sale_time as time) as hora ,
 ".$s['prefix']."sales.sale_time AS fecha_hora  ,
 '".stripslashes($s['name'])."' AS tienda  ,
 '".stripslashes($s['shortname'])."' AS clase ,
 ".$s['prefix']."sales_items.description AS articulo,
 ".$s['prefix']."sales_items.line AS orden  ,
 ".$s['prefix']."sales_items.serialnumber AS serial  ,
 ".$s['prefix']."items.name AS nombre_art,
 ".$s['prefix']."items.category AS categoria_art,
 ".$s['prefix']."items.item_number AS numero_art,
 ".$s['prefix']."items.product_id AS id_art,
 ".$s['prefix']."items.description AS descripcion_art,
 ROUND(".$s['prefix']."sales_items.item_unit_price * (1+(".$s['prefix']."sales_items_taxes.percent/100))) AS precio_publico


FROM ".$s['prefix']."sales_items 

LEFT JOIN ".$s['prefix']."sales ON ".$s['prefix']."sales.sale_id=".$s['prefix']."sales_items.sale_id

LEFT JOIN ".$s['prefix']."people ON ".$s['prefix']."sales.salesman=".$s['prefix']."people.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T14 ON ".$s['prefix']."sales.supervisor=".$s['prefix']."T14.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T15 ON ".$s['prefix']."sales.employee_id=".$s['prefix']."T15.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T16 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T16.person_id

LEFT JOIN ".$s['prefix']."customers as ".$s['prefix']."T17 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T17.person_id

LEFT JOIN ".$s['prefix']."items ON ".$s['prefix']."items.item_id=".$s['prefix']."sales_items.item_id

LEFT JOIN ".$s['prefix']."sales_items_taxes ON ".$s['prefix']."sales_items_taxes.sale_id=".$s['prefix']."sales.sale_id 

AND ".$s['prefix']."sales_items_taxes.item_id=".$s['prefix']."sales_items.item_id
";
$m++;
}else{
$query_core.="
UNION

SELECT 

CONCAT(".$s['prefix']."people.last_name,',',".$s['prefix']."people.first_name) AS vendedor ,
CONCAT(".$s['prefix']."T14.last_name,',',".$s['prefix']."T14.first_name) AS supervisor ,
CONCAT(".$s['prefix']."T15.last_name,',',".$s['prefix']."T15.first_name) AS cajero ,
CONCAT(".$s['prefix']."T16.last_name,',',".$s['prefix']."T16.first_name) AS nombre_cliente ,
CONCAT(".$s['prefix']."T17.company_name,' [ ',".$s['prefix']."T17.card_issuer,' ]') AS empresa_cliente ,
CONCAT(".$s['prefix']."T16.comments,' [ ',".$s['prefix']."T17.account_number,' ]') AS identificacion_cliente ,
".$s['prefix']."T16.phone_number AS telefono_cliente ,
".$s['prefix']."T16.email AS correo_electronico_cliente ,
".$s['prefix']."T16.address_1 AS direccion_cliente ,
".$s['prefix']."T16.city AS ciudad_cliente ,
".$s['prefix']."T16.state AS departamento_cliente ,
if(".$s['prefix']."T17.cc_token=1,'SI','NO') as habeas_data_cliente,
 ".$s['prefix']."sales.sale_id AS id_venta  ,
 CAST(".$s['prefix']."sales.sale_time as date) AS fecha ,
 CAST(".$s['prefix']."sales.sale_time as time) as hora ,
 ".$s['prefix']."sales.sale_time AS fecha_hora  ,
 '".stripslashes($s['name'])."' AS tienda  ,
 '".stripslashes($s['shortname'])."' AS clase ,
 ".$s['prefix']."sales_items.description AS articulo,
 ".$s['prefix']."sales_items.line AS orden  ,
 ".$s['prefix']."sales_items.serialnumber AS serial  ,
 ".$s['prefix']."items.name AS nombre_art,
 ".$s['prefix']."items.category AS categoria_art,
 ".$s['prefix']."items.item_number AS numero_art,
 ".$s['prefix']."items.product_id AS id_art,
 ".$s['prefix']."items.description AS descripcion_art,
 ROUND(".$s['prefix']."sales_items.item_unit_price * (1+(".$s['prefix']."sales_items_taxes.percent/100))) AS precio_publico


FROM ".$s['prefix']."sales_items 

LEFT JOIN ".$s['prefix']."sales ON ".$s['prefix']."sales.sale_id=".$s['prefix']."sales_items.sale_id

LEFT JOIN ".$s['prefix']."people ON ".$s['prefix']."sales.salesman=".$s['prefix']."people.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T14 ON ".$s['prefix']."sales.supervisor=".$s['prefix']."T14.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T15 ON ".$s['prefix']."sales.employee_id=".$s['prefix']."T15.person_id

LEFT JOIN ".$s['prefix']."people as ".$s['prefix']."T16 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T16.person_id

LEFT JOIN ".$s['prefix']."customers as ".$s['prefix']."T17 ON ".$s['prefix']."sales.customer_id=".$s['prefix']."T17.person_id

LEFT JOIN ".$s['prefix']."items ON ".$s['prefix']."items.item_id=".$s['prefix']."sales_items.item_id

LEFT JOIN ".$s['prefix']."sales_items_taxes ON ".$s['prefix']."sales_items_taxes.sale_id=".$s['prefix']."sales.sale_id 

AND ".$s['prefix']."sales_items_taxes.item_id=".$s['prefix']."sales_items.item_id

WHERE ".$s['prefix']."sales.sale_time>='$f_inicio 00:00:00' and ".$s['prefix']."sales.sale_time<='$f_final 23:59:59'
";
}




}



if($_POST['rep_type']=='store'){

$tiendas_qu=($_POST['by_date']==1)?"select fecha , tienda , count(distinct id_venta) as ventas , count(*) as articulos , sum(precio_publico) as ingreso  from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' group by  fecha , tienda":"select tienda , count(distinct id_venta) as ventas , count(*) as articulos , sum(precio_publico) as ingreso from ($query_core) as T1  where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' group by tienda order by ventas DESC";


$tiendas_q=ejecutar($tiendas_qu);

$m_d=mostrar($tiendas_q);
$f_x=0;
$res=array();

$articulos_vendidos=array();

foreach($m_d as $r){

$res[$f_x]=$r;
$fe_qu=($_POST['by_date']==1)?" and fecha_hora>='".$r['fecha']." 00:00:00' and fecha_hora<='".$r['fecha']." 23:59:59'":"";
$lista_articulos="select distinct articulo , nombre_art , categoria_art , numero_art , id_art , descripcion_art , precio_publico as precio_art from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' and tienda='".stripslashes($r['tienda'])."'  $fe_qu";





$arti=ejecutar($lista_articulos);
$arr=mostrar($arti);

$cuenta="<h2>Vendidos</h2><ul data-role=\"listview\">";
foreach($arr as $mm){


$cuenta.="  <li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\">

<h2>".substr($mm['articulo'],0,32)."

";

$art_q="select count(*) as cuenta from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' $fe_qu and tienda='".stripslashes($r['tienda'])."' and articulo='".stripslashes($mm['articulo'])."'";
$mmm=ejecutar($art_q);
$mff=mostrar($mmm);
$cuenta.=" (".$mff[0]['cuenta'].") 

</h2>
<p>
<b>Nombre:</b> ".$mm['nombre_art']."<br/>
<b>Categoria:</b> ".$mm['categoria_art']."<br/>
<b>Numero de Articulo:</b> ".$mm['numero_art']."<br/>
<b>Identificador de Articulo:</b> ".$mm['id_art']."<br/>
<b>Descripcion de Articulo:</b> ".str_replace(array("\n","\r"),"<br/>",$mm['descripcion_art'])."<br/>
<b>Precio Público:</b> $ ".number_format($mm['precio_art'],2,",",".")."<br/>
</p>

</li>";

$articulos_vendidos[md5(stripslashes($mm['articulo']))]['vendidos']+=$mff[0]['cuenta'];
$articulos_vendidos[md5(stripslashes($mm['articulo']))]['etiqueta']=$mm['articulo'];
$articulos_vendidos[md5(stripslashes($mm['articulo']))]['mas']="<p>
<b>Nombre:</b> ".$mm['nombre_art']."<br/>
<b>Categoria:</b> ".$mm['categoria_art']."<br/>
<b>Numero de Articulo:</b> ".$mm['numero_art']."<br/>
<b>Identificador de Articulo:</b> ".$mm['id_art']."<br/>
<b>Descripcion de Articulo:</b> ".str_replace(array("\n","\r"),"<br/>",$mm['descripcion_art'])."<br/>
<b>Precio Público:</b> $ ".number_format($mm['precio_art'],2,",",".")."<br/>
</p>";

}

$res[$f_x]['extras']=$cuenta."</ul>";
$res[$f_x]['ingresw']=$res[$f_x]['ingreso'];
$res[$f_x]['ingreso']="$ ".number_format($res[$f_x]['ingreso'],2,",",".");
$res[$f_x]['unico']=guid();


$f_x++;
}


usort($articulos_vendidos, function($a, $b) {
    if ($a['vendidos'] == $b['vendidos']) {
        return 0;
    }
    return ($a['vendidos'] < $b['vendidos']) ? 1 : -1;
});
$xar=1;
$com_max_art="  <li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\"><h2>Top 10 Articulos mas vendidos</h2><ul data-role=\"listview\">";
foreach($articulos_vendidos as $k){
if($xar<=10){

$com_max_art.="<li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\"><h2>$xar - ".substr($k['etiqueta'],0,40)." (".$k['vendidos'].")</h2>".$k['mas']."</li>";

}
$xar++;
}

$com_max_art.="</ul></li>";

$data=array(
'start'=>$f_inicio,
'end'=>$f_final,
'date_th'=>($_POST['by_date']==1)?"<th>Fecha</th>":"",
'date_td'=>($_POST['by_date']==1)?"<td>":"",
'date_td_end'=>($_POST['by_date']==1)?"</td>":"",
'results'=>$res,
'graph'=>create_chart_me($res,'store'),
'mas_vendidos'=>$com_max_art,
'update_repo'=>$update_action
);

dynamic_module_view("reports",'store',$data);



}elseif($_POST['rep_type']=='salesman'){

$tiendas_qu=($_POST['by_date']==1)?"select fecha , vendedor , tienda , clase , count(distinct id_venta) as ventas , count(*) as articulos , sum(precio_publico) as ingreso from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' group by  fecha , vendedor":"select  vendedor , tienda , clase , count(distinct id_venta) as ventas , count(*) as articulos , sum(precio_publico) as ingreso  from ($query_core) as T1  where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' group by vendedor order by ventas DESC";

$tiendas_q=ejecutar($tiendas_qu);

$m_d=mostrar($tiendas_q);
$f_x=0;
$res=array();

$articulos_vendidos=array();

foreach($m_d as $r){
if($r['vendedor']==NULL ){$s_f_vend="vendedor is NULL ";}else{$s_f_vend="vendedor = '".stripslashes($r['vendedor'])."'";}
$res[$f_x]=$r;
$fe_qu=($_POST['by_date']==1)?" and fecha_hora>='".$r['fecha']." 00:00:00' and fecha_hora<='".$r['fecha']." 23:59:59'":"";
$lista_articulos="select distinct articulo , nombre_art , categoria_art , numero_art , id_art , descripcion_art , precio_publico as precio_art from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' and tienda='".stripslashes($r['tienda'])."' and $s_f_vend $fe_qu";

$arti=ejecutar($lista_articulos);
$arr=mostrar($arti);

$cuenta="<h2>Vendidos</h2><ul data-role=\"listview\">";

foreach($arr as $mm){

$cuenta.="  <li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\">

<h2>".substr($mm['articulo'],0,32)."

";

$art_q="select count(*) as cuenta from ($query_core) as T1 where fecha_hora>='$f_inicio 00:00:00' and fecha_hora<='$f_final 23:59:59' $fe_qu and tienda='".stripslashes($r['tienda'])."' and articulo='".stripslashes($mm['articulo'])."' and $s_f_vend ";
$mmm=ejecutar($art_q);
$mff=mostrar($mmm);
$cuenta.=" (".$mff[0]['cuenta'].") 

</h2>
<p>
<b>Nombre:</b> ".$mm['nombre_art']."<br/>
<b>Categoria:</b> ".$mm['categoria_art']."<br/>
<b>Numero de Articulo:</b> ".$mm['numero_art']."<br/>
<b>Identificador de Articulo:</b> ".$mm['id_art']."<br/>
<b>Descripcion de Articulo:</b> ".str_replace(array("\n","\r"),"<br/>",$mm['descripcion_art'])."<br/>
<b>Precio Público:</b> $ ".number_format($mm['precio_art'],2,",",".")."<br/>
</p>

</li>";

$articulos_vendidos[md5(stripslashes($mm['articulo']))]['vendidos']+=$mff[0]['cuenta'];
$articulos_vendidos[md5(stripslashes($mm['articulo']))]['etiqueta']=$mm['articulo'];
$articulos_vendidos[md5(stripslashes($mm['articulo']))]['mas']="<p>
<b>Nombre:</b> ".$mm['nombre_art']."<br/>
<b>Categoria:</b> ".$mm['categoria_art']."<br/>
<b>Numero de Articulo:</b> ".$mm['numero_art']."<br/>
<b>Identificador de Articulo:</b> ".$mm['id_art']."<br/>
<b>Descripcion de Articulo:</b> ".str_replace(array("\n","\r"),"<br/>",$mm['descripcion_art'])."<br/>
<b>Precio Público:</b> $ ".number_format($mm['precio_art'],2,",",".")."<br/>
</p>";
}

$res[$f_x]['extras']=$cuenta."</ul>";
$res[$f_x]['ingresw']=$res[$f_x]['ingreso'];
$res[$f_x]['ingreso']="$ ".number_format($res[$f_x]['ingreso'],2,",",".");
$res[$f_x]['unico']=guid();


$f_x++;
}

usort($articulos_vendidos, function($a, $b) {
    if ($a['vendidos'] == $b['vendidos']) {
        return 0;
    }
    return ($a['vendidos'] < $b['vendidos']) ? 1 : -1;
});
$xar=1;
$com_max_art="  <li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\"><h2>Top 10 Articulos mas vendidos</h2><ul data-role=\"listview\">";
foreach($articulos_vendidos as $k){
if($xar<=10){

$com_max_art.="<li data-role=\"collapsible\" data-iconpos=\"right\" data-inset=\"false\"><h2>$xar - ".substr($k['etiqueta'],0,40)." (".$k['vendidos'].")</h2>".$k['mas']."</li>";

}
$xar++;
}

$com_max_art.="</ul></li>";


$data=array(
'start'=>$f_inicio,
'end'=>$f_final,
'date_th'=>($_POST['by_date']==1)?"<th>Fecha</th>":"",
'date_td'=>($_POST['by_date']==1)?"<td>":"",
'date_td_end'=>($_POST['by_date']==1)?"</td>":"",
'results'=>$res,
'columna'=>($_POST['by_date']==1)?'5':'4',
'graph'=>create_chart_me($res,'salesman'),
'mas_vendidos'=>$com_max_art,
'update_repo'=>$update_action
);

dynamic_module_view("reports",'salesman',$data);



}else{

echo "INVALID_REQUEST";

}





}else{

echo "NO TIENE PERMISOS PARA VER ESTE SITIO";


}

?>
