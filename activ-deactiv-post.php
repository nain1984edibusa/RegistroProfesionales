<?php
	$es_hijo=1;
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('class/format_db_content.php');
	require_once ('session.php');
	require('footer-mail.php');
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		//header("Location: http://regprof.inpc.gob.ec/");
		exit;
	};
?>
<?php

	if(isset($_POST['prof']) and $_POST['prof']!='' and isset($_POST['act_dea'])){
		$sql_act_post="UPDATE RegistroP SET RegistroPActivo=".$_POST['act_dea'].",RegistroPFechaRegistro=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00') WHERE Profesional_idProfesional='".$_POST['prof']."'";
		$get_mail_prof = $db->query(" SELECT RegistroPApellidos,RegistroPNombres,RegistroPMail,RegistroPMail2 FROM RegistroP WHERE Profesional_idProfesional='".$_POST['prof']."'");
		$mails= $get_mail_prof->fetch(PDO::FETCH_ASSOC);
		if ($_POST['act_dea']){
			$lab='Activaci&oacute;n';
		}else{
			$lab='Desactivaci&oacute;n';
		};
	};
#exit;
try {
	$db->beginTransaction();
	$stmtpos = $db->prepare($sql_act_post);
	if(isset($stmtpos)){$stmtpos->execute();};
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){  // si se insertaron los registros......
	$html_body="
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
	<HTML>
	<HEAD>
	  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
	  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
	</HEAD>
	<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
	Estimado(a)<B> ".$mails['RegistroPNombres'].' '.$mails['RegistroPApellidos']." </B>:<BR><BR>
	 El validador <b>".$_SESSION['user_realn']."</b> efetu&oacute; la <b>".$lab."</b> de su registro 
	en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B><BR><BR>
	Si tiene dudas o requiere alguna aclaraci&oacute;n comun&iacute;quese con el INPC.<br>
<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR>";
	$html_body.=$footer_html;
	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
	

	 $altbody="
	Estimado(a) ".$mails['RegistroPNombres'].' '.$mails['RegistroPApellidos']." :\n\n
	 El validador ".$_SESSION['user_realn']." efectuó la <b>".$lab."</b> de su registro
	en la Base de Datos:&nbsp; ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."\n\n
	Si tiene dudas o requiere alguna aclaraci&oacute;n comun&iacute;quese con el INPC.\n";
	$altbody.=$footer_text;
	$altbody=utf8_decode(utf8_encode($altbody));
	
	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$subj=utf8_decode(utf8_encode($lab." de Registro en Base de Datos ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])));
	$mail->Subject = $subj;
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);

	// podemos hacer varios AddAdress
	$mail->AddAddress($mails['RegistroPMail'], $mails['RegistroPNombres'].' '.$mails['RegistroPApellidos']);
	if(isset($mails) and $mails['RegistroPMail2']!=''){
	$mail->AddAddress($mails['RegistroPMail2'], $mails['RegistroPNombres'].' '.$mails['RegistroPApellidos']);
	};
	// fin envio notificacion
	$ok_text="
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
	<font size='+1'>
	 Se realiz&oacute; la <b>".$lab."</b> del registro de ".$mails['RegistroPNombres'].' '.$mails['RegistroPApellidos']."  en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B> exitosamente
	<br><br>
	 Se envi&oacute; una notificaci&oacute;n a la(s) cuenta(s) de correo del Profesional especificada(s) : <strong>".$mails['RegistroPMail'].", ".$mails['RegistroPMail2']."</strong>.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'class='tobut'><FORM name='fr' method='POST' action='validador-gui-registrado.php'>
	  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='fr.submit()'>&nbsp;&nbsp;
	</FORM></td></tr></table>
	";

		if(!$mail->Send()) {
			echo "Error enviando: " . $mail->ErrorInfo;
		} else {
			echo $ok_text;
		};
};
$db=null;
exit;
?>

	


