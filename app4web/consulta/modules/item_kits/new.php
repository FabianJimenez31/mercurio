<?php
global $user_array;

if(permitido($user_array['person_id'],$_GET['mod'])){
load_template('partial','header');
load_template('partial','menu');
?>


<div class="row" id="form">
	<div class="col-md-12">
			Los campos en rojo son requeridos			
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa fa-align-justify"></i>									
				</span>
				<h5>Información de Kit</h5>
			</div>
			<div class="widget-content nopadding">
				<form action="?mod=item_kits&proc=save" method="post" accept-charset="utf-8" id="item_kit_form" class="form-horizontal">				<span class="help-block" style="margin-left: 35px">Kits artículo se componen de 1 o más elementos para ver como un grupo. Agregue su primer punto con el campo de abajo.</span>
			<div class="form-group">
			<label for="item" class="col-sm-3 col-md-3 col-lg-2 control-label  ">Agregar Artículo:</label>				<div class="col-sm-9 col-md-9 col-lg-10">
					<input type="text" name="item" value="" id="item" class="input-xlarge" accesskey="k" placeholder="Ingresa un artículo o de código de barras escaneado"  />				</div>
			</div>

	<div class="container-fluid">
		<div class="row">
			<div class="span6 offset3">
				<div class="widget-box">
					<div class="widget-title">
						<span class="icon">
							<i class="fa fa-th"></i>
						</span>
						<h5>Artículos agregados</h5>
					</div>
					<div class="widget-content nopadding">
						<table id="item_kit_items" class="table table-bordered table-striped table-hover text-success text-center"><thead>
							<tr>
								<th>Borrar</th>
								<th>Artículo</th>
								<th>Cantidad</th>
							</tr>
	</thead><tbody id="articulos"></tbody>
							
	
													</table>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
		<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  ">UPC/EAN/ISBN:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="item_kit_number" value="" class="form-control form-inps" id="item_kit_number"  />			</div>
		</div>
		
<input type="hidden" name="redirect" value="0" />
				
		<div class="form-group">
			<label for="product_id" class="col-sm-3 col-md-3 col-lg-2 control-label wide">Identificación del producto:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
				<input type="text" name="product_id" value="" id="product_id" class="form-control form-inps"  />			</div>
		</div>
		

		<div class="form-group">
		<label for="name" class="col-sm-3 col-md-3 col-lg-2 control-label  required">Nombre del Grupo:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="name" value="" class="form-control form-inps" id="name"  />			</div>
		</div>

		<div class="form-group">
		<label for="category" class="col-sm-3 col-md-3 col-lg-2 control-label  required wide">Categoría:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="category" value="" class="form-control form-inps" id="category"  />			</div>
		</div>
		
		<div class="form-group">
		<label for="description" class="col-sm-3 col-md-3 col-lg-2 control-label  ">Descripción del Grupo:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<textarea name="description" cols="17" rows="5" id="description" class="form-textarea" ></textarea>			</div>
		</div>
		
		
		<div class="form-group">
		<label for="iva" class="col-sm-3 col-md-3 col-lg-2 control-label  wide">IVA (Se agregará en Venta):</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="iva" value="16" id="tax_included"   />		</div>
		</div>



		<div class="form-group">
		<label for="unit_price" class="col-sm-3 col-md-3 col-lg-2 control-label  ">Precio de venta:</label>			<div class="col-sm-9 col-md-9 col-lg-10">
			<input type="text" name="unit_price" value="" class="form-control form-inps" id="unit_price"  />			</div>
		</div>
		

		</div>

				
	<div class="form-actions">
	<input type="submit" name="submit" value="Aceptar" id="submit" class="submit_button btn btn-primary"  />	</div>
	</form>
</div>
</div>
</div>
</div>


<script>

function add_item(){

var item_i = $("#item").val();

$.post( "?mod=item_kits&proc=add", { item_id: item_i }, function( data ) {
$( "#articulos" ).append( data.table );
}, "json");

$("#item").val('');

}

function delete_item(ide){
var elemento = "#" + ide ;
$(elemento).remove();

}

    $(document).ready(function ()
    {

$( "#category" ).autocomplete({
		source: "?mod=item_kits&proc=suggest_category",
		delay: 10,
		autoFocus: false,
		minLength: 0
	});


        $("#item").autocomplete({
            source: '?mod=item_kits&proc=suggest_items',
            delay: 10,
            autoFocus: false,
            minLength: 1,
            select: function (event, ui)
            {
                event.preventDefault();
                $("#item").val(ui.item.value);
                add_item();
            }
        });


$('#item_kit_form').validate({
		submitHandler:function(form)
		{
			
			$.post('?mod=item_kits&proc=check_duplicate', {term: $('#name').val()},function(data) {

						if(data.duplicate)
				{
					
					if(confirm("Ya existe un \u00edtem con ese nombre. Continuar?"))
					{
						doItemSubmit(form);
					}
					else 
					{
						return false;
					}
				}
						 {
				doItemSubmit(form);
			 }} , "json")
		     .error(function() {
		 });
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
					item_kit_number:
			{
				remote: 
				    { 
					url: "?mod=item_kits&proc=item_number_exists",  
					type: "post"
					
				    } 
			},
				
				
			name:"required",
			category:"required",

			unit_price:
			{
				required:true,
				number:true
			},

   		},
		messages:
		{			
						item_kit_number:
			{
				remote: "UPC \/ EAN \/ ISBN que ya existe"				   
			},
						
						
												
			name:"Nombre de Art\u00edculo es requerido",
			category:"Categor\u00eda es requerido",
			unit_price:
			{
				required:"Precio es requerido",
				number:"Precio unitario debe ser n\u00famero"			},
			
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
		$("#item_kit_form").unmask();
		submitting = false;
		gritter("\u00c9xito"+' #' + response.item_id,response.message,response.success ? 'gritter-item-success' : 'gritter-item-error',false,false);

		if(response.success)
		{
			alert(response.message);
			window.location.href = '?mod=item_kits&proc=main'
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
