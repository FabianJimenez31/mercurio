<?php
global $user_array;
$user_info=user_info($user_array['person_id']);

$config_items=select_mysql("*",'app_config',"`key`='date_format'");
$items=$config_items['result'][0];
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo SITE_NAME; ?></title>
        <meta charset="UTF-8" >
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>

                    <link rel="stylesheet" rev="stylesheet" href="css/bootstrap.min.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.gritter.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery-ui.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/unicorn.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/custom.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/datepicker.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/bootstrap-select.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/select2.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/font-awesome.min.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.loadmask.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/token-input-facebook.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/KeyTips.min.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/dataTables.bootstrap.min.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/responsive.bootstrap.min.css?date=<?php echo date('Ymd') ?>" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery-ui.css?date=<?php echo date('Ymd') ?>" media="all" />


                   <link rel="stylesheet" rev="stylesheet" href="css/styled.css?date=<?php echo date('Ymd') ?>" media="all" />



                <script type="text/javascript">
            var SITE_URL = "index.php";
        </script>
                    <script src="js/jquery.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/bootstrap.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.dataTables.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/dataTables.bootstrap.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery-ui.custom.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/bootstrap-datepicker.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/dataTables.responsive.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/responsive.bootstrap.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.validate.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.loadmask.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.form.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.gritter.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

                    <script src="js/jquery.jpanelmenu.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.tokeninput.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/select2.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/bootstrap-select.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/common.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/imagePreview.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.clicktoggle.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.flot.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.flot.pie.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/jquery.flot.time.min.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>
                    <script src="js/unicorn.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>


<!--                    <script src="js/all.js?date=<?php echo date('Ymd') ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>-->
        	

        <script type="text/javascript">
            COMMON_SUCCESS = "\u00c9xito";
            COMMON_ERROR = "Error";
            $.ajaxSetup({
                cache: false,
                headers: {"cache-control": "no-cache"}
            });

            $(document).ready(function ()
            {
                //Ajax submit current location
                $("#employee_current_location_id").change(function ()
                {
                    $("#form_set_employee_current_location_id").ajaxSubmit(function ()
                    {
                        window.location.reload(true);
                    });
                });

                //Keep session alive by sending a request every 5 minutes
                setInterval(function () {
                    $.get('index.php?mod=home&proc=keep');
                }, 300000);
            });
        </script>


<script language="javascript" type="text/javascript" src="js/jquery.jqplot.min.js?date=<?php echo date('Ymd') ?>"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css?date=<?php echo date('Ymd') ?>" />
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.dateAxisRenderer.min.js?date=<?php echo date('Ymd') ?>"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js?date=<?php echo date('Ymd') ?>"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js?date=<?php echo date('Ymd') ?>"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js?date=<?php echo date('Ymd') ?>"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.barRenderer.min.js?date=<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.highlighter.min.js?date=<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.cursor.min.js?date=<?php echo date('Ymd') ?>"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.pointLabels.min.js?date=<?php echo date('Ymd') ?>"></script>



<script>
$(document).ready(function() {
    $('.tablamuestra').dataTable({
		"bPaginate": false
	});
} );

$(document).ready(function() {
    $('.tablamuestra_2').dataTable({
	});
} );

$(document).ready(function() {
    $('.tablamuestra_3').dataTable({
		"bPaginate": false,
		"bSort": false
	});
} );
$(document).ready(function() {
    $('.tablamuestra_4').dataTable({
		"bPaginate": false,
		"aaSorting": [[ 1, "asc" ]]
	});
} );

function show_loading_screen(how_show){


document.getElementById("submit_files_loader").style.display = how_show;



}


</script>



    </head>

    <body data-color="grey" class="flat">

<div>
<div id="submit_files_loader" style="width:100%;height:100%;position:fixed;top:0;left:0;right:0;bottom:0;opacity:0.9;background-color:black;color:white;z-index:999999999;display:none;"><center><br/><br/><br/><br/><br/><br/><b>Estamos procesando su solicitud.<br/>Espere un momento por favor</b></center>
</div>
<marquee behavior="scroll" direction="left" class="hidden-print" style="z-index:9999999;position:fixed;top:0px;left:120px;width:350px;height:20px;font-weight: bold; "><p class="bannedme "><?php echo $items['value']; ?></p></marquee>
</div>

        <div class="modal fade hidden-print" id="myModal"></div>
        <div id="wrapper"  >
            <div id="header" class="hidden-print">
                <h1><a href="?">                            <div id="header_logo" class="hidden-print header-log">
<?php
if( file_exists(APPDIR."images/custom_logo.png")){
$logo_url="images/custom_logo.png";
}else{
$logo_url="images/logo.png";
}

?>
<img src="<?php echo $logo_url; ?>" alt=""/>
</div>
                        </a></h1>		
                <a id="menu-trigger" href="#"><i class="fa fa-bars fa fa-2x"></i></a>	

                <div class="clear"></div>
            </div>




            <div id="user-nav" class="hidden-print hidden-xs">

                <ul class="btn-group ">
                    <li class="btn  hidden-xs"><a title="" href="#" class="cursor:default;"><i class="icon fa fa-user fa-2x"></i> <span class="text">	Bienvenido(a) <b> <?php echo $user_info['first_name']." ".$user_info['last_name']?>! </b></span></a></li>
                    <li class="btn  hidden-xs disabled" >
                        <a title="" href="" onclick="return false;"><i class="icon fa fa-clock-o fa-2x"></i> <span class="text">
                                <?php echo date("h:i A")." ".date("d/m/Y");?>                           </span></a>
                    </li>

<?php

if($user_array['person_id']>0){

?>
                                            <li class="btn "><a href="?mod=config&proc=main"><i class="icon fa fa-cog"></i><span class="text">Configuración</span></a></li><?php

}

?>


                                        <li class="btn  ">
                        <a href="?mod=home&proc=logout"><i class="fa fa-power-off"></i><span class="text">Salir</span></a>                    </li>
                </ul>
            </div>




























