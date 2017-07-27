                        <div id="sidebar" class="hidden-print minibar ">

                <ul>
                                                
<?php
global $user_array;
include(APPDIR."modules/modules_name.php");
$modulos=select_mysql("*","permissions","person_id=".$user_array['person_id'],"module_id DESC");

foreach($modulos['result'] as $m){
if($m['module_id']!='receivings' && $m['module_id']!='working_hours' && $m['module_id']!='recepcion_turnos' && $m['module_id']!='giftcards'  && $m['module_id']!='manual_sales' && $m['module_id']!='mis_ventas' && $m['module_id']!='supervisores'){
$nombre=str_replace(" de ", " ",$MODULES_NAMES_ARRAY[$m['module_id']]);
$icono_a=select_mysql("*","modules","module_id='".$m['module_id']."'");
$icono=$icono_a['result'][0]['icon'];

?>
                <li><a href="?mod=<?php echo $m['module_id'];?>&proc=main"><i class="fa fa-<?php echo $icono;?>"></i><span class="hidden-minibar"><?php echo $nombre; ?></span></a></li>

<?php 
}

} 

?>

                                            <li>

<li><a href="../?app_force_key=<?php echo md5('app4webmercuriounique'); ?>"><i class="fa fa-table"></i><span class="hidden-minibar">Cambiar Tienda</span></a></li>
                    </li>
                </ul>
            </div>

   <div id="content"  class="clearfix " >
<?php
if($_GET['mod']==''){$_GET['mod']='home';}
$icono_a=select_mysql("*","modules","module_id='".$_GET['mod']."'");
$icono=($_GET['mod']=='home') ? 'dashboard' : $icono_a['result'][0]['icon'];
?>
<div id="content-header" class="hidden-print">
	<h1><i class="icon fa fa-<?php echo $icono; ?>"></i> <?php echo $MODULES_NAMES_ARRAY[$_GET['mod']]; ?></h1>
</div>

<div id="debug"></div>
