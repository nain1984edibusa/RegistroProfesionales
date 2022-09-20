<?php  
require("class.phpmailer.php");
require("class.smtp.php");

$mail = new PHPMailer();

#$body = "<strong>Cuerpo del mensaje</strong>";

$mail->IsSMTP(); 

// la dirección del servidor, p. ej.: smtp.servidor.com
//$mail->Host = "mail.patrimoniocultural.gob.ec";
$mail->SMTPDebug = 3; //para ver los errores del lado del cliente y servidor
$mail->Host = "172.16.1.98";

$mail->Port = 25;

// dirección remitente, p. ej.: no-responder@miempresa.com
$mail->From = "info.rpc@patrimoniocultural.gob.ec";

// nombre remitente, p. ej.: "Servicio de envío automático"
$mail->FromName = "Servicio de Registro de Profesionales ";

// si el SMTP necesita autenticación
$mail->SMTPAuth = true;

// credenciales usuario
$mail->Username = "info.rpc";
$mail->Password = "R361str0M411.2022**"; 


// asunto y cuerpo alternativo del mensaje
#$mail->Subject = "Asunto: Prueba";
$mail->SMTPSecure = 'ssl';
#$mail->AltBody = "Cuerpo alternativo 
#    para cuando el visor no puede leer HTML en el cuerpo"; 

#// si el cuerpo del mensaje es HTML
#$mail->MsgHTML($body);

#// podemos hacer varios AddAdress
#$mail->AddAddress("ivocamacho@gmail.com", "Ivanchu");
#$mail->AddAddress("ivo_camacho@hotmail.com", "Ivanchu2");


#if(!$mail->Send()) {
#echo "Error enviando: " . $mail->ErrorInfo;
#} else {
#echo "¡¡Enviado!!";
#}
?>
