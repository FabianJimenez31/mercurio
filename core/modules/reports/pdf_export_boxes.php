<?php
global $user_array;
if(permitido($user_array['person_id'],$_GET['mod'])){

    ob_start();
    load_template('partial','output_boxes');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'es');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('reporte.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }


}
?>


