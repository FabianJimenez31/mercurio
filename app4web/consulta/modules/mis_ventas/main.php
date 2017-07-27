<?php

global $user_array;
global $current_sale_array;
global $application_config;


if(isset($user_array['person_id'])){
load_template('partial','header');
load_template('partial','menu');

?>

<br/>
<br/>
<br/>
<br/>
<center>
<div id="chart1" class="tabla-ventas"></div>
</center>

<?php 

$s1="";
$s2="";

$mtas=select_mysql("*",'employees',"person_id=".$user_array['person_id']);
$mensual=$mtas['result'][0]['meta_mensual'];
$diaria=$mtas['result'][0]['meta_diaria'];

for($x=0;$x<=6;$x++){
$y=6-$x;
$fecha=date("Y-m-d",strtotime("-$y days"));
$fecha_label=date("w",strtotime("-$y days"));
switch($fecha_label){

case 0:
	$fecha_label="Dom";
	break;

case 1:
	$fecha_label="Lun";
	break;


case 2:
	$fecha_label="Mar";
	break;


case 3:
	$fecha_label="Mie";
	break;


case 4:
	$fecha_label="Jue";
	break;


case 5:
	$fecha_label="Vie";
	break;


case 6:
	$fecha_label="Dom";
	break;


}

$vtas_hoy_a=select_mysql("*","sales","sale_time<='$fecha 23:59:59' and sale_time>='$fecha 00:00:00' and salesman=".$user_array['person_id']);
$vtas_hoy=$vtas_hoy_a['count'];
if($x==0){
$s1.="[['$fecha_label' , $vtas_hoy] ";
$s2.="[['$fecha_label' , $diaria] ";
}else{
$s1.=", ['$fecha_label' , $vtas_hoy] ";
$s2.=", ['$fecha_label' , $diaria] ";

}

if($x==6){
$hoy=$vtas_hoy;
}

}

$mensuales_a=select_mysql("*","sales","sale_time>='".date("Y-m")."-01 00:00:00' and sale_time<='".date("Y-m-d")." 23:59:59' and salesman=".$user_array['person_id']);
$mens_v=$mensuales_a['count'];

$s1.="];";
$s2.="];";

?>

<script>
$(document).ready(function () {
    var s1 = <?php echo $s2; ?>
    var s2 = <?php echo $s1; ?>;
 
    plot1 = $.jqplot("chart1", [s2, s1], {
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
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
                renderer: $.jqplot.BarRenderer,
                showHighlight: false,
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
/*            xaxis: {
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                tickInset: 0.5,
                minorTicks: 1
            }
            },*/

			xaxis: {
					label:'Fecha<br/><br/>Hoy: <?php echo $hoy; ?>/<?php echo $diaria; ?><br/><br/>Mensual: <?php echo $mens_v;?>/<?php echo $mensual; ?>',
					labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '12pt'
          },
					renderer: $.jqplot.CategoryAxisRenderer
			},
            yaxis: {
					label:'Meta',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '12pt'
          },
                tickOptions: {
                    formatString: "%'d"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
					label:'Ventas',
				labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          labelOptions: {
            fontFamily: 'Georgia, Serif',
            fontSize: '12pt'
          },
                tickOptions: {
                    formatString: "%'d"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
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


<?php

load_template('partial','footer');
}?>
