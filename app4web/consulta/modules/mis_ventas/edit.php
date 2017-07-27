<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$inf=select_mysql("*","cuentascontables","id=".$_GET['item_id']);
$info=$inf['result'][0];
?>


<form action="?mod=contable&proc=save_cat&item_id=<?php echo $_GET['item_id']?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			Los campos en rojo son requeridos			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Infomación de la Cuenta</h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">
					<div class="form-group">
						<label for="categoria" class="col-sm-3 col-md-3 col-lg-2  control-label wide">Categoria:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<select name="categoria" id="categoria" class="form-control form-inps">
<?php

$categ=select_mysql("DISTINCT category","items");

foreach($categ['result'] as $m){
$enabled=($info['categoria']==$m['category'])? 'selected' : '';
echo "<option $enabled value=\"".$m['category']."\">".$m['category']."</option>";

}

?>

							</select>			
						</div>
					</div>

					<div class="form-group">
						<label for="credito" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Cuenta de Venta (Crédito):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
							<input type="text" name="credito" value="<?php echo $info['credito'];?>" id="credito" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="i_credito" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Cuenta de Inventario (Crédito):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="i_credito" value="<?php echo $info['i_credito'];?>" id="i_credito" class="form-control form-inps"  />						</div>
					</div>

					<div class="form-group">
					<label for="i_debito" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">Cuenta de Inventario (Débito):</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="i_debito" value="<?php echo $info['i_debito'];?>" id="i_debito" class="form-control form-inps"  />						</div>
					</div>



					
					
				</div>


								
		
				
			
					<div class="form-actions">
				<input type="submit" name="submitf" value="Guardar Cambios" id="submitf" class="submit_button btn btn-primary"  />				</div>
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
