<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$info=select_mysql("t1.person_id , t2.last_name, t2.first_name , t1.account_number, t1.cc_token , t1.cc_preview ,  t2.email , t2.phone_number , t2.address_1, t2.city , t2.state , t1.card_issuer , t1.company_name , t2.comments","customers as t1 inner join ".DBPREFIX."people as t2 ON t1.person_id = t2.person_id","t1.person_id=".$_GET['person_id']);

$info['info']=$info['result'][0];

?>


<form action="?mod=customers&proc=save&person_id=<?php echo $_GET['person_id'];?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
<input type="hidden" name='redirect' value="<?php echo ($_GET['redirect']) ? $_GET['redirect'] : '' ; ?>">
	<div class="row" id="form">
		<div class="col-md-12">
			Los campos en rojo son requeridos			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Infomación del Cliente <?php echo $info['info']['first_name']." ".$info['info']['last_name']; ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


 					<div class="form-group">
					<label for="first_name" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="first_name" value="<?php echo $info['info']['first_name']; ?>" id="first_name" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="last_name" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Apellidos:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="last_name" value="<?php echo $info['info']['last_name']; ?>" id="last_name" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="comments" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Tipo de Identificación:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						
						<select name="comments" value="" id="comments" class="form-control form-inps" onchange="javascript:change_nit(this.value);">
							<option value="Cedula Ciudadania" <?php if($info['info']['comments']=="Cedula Ciudadania"){echo " selected ";}?>>Cedula Ciudadania</option>
							<option value="Tarjeta de Identidad" <?php if($info['info']['comments']=="Tarjeta de Identidad"){echo " selected ";}?>>Tarjeta de Identidad</option>
							<option value="Pasaporte" <?php if($info['info']['comments']=="Pasaporte"){echo " selected ";}?>>Pasaporte</option> 
							<option value="Cedula de extranjeria" <?php if($info['info']['comments']=="Cedula de extranjeria"){echo " selected ";}?>>Cedula de extranjeria</option>
							<option value="NIT"  <?php if($info['info']['comments']=="NIT"){echo " selected ";}?>>NIT</option>						
						</select>
						</div>
					</div>

 					<div class="form-group">
					<label for="account_number" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Número de Documento de Identificación:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="account_number" value="<?php echo $info['info']['account_number']; ?>" id="account_number" class="form-control form-inps"  />		
<input type="hidden" name="cc_token" value="<?php echo $info['info']['cc_token']; ?>" id="cc_token" class="form-control form-inps"  />
				</div>
					</div>




 					<div class="form-group">
					<label for="company_name" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Nombre de Empresa:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="company_name" value="<?php echo $info['info']['company_name']; ?>" id="company_name" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
					<label for="card_issuer" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Tipo de Empresa:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="card_issuer" value="<?php echo $info['info']['card_issuer']; ?>" id="account_number" class="form-control form-inps"  />						</div>
					</div>






 					<div class="form-group">
					<label for="phone_number" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Telefono:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="phone_number" value="<?php echo $info['info']['phone_number']; ?>" id="phone_number" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
					<label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Email:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="email" value="<?php echo $info['info']['email']; ?>" id="email" class="form-control form-inps"  />						</div>
					</div>

 					<div class="form-group">
					<label for="address_1" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Dirección:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="address_1" value="<?php echo $info['info']['address_1']; ?>" id="address_1" class="form-control form-inps"  />						</div>
					</div>



 					<div class="form-group">
					<label for="city" class="col-sm-3 col-md-3 col-lg-2 control-label wide required">Ciudad:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="city" value="<?php echo $info['info']['city']; ?>" id="city" class="form-control form-inps"  />						</div>
					</div>



 					<div class="form-group">
					<label for="state" class="col-sm-3 col-md-3 col-lg-2 control-label wide required">Departamento:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="state" value="<?php echo $info['info']['state']; ?>" id="state" class="form-control form-inps"  />						</div>
					</div>



				<div class="form-group override-taxes-container">
					<label class="col-sm-3 col-md-3 col-lg-2 control-label wide">Habeas Data:</label>					
					<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="checkbox" name="cc_preview"  <?php echo ($info['info']['cc_preview']==1) ? 'checked' : '' ?> value="1" />
					</div>
				</div>


					
				</div>




					


				


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
		

<script type='text/javascript'>

function change_nit(value){

if(value=="NIT"){

document.getElementById("cc_token").value="1";

}else{
document.getElementById("cc_token").value="0";
}

}


//validation and submit handling
$(document).ready(function()
{

	$('#item_form').validate({
		submitHandler:function(form)
		{

						doItemSubmit(form);

		},
		errorClass: "text-danger",
		errorElement: "span",
			highlight:function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
			},
		rules:
		{
				
				
			first_name:"required",
			last_name:"required",
			account_number:
			{
				required : true ,
				remote: 
				    { 
					url: "?mod=customers&proc=account_exists&person_id=<?php echo $_GET['person_id']; ?>",  
					type: "post"
					
				    } 
			},

			comments:"required",
			phone_number:"required",
			address_1:"required",
			state:"required",
			city:"required"

   		},
		messages:
		{			
						
						
												
			first_name:"Campo Requerido",
			last_name:"Campo Requerido",
			account_number:"Este Campo es Obligatorio y no debe existir para otro cliente",
			comments:"Campo Requerido",
			phone_number:"Campo Requerido",
			address_1:"Campo Requerido",
			state:"Campo Requerido",
			city:"Campo Requerido"

			
		}
	});
});

var submitting = false;

function doItemSubmit(form)
{

	if (submitting) return;
	submitting = true;
	$(form).ajaxSubmit({
	success:function(response)
	{
		
		submitting = false;
		gritter("\u00c9xito"+' #' + response.location_id,response.message,response.success ? 'gritter-item-success' : 'gritter-item-error',false,false);

		if(response.success)
		{
			if(response.redirect=='none'){
			alert(response.message);
			window.location.href = '?mod=customers&proc=main';}

			if(response.redirect=='presales'){
			alert(response.message);
			window.location.href = '?mod=presales&proc=main';}

			if(response.redirect=='sales'){
			alert(response.message);
			window.location.href = '?mod=sales&proc=main';}



		}

	
			},
		resetForm: true,
		dataType:'json'
	});
}

</script>




		
		
<?php
load_template('partial','footer');
}


?>
