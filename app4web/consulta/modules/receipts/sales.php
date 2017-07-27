<?php
$venta_id=$_GET['id'];
global $user_array;
global $application_config;
load_template('partial','header');
load_template('partial','menu');
$v=select_mysql("*",'sales','sale_id='.$venta_id);
$venta_info=$v['result'][0];
$customer_a=select_mysql('*','people','person_id='.$venta_info['customer_id']);
$customer_info=$customer_a['result'][0];

if($venta_info['cc_ref_no']>0){
$seller_aux=select_mysql("*",'presales','presale_id='.$venta_info['cc_ref_no']);
$s_a=$seller_aux['result'][0]['employee_id'];
$seller_a=select_mysql('*','people','person_id='.$s_a);
}else{
if($venta_info['salesman']>0){
$seller_a=select_mysql('*','people','person_id='.$venta_info['salesman']);
}else{
$seller_a=select_mysql('*','people','person_id='.$venta_info['employee_id']);
}
}



$seller_info=$seller_a['result'][0];


$cashier_a=select_mysql('*','people','person_id='.$venta_info['employee_id']);
$cashier_info=$cashier_a['result'][0];
$customer_b=select_mysql('*','customers','person_id='.$venta_info['customer_id']);
$customer_info2=$customer_b['result'][0];

if($_GET['sale_show']=='yes'){
$vendedor_metas=$venta_info['salesman'];

$mensuales_a=select_mysql("*","sales","sale_time>='".date("Y-m")."-01 00:00:00' and sale_time<='".date("Y-m-d")." 23:59:59' and salesman=".$vendedor_metas);
$mens_v=$mensuales_a['count'];

$diarias_a=select_mysql("*","sales","sale_time>='".date("Y-m-d")." 00:00:00' and sale_time<='".date("Y-m-d")." 23:59:59' and salesman=".$vendedor_metas);
$diarias_v=$diarias_a['count'];

echo "<script>alert('Felicidades al Vendedor: ".strtoupper($seller_info['first_name']." ".$seller_info['last_name'])." \\n\\nHoy ha realizado $diarias_v ventas\\n\\nEste mes ha realizado: $mens_v ventas');</script>";
}
?>



<!----------------------NUWEVO DISEÑO--------------------------------->


<div class="container">
    <div class="row">
        <!--Margen SUperior-->
        <div class="col-xs-12">
            <div class="item">
                <div class="content">
                    <p class="text-center"> </p>
                </div>           
            </div>                
        </div>        
    </div>
    <!--Cuerpo de la factura-->
    <div class="row">
        <!--Margen Izq-->
        <!--        <div class="col-xs-1">
                    <div class="item">
                        <div class="content">
                            </br>
                        </div>           
                    </div>                
                </div> -->
        <!--Bloque Central-->
        <div class="col-xs-12">
            <!--Encabezado Factura-->
            <div class="row" style="font-size: 8px;">
                <!--Logo-->
                <div class="col-xs-6">
                    <div class="item">
                        <div class="content">

<?php
if( file_exists(APPDIR."images/custom_logo.png")){
$logo_url="images/custom_logo.png";
}else{
$logo_url="images/logo.png";
}

?>
                                                            <div id="company_logo"><img width='100px' src="<?php echo $logo_url; ?>" alt=""/><br/></div>
                                                        <div> <p class="text-left">RÉGIMEN COMÚN</br></p></div>
                        </div>           
                    </div>                
                </div>
                <!--Resolucion Facturacion-->
                <div class="col-xs-6" style="font-size: 7px;">
                    <div class="item">
                        <div class="content">
                            </br>
                            <p class="text-center">  <?php echo $application_config['company'];?> </br>		
                                 ACTIVIDAD ICA 4741</br>                                No Somos Agentes Retenedores de IVA Factura por computador</br>                                </br>                                Resolución DIAN <?php echo $venta_info['resolucion'];?></br>                                Habilitación de Facturación</br>                                <?php echo $application_config['sale_prefix'];?>  <?php echo $application_config['inicioResolucionActual'];?>-<?php echo $application_config['finResolucionActual'];?></br>                            </p>
                        </div>            
                    </div>                
                </div>                
            </div> 
            </br>
            <!--Informacion Cliente-->
            <div class="row" style="font-size: 9px;">
                <div class="col-xs-6">
                    <div class="item">
                        <div class="content">   
                            <p class="text-left"> 
		
                                Nombre / Razón Social: <?php echo strtoupper($customer_info['first_name']." ".$customer_info['last_name']); ?>                                  </br>Cedula / Nit:  <?php echo $customer_info2['account_number'];?>                                </br>Dirección: Dirección : <?php echo strtoupper($customer_info['address_1']); ?>                                 </br>Ciudad: <?php echo strtoupper($customer_info['city']);?>                                </br>Telefono: Teléfono : <?php echo $customer_info['phone_number']; ?>		                            </p>
                        </div>           
                    </div>                
                </div>
                <!--Num Factura-->
                <div class="col-xs-6">
                    <div class="item">
                        <div class="content">
                            <p class="text-left">
                                <b><?php echo $application_config['config_invoice_header_title'];?> No. :</b> <?php echo $application_config['sale_prefix'];?> <?php echo ($venta_id>0) ? $venta_id : $venta_info['id_manual']."  [ Folio Interno: ".$application_config['sale_prefix']." $venta_id]" ; ?>                                </br>
                                </br>Fecha: <?php echo substr($venta_info['sale_time'],0,10); ?>                                
				</br>Cajero: <?php echo strtoupper($cashier_info['first_name']." ".$cashier_info['last_name']); ?>
                                </br>Vendedor: <?php echo strtoupper($seller_info['first_name']." ".$seller_info['last_name']); ?>                            </p>
                        </div>           
                    </div>                
                </div>
            </div>
            <!--Informacion Items Vendidos-->
            <div class="row" style="font-size: 9px;">   
		<table border="0" width="100%" style="width:100%;padding: 15px;font-size: 9px;" cellpadding="10">
		<thead>
		<tr >             
                <th class="text-left" style="padding: 10px;" > Item </th>
                <th class="text-left" style="padding: 10px;">Nombre</th>
                <th class="text-left" style="padding: 10px;">Referencia</th>
                <th class="text-left" style="padding: 10px;">Serial</th>
                <th class="text-left" style="padding: 10px;">Cantidad</th>
                <th class="text-left" style="padding: 10px;">Valor</th>
		</tr>
		</thead>
		<tbody>

