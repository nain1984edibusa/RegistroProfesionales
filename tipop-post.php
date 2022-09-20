<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/format_db_content.php');
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('footer-mail.php');

	if($_SERVER['REQUEST_METHOD']!='POST'){
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.opener.parent.document.cher.target='_self';
				window.opener.parent.document.cher.action='admin-gui.php';
				window.opener.parent.document.cher.submit();
			};
         </SCRIPT>
<?php

if(isset($_POST['ex1']) and isset($_POST['ex2']) and $_POST['ex1'] and !$_POST['ex2']){
	$sql_tp="INSERT INTO TipoProfesional (TipoProfesionalNombre,TipoProfesionalPerfil,TipoProfesionalPrefijoCodigo) VALUES ('".$_POST['tipopn']."','".$_POST['tipopp']."','".$_POST['tipopr']."')";
};
if(isset($_POST['ex1']) and isset($_POST['ex2']) and !$_POST['ex1'] and $_POST['ex2']){
	$sql_tp="UPDATE TipoProfesional SET TipoProfesionalNombre='".$_POST['tipopn']."', TipoProfesionalPerfil='".$_POST['tipopp']."',TipoProfesionalPrefijoCodigo='".$_POST['tipopr']."' WHERE TipoProfesionalId='".$_POST['tpr_']."'";
};

try {
	$db->beginTransaction();
#	$stmt = $db->prepare($sql);
	$stmtp = $db->prepare($sql_tp);
#	if(isset($stmt)){$stmt->execute();};
	if(isset($stmtp)){$stmtp->execute();};
#	if(isset($stmt1)){$stmt1->execute();};
	$db->commit();

} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
//exit;
if (!isset($ex)){  // si se insertaron los registros......
	if(isset($_POST['ex1']) and isset($_POST['ex2']) and $_POST['ex1'] and !$_POST['ex2']){
#		$html_body="
#		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
#		<HTML>
#		<HEAD>
#		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
#		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
#		</HEAD>
#		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
#		Estimado(a)<B> ".ucfirst($_POST['rname'])." </B>:<BR><BR>
#		 Se ha creado una cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])."<BR><BR>
#		Nombre de usuario:&nbsp; <B>".$_POST['username']."</B><BR>
#		Clave Temporal:&nbsp;&nbsp;&nbsp; <B>".$tmp_pwd."</B><BR><BR>
#		Por favor confirme la activaci&oacute;n de su cuenta de usuario, cambiando su clave temporal <BR><BR>
#		<A HREF='http://regprof.inpc.gob.ec/confirmap.php?token=".$tmp_token."'>Confirmaci&oacute;n de creaci&oacute;n de cuenta de usuario</A><BR>
#		<BR><BR>
#		";
#	$html_body.=$footer_html;
#	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";


#		$altbody="
#		Estimado(a) ".ucfirst($_POST['rname'])." :\n
#		Se ha creado una cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])."\n\n
#		Cuenta de usuario:  ".$_POST['username']."\n
#		Clave Temporal:    ".$tmp_pwd."\n\n
#		Por favor confirme la activación de su cuenta de usuario, cambiando su clave temporal\n\n
#		POr favor copie y pegue este enlace en la barra de direcciones de su navegador web (recomendados Chrome, Firefox, Opera)
#		http://regprof.inpc.gob.ec/confirmap.php?token=".$tmp_token."
#		Confirmación de creación de cuenta de usuario aquí: http://regprof.inpc.gob.ec/confirmap.php&?oken=".$tmp_token."\n\n\n";
#		$altbody.=$footer_text;
#		$altbody=utf8_decode(utf8_encode($altbody));
#		//envio de notifiacion
#		// asunto y cuerpo alternativo del mensaje
#		$subj=utf8_decode(utf8_encode("Creación cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])));
#		$mail->Subject = $subj;
#		$mail->AltBody = $altbody; 
#		// si el cuerpo del mensaje es HTML
#		$mail->MsgHTML($html_body);

#		// podemos hacer varios AddAdress
#		$mail->AddAddress($_POST['mail'], $_POST['rname']);
#		if(isset($_POST['mail2']) and $_POST['mail2']!=''){
#		$mail->AddAddress($_POST['mail2'], $_POST['rname']);
#		};
#		// fin envio notificacion
		$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>ADMINISTRACI&Oacute;N DE USUARIOS DEL SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Se cre&oacute; una Categor&iacute;a Profesional:<strong> <em>".$_POST['tipopn']."<br><br></em></strong>
		<br>
	
		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM  method='POST'>
		  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='reload_();window.close()'>&nbsp;&nbsp;
		</FORM></td></tr></table>
		";
	};
	if(isset($_POST['ex1']) and isset($_POST['ex2']) and !$_POST['ex1'] and $_POST['ex2']){
#		$html_body="
#		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
#		<HTML>
#		<HEAD>
#		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
#		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
#		</HEAD>
#		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
#		Estimado(a)<B> ".ucfirst($_POST['realn'])." </B>:<BR><BR>
#		 Se han modificado datos de su cuenta de usuario  ".$_POST['usrn']."<BR><BR>
#		Nombre de usuario:&nbsp; <B>".$_POST['realn']."</B><BR>
#		Correo Electronico:&nbsp;&nbsp;&nbsp; <B>".$_POST['email']."</B><BR>
#		Correo Electronico 2:&nbsp;&nbsp;&nbsp; <B>".$_POST['email2']."</B><BR>
#		Estado:&nbsp;&nbsp;&nbsp; <B>".format_cont_db('userEstado',$_POST['estado'])."</B><BR>";
#		$html_body.=$footer_html;
#		$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
		
#		$altbody="
#		Estimado(a) ".ucfirst($_POST['realn'])." :\n
#		 Se han modificado datos de su cuenta de usuario :".$_POST['usrn']."\n\n
#		Nombre de usuario:&nbsp; ".$_POST['realn']."\n
#		Correo Electronico:  ".$_POST['email']."\n
#		Correo Electronico 2:  ".$_POST['email2']."\n
#		Estado:  ".format_cont_db('userEstado',$_POST['estado'])."\n\n";
#		$altbody.=$footer_text;
#		$altbody=utf8_decode(utf8_encode($altbody));
#		
#		//envio de notifiacion
#		// asunto y cuerpo alternativo del mensaje
#		$mail->Subject = "Cambios en cuenta de usuario ".$_POST['usrn'];
#		$mail->AltBody = $altbody; 
#		// si el cuerpo del mensaje es HTML
#		$mail->MsgHTML($html_body);

#		// podemos hacer varios AddAdress
#		$mail->AddAddress($_POST['email'], $_POST['realn']);
#		if(isset($_POST['email2']) and $_POST['email2']!=''){
#		$mail->AddAddress($_POST['email2'], $_POST['realn']);
#		};
#		// fin envio notificacion
		$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>ADMINISTRACI&Oacute;N SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Se han modificado datos la Categor&iacute;a: <strong> <em>".$_POST['tipopn']."<br><br></em></strong>
		<br>
		<br>
		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM  method='POST'>
		  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='reload_();window.close()'>&nbsp;&nbsp;
		</FORM></td></tr></table>
		";
	};
#	if(!$mail->Send()) {
#		echo "Error enviando: " . $mail->ErrorInfo;
#	} else {
		echo $ok_text;
#	};

}else{
echo 'error en la insercion/actualizacion';
};
//echo $sql;
$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
