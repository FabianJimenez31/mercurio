<?php
function enviar_correo($asunto,$mensaje,$destino,$nombre){

$mail = new PHPMailer();

$mail->IsSMTP(); 

$mail->Host = "smtp.gmail.com";
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = 'tickets@overvoiplatam.com';
$mail->Password = 'KoRnAle77';
// dirección remitente, p. ej.: no-responder@miempresa.com
$mail->From = "tickets@overvoiplatam.com";
// nombre remitente, p. ej.: "Servicio de envío automático"
$mail->FromName = "Notificacion NodoIP";
$list=array('jesus.rocha@overvoiplatam.com');

foreach($list as $bccer){
   $mail->AddBCC($bccer);
}
// asunto y cuerpo alternativo del mensaje
$mail->Subject = $asunto;

// si el cuerpo del mensaje es HTML
$mail->MsgHTML($mensaje);

// podemos hacer varios AddAdress

$correos=explode(",",$destino);

foreach($correos as $dst){

$mail->AddAddress($dst, $nombre);
}

if(!$mail->Send()) {
$final=$mail->ErrorInfo;
} else {
$final=true;
}
return $final;
}


?>
