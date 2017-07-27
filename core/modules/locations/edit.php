<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
$info=location_info($_GET['location_id']);
?>


<form action="?mod=locations&proc=save&location_id=<?php echo $_GET['location_id'];?>" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			Los campos en rojo son requeridos			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Infomación de la Ubicación <?php echo $info['info']['name']; ?></h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


 					<div class="form-group">
					<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="name" value="<?php echo $info['info']['name']; ?>" id="name" class="form-control form-inps"  />						</div>
					</div>


					<div class="form-group">
					<label for="address" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Dirección:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<textarea name="address" cols="17" rows="5" id="address" class="form-control  form-textarea" ><?php echo $info['info']['address']; ?></textarea>						</div>
					</div>


 					<div class="form-group">
					<label for="phone" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Telefono:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="phone" value="<?php echo $info['info']['phone']; ?>" id="phone" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
					<label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Email:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="email" value="<?php echo $info['info']['email']; ?>" id="email" class="form-control form-inps"  />						</div>
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
				
				
			name:"required",
			address:"required",
			phone:"required",

   		},
		messages:
		{			
						
						
												
			name:"Nombre de Art\u00edculo es requerido",
			address:"Direccion es requerido",
			phone:"Telefono es requerido",
			
		}
	});
});

var submitting = false;

function doItemSubmit(form)
{
	if (submitting) return;
	submitting = true;
	$("#form").mask("por favor espere ...");
	$(form).ajaxSubmit({
	success:function(response)
	{
		$("#form").unmask();
		submitting = false;
		gritter("\u00c9xito"+' #' + response.location_id,response.message,response.success ? 'gritter-item-success' : 'gritter-item-error',false,false);

		if(response.success)
		{
			alert(response.message);
			window.location.href = '?mod=locations&proc=main'
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
