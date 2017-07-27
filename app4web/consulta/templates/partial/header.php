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
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>

                    <link rel="stylesheet" rev="stylesheet" href="css/bootstrap.min.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.gritter.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery-ui.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/unicorn.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/custom.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/datepicker.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/bootstrap-select.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/select2.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/font-awesome.min.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.loadmask.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/token-input-facebook.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/KeyTips.min.css" media="all" />




<style type="text/css" title="currentStyle">
			@import "css/demo_page.css";
			@import "css/demo_table.css";
		</style>

                    <link rel="stylesheet" rev="stylesheet" href="css/dataTables.colVis.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/dataTables.colvis.jqueryui.css" media="all" />
		<script type="text/javascript" language="javascript" src="js/dataTables.colVis.js"></script>



                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables_themeroller.css" media="all" />
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
                    <link rel="stylesheet" rev="stylesheet" href="css/jquery.dataTables.css" media="all" />
                    <link rel="stylesheet" rev="stylesheet" href="css/dataTables.responsive.css" media="all" />
		<script type="text/javascript" language="javascript" src="js/dataTables.responsive.js"></script>

                    <link rel="stylesheet" rev="stylesheet" href="css/styled.css" media="all" />

<script>
$(document).ready(function() {
    $('.tablamuestra').dataTable({
		"bJQueryUI": true,
		"bPaginate": false
	});
} );

$(document).ready(function() {
    $('.tablamuestra_2').dataTable({
		"bJQueryUI": true
	});
} );

$(document).ready(function() {
    $('.tablamuestra_3').dataTable({
		"bJQueryUI": true,
		"bPaginate": false,
		"bSort": false
	});
} );
$(document).ready(function() {
    $('.tablamuestra_4').dataTable({
		"bJQueryUI": true,
		"bPaginate": false,
		"aaSorting": [[ 1, "asc" ]]
	});
} );




</script>

                <script type="text/javascript">
            var SITE_URL = "index.php";
        </script>

                    <script src="js/all.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        	

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


<script language="javascript" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.jqplot.css" />
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="js/jqplot/plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="js/jqplot/plugins/jqplot.pointLabels.min.js"></script>


    </head>

    <body data-color="grey" class="flat">

        <div class="modal fade hidden-print" id="myModal"></div>
        <div id="wrapper"  >
            <div id="header" class="hidden-print">
                <h1><a href="?app_force_key=<?php echo md5('app4webmercuriounique'); ?>&store_id=<?php echo $_GET['store_id']; ?>">                            <div id="header_logo" class="hidden-print header-log">
<?php
if( file_exists(APPDIR."../../custom_logo.png")){
$logo_url="../../custom_logo.png";
}else{
$logo_url="../../logo.png";
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
                                            
                                        
                </ul>
            </div>




























