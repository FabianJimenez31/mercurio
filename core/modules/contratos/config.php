<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$config_items=select_mysql("*",'app_config');
$items=$config_items['result'];
?>


<form action="?mod=contable&proc=save" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Configuración de Archivo Contable</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


<?php 

foreach($items as $i){

if($i['key']=='spreadsheet_format'){$i['label']='Tipo (para archivo contable)';}
if($i['key']=='time_format'){$i['label']='Centro (para archivo contable)';}
if($i['key']=='track_cash'){$i['label']='Cuenta de Caja (para archivo contable)';}
if($i['key']=='version'){$i['label']='Nombre de Caja (para archivo contable)';}
if($i['key']=='hide_signature'){$i['label']='Cuenta por Defecto (Ventas, Crédito , Archivo contable)';}
if($i['key']=='hide_store_account_payments_in_reports'){$i['label']='Cuenta por Defecto (Inventario, Crédito , Archivo contable)';}
if($i['key']=='hide_layaways_sales_in_reports'){$i['label']='Cuenta por Defecto (Inventario, Débito , Archivo contable)';}
if($i['key']=='show_receipt_after_suspending_sale'){$i['label']='Cuenta IVA (Ventas, Crédito , Archivo contable)';}
if($i['key']=='hide_customer_recent_sales'){$i['label']='Cuenta CREE (Ventas, Crédito , Archivo contable)';}
if($i['key']=='hide_dashboard_statistics'){$i['label']='Cuenta CREE (Ventas, Débito , Archivo contable)';}



if(isset($i['label'])){
?>

					<div class="form-group">
						<label for="<?php echo $i['key'];?>" class="col-sm-3 col-md-3 col-lg-2 control-label wide"><?php echo $i['label'];?>:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="<?php echo $i['key'];?>" value="<?php echo utf8_encode($i['value']);?>" id="product_id" class="form-control form-inps"  />						</div>
					</div>



<?php
}


}



?>


 


					
                    <div class="clear"></div>
				</div>
					
								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Aceptar" id="submitf" class="submit_button btn btn-primary"  />				</div>
			</form>			
			<div class="item_navigation">
				
							</div>
			
			</div>
		</div>
	</div>
</div>
		

	
		
<?php
load_template('partial','footer');
}


?>