<?php
$x=1;
$items=select_mysql('*','sales_items','sale_id='.$venta_id);
$taxes=0;
$discount=0;
$subtotal=0;
$final=0;
foreach($items['result'] as $i){
$item_i=select_mysql('*','items','item_id='.$i['item_id']);
$item_info=$item_i['result'][0];
$discount+=($i['item_unit_price']/(1-($i['discount_percent']/100)))*($i['discount_percent']/100);
$discount_partial=($i['item_unit_price']/(1-($i['discount_percent']/100)))*($i['discount_percent']/100);
$subtotal+=$i['item_unit_price'];
$tx=select_mysql("*","sales_items_taxes","sale_id=".$venta_id." and item_id=".$i['item_id']);
$tx_per=$tx['result'][0]['percent'];
$taxes+=ceil($i['item_unit_price']*($tx_per/100));
$final+=$i['item_unit_price']+ceil($i['item_unit_price']*($tx_per/100));

?>

                    			<tr>
                                    <td class="text-left" style="padding: 10px;"> <?php echo $x; ?></td>
  
                                    <td class="text-left" style="padding: 10px;"> <?php echo $item_info['name']?> </td>

                                    <td class="text-left" style="padding: 10px;"><?php echo $item_info['product_id']?></td>

                                    <td class="text-left" style="padding: 10px;">
			<?php echo ($i['num_tel']!='')?"Contrato: ".$i['serialnumber']."<br />"."Número Telefónico: ".$i['num_tel']:$i['serialnumber']; ?><?php echo (($i['post_first']==1)? '<br />Primer Pago':'')?>
					</td>

                                    <td class="text-left" style="padding: 10px;">1</td>

                                    <td class="text-left" style="padding: 10px;">$<?php echo number_format($i['item_unit_price']+$discount_partial,2,',','.'); ?></td>
                                        
                        </tr>

<?php
$x++;
}

