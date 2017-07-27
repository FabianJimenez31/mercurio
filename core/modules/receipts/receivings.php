<?php
$requisition=$_GET['id'];
global $user_array;
load_template('partial','header');
load_template('partial','menu');
$req_info=select_mysql("*","requisitions","requisitionId=".$requisition);
$user=select_mysql("*",'people','person_id='.$req_info['result'][0]['userCreator']);
$u=$user['result'][0];
$items=select_mysql('t1.cost_price , t1.quantity , t2.product_id , t2.name' , 'requisitions_items as t1 inner join '.DBPREFIX.'items as t2 ON t1.item_id = t2.item_id AND t1.requisitionId='.$requisition);

?>


<?php
if( file_exists(APPDIR."images/custom_logo.png")){
$logo_url="images/custom_logo.png";
}else{
$logo_url="images/logo.png";
}

?>
<div id="receipt_wrapper">    
            <div id="company_logo"><img width='100px' src="<?php echo $logo_url; ?>" alt=""/></div>
        <div id="receipt_header">
        <div id="company_name">Solicitud de Pedido</div>   
        <div id="company_address"></div>
        <div id="company_phone"></div>
        <div id="sale_time"><?php echo $req_info['result'][0]['requisitionDate']; ?></div>
        
    </div>
    <div id="receipt_general_info">
<!--                    <div id="customer">Proveedor: </div>-->
                    <div id="sale_id">Solicitud Num: <?php echo $requisition; ?></div>
        <div id="employee">Responsable Solicitud : <?php echo $u['first_name']." ".$u['last_name']?></div>
    </div>

    <table id="receipt_items">
        <tr>
            <th style="width:50%;text-align:left;">Artículo</th>
            <th style="width:16%;text-align:left;">SKU</th>
            <th style="width:17%;text-align:left;">Precio</th>
            <th style="width:16%;text-align:left;">Cantidad</th>            
            <th style="width:17%;text-align:right;">Total</th>
        </tr>


<?php
$total=0;
foreach($items['result'] as $i){
$c=$i['quantity'];
$d=$i['cost_price'];
$suma=$c*$d;
$total+=$suma;
echo "

<tr>
                <td style=\"text-align:left;\">".$i['name']."</td>
                <td style='text-align:left;'>".$i['product_id']."</td>
                <td style=\"text-align:left;\"> $".number_format($i['cost_price'],2,',','.')."</td>
                <td style='text-align:left;'>".$i['quantity']."</td>                
                <td style='text-align:right;'>$".number_format($suma,2,',','.')."</td>
            </tr>

<tr>

                <td colspan=\"3\" align=\"left\"></td>
                <td colspan=\"1\" ></td>
                <td colspan=\"1\">---</td>
            </tr>


";


}

?>
                    
            
          	
        <tr>
            <td colspan="3" style='text-align:right;'>Total</td>
            <td colspan="2" style='text-align:right'>$<?php echo number_format($total,2,',','.');?></td>
        </tr>

<!--        <tr>
            <td colspan="3" style='text-align:right;'>Método de Pago</td>
            <td colspan="2" style='text-align:right'></td>
        </tr>-->

            </table>

    <div id="sale_return_policy">
        La factura emitida por el proveedor referente a esta orden de pedido sera pagada en un termino de 60 dias calendario una vez recibido el pedido en la bodega destinada.    </div>
    <div id='barcode'>
        <!--<img src='http://localhost/NUEVOPOINT/3.1.-mercurio-sgpv-hayuelos/index.php/barcode?barcode=SP 22&text=SP 22' />-->    </div>
    <button class="btn btn-primary text-white hidden-print" id="print_button" onClick="window.print()" > Imprimir </button>
    <br />
    
    <script type="text/javascript">
        $(window).load(function ()
        {
            window.print();
        });
    </script>


<?php
load_template('partial','footer');
?>
