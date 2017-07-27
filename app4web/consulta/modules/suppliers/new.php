<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');

?>


<form action="?mod=suppliers&proc=save" method="post" accept-charset="utf-8" id="item_form" class="form-horizontal">
	<div class="row" id="form">
		<div class="col-md-12">
			Los campos en rojo son requeridos			
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa fa-align-justify"></i>									
					</span>
					<h5>Infomación de la Ubicación </h5>
				</div>
				<div class="widget-content nopadding">
					<div class="row">
					<div class="span7 ">


 					<div class="form-group">
					<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label required wide">Nombre:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="name" value="" id="name" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
					<label for="phone" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Telefono:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="phone" value="" id="phone" class="form-control form-inps"  />						</div>
					</div>


 					<div class="form-group">
					<label for="email" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Email:</label>						<div class="col-sm-9 col-md-9 col-lg-10">
						<input type="text" name="email" value="" id="email" class="form-control form-inps"  />						</div>
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
				
				
			name:"required"

   		},
		messages:
		{			
						
						
												
			name:"Nombre es requerido"

			
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
			alert(response.message);
			window.location.href = '?mod=suppliers&proc=main';
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