$item_kits=select_mysql('*','sales_item_kits','sale_id='.$venta_id);
foreach($item_kits['result'] as $ik){

$item_kit_a=select_mysql("*",'item_kits','item_kit_id='.$ik['item_kit_id']);
$item_kit_info=$item_kit_a['result'][0];
$tx=select_mysql("*","sales_item_kits_taxes",'item_kit_id='.$ik['item_kit_id']);
$tx_per=$tx['result'][0]['percent'];
$taxes+=$ik['item_kit_unit_price']*($tx_per/100);
$subtotal+=$ik['item_kit_unit_price'];
$final+=$ik['item_kit_unit_price']+$ik['item_kit_unit_price']*($tx_per/100);
?>


                    			<tr>
                                    <td class="text-left" style="padding: 10px;"> <?php echo $x; ?></td>
  
                                    <td class="text-left" style="padding: 10px;"> <?php echo $item_kit_info['name']?> </td>

                                    <td class="text-left" style="padding: 10px;"><?php echo $item_kit_info['product_id']?></td>

                                    <td class="text-left" style="padding: 10px;">-</td>

                                    <td class="text-left" style="padding: 10px;">1</td>

                                    <td class="text-left" style="padding: 10px;">$<?php echo number_format($ik['item_kit_unit_price'],2,',','.'); ?></td>
                                        
                        </tr>



<?php

$item_childs_a=explode("|",substr($ik['description'],1));

foreach($item_childs_a as $ic){

$ic_info=explode(":::",$ic);

$item_i=select_mysql('*','items',"product_id='".$ic_info[0]."'");
$item_info=$item_i['result'][0];

?>


                    			<tr>
                                    <td class="text-left" style="padding: 10px;"> - </td>
  
                                    <td class="text-left" style="padding: 10px;"> <?php echo $item_info['name'];?> </td>

                                    <td class="text-left" style="padding: 10px;"><?php echo $item_info['product_id'];?></td>

                                    <td class="text-left" style="padding: 10px;"><?php echo $ic_info[1]; ?></td>

                                    <td class="text-left" style="padding: 10px;">1</td>

                                    <td class="text-left" style="padding: 10px;">-</td>
                                        
                        </tr>


<?php




}


$x++;
}
?>
                                    </tbody></table>
            </div>
            <!--Informacion de garantia-->
            <div class="row" style="font-size: 5px;">
                <div>
                    <div class="col-xs-12">
                        <div class="item">
                            <div class="content">   
                                </br><p class="text-muted text-center"> Mediante mi firma en este documento acepto la compra y certifico que he recibido las instrucciones pertinentes en cuanto a las características, usos, garantías y cuidados de los productos, a la vez que he recibido los artículos en este documento a satisfacción. Igualmente me han informado que todos los productos contenidos en este documento están amparados por las garantías de sus fabricantes y que de ninguna manera estas cubren los daños ocasionados por una utilización indebida o abuso de los mismos. En caso que requiera cambiar un producto me comprometo a hacer devolución del articulo y de su empaque en perfectas condiciones. Si el producto es usado o el empaque alterado (roto, manipulado, en malas condiciones), soy consiente de que la tienda no realizará cambio. He sido informado del procedimiento en caso de eventuales reclamaciones por garantía y acepto las condiciones. <?php echo $application_config['config_invoice_footer_addon'];?> </p>
				    				<br/><br/>
				
<?php echo ($venta_info['show_comment_on_receipt']==1) ? "<b>Comentarios:</b><br/><br/>".str_replace(array("\r","\n"),"<br>",$venta_info['comment']):'' ; ?>                           </div>           
                        </div>                
                    </div>
                </div>
            </div>
            <!--Informacion de Total y Aceptacion-->
            <div class="row" style="font-size: 6px;">
                <div class="col-xs-8">
                    <div class="item">
                        <div class="content">   
                            <div class="col-xs-2 table-bordered">
                                <div class="content">
                                    Acepta<br/>Firma y/o sello
                                </div> 
                            </div> 
                            <div class="col-xs-4 table-bordered">
                                <div class="content">
                                    </br>
                                    </br>
                                </div> 
                            </div> 
 <!--                       <div class="col-xs-2 table-bordered">
                                <div class="content">
                                    Recibido</br>por
                                </div> 
                            </div> 
                            <div class="col-xs-4 table-bordered">
                                <div class="content">
                                    </br>
                                    </br>
                                </div> 
                            </div> -->
                        </div>           
                    </div>                
                </div>
                <div class="col-xs-4">
                    <div class="item">
                        <div class="col-xs-6">
                            <div class="content">   
                                <p class="text-left"> Subtotal </p>
                                <p class="text-left"> Descuento </p>
	
                                <p class="text-left"> IVA </p>

	                                <p class="text-left"> Total Factura </p>
                                



                            </div> 
                        </div>
                        <div class="col-xs-6">
                            <div class="content">   
                                <p class="text-right"> $<?php echo number_format($subtotal+$discount,2,',','.'); ?> </p>
                                <p class="text-right"> $<?php echo number_format($discount,2,',','.'); ?> </p>
	
                               <p class="text-right"> $<?php echo number_format($taxes,2,',','.'); ?> </p>

	                                
                                <p class="text-right"> $<?php echo number_format($final,2,',','.'); ?> </p>




                           </div> 
                        </div>    

   <div>
<center>
<table border="0" width="90%">

<?php
$payments_a=select_mysql("*","sales_payments",'sale_id='.$venta_id);
foreach($payments_a['result'] as $p){
?>

	
<tr>
		<td class="text-left">-------- </td>
		<td class="text-right">------- </td>
</tr>

<tr>
		<td class="text-left">Metodo de Pago </td>
		<td class="text-right"><?php echo ($p['payment_type']=='Efectivo') ? $p['payment_type'] : $p['payment_type']." [ ".$p['truncated_card']." ]"   ?>  </td>
</tr>
<tr>
<td class="text-left">Monto </td>
<td class="text-right"> $<?php echo number_format($p['payment_amount'],2,',','.');?> </td>
</tr>
<?php
}
?>	
	                              
</table>
</center>
</div>


                    </div>                
                </div>
            </div>

        </div>  

    </div>
</div>


<!----------------------NUWEVO DISEÑO--------------------------------->

    <button class="btn btn-primary text-white hidden-print" id="print_button" onClick="window.print()" > Imprimir </button>
<a class="btn btn-info btn-sm hidden-print" href="?mod=sales&proc=main">Nueva Venta</a>
    <br />
    
    <script type="text/javascript">
/*        $(window).load(function ()
        {
            window.print();
        });*/
    </script>



<?php
load_template('partial','footer');
?>
