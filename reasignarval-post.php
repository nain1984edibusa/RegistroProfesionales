<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('class/format_db_content.php');
	require('footer-mail.php');

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		header("index.php");
		exit;
	};
?>
         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.opener.parent.document.getElementById('dbxv<?php echo $_POST['us_maneja']?>').submit();
			};
         </SCRIPT>
<?php

	if(isset($_POST['Validador_Postulacion']) and isset($_POST['idpost'])){
			//AVERIGUAR EL PREIMER TECNICO QUE ATENDIO LA SOLICITUD
 		$sql_act_valid="SELECT user_username FROM AccionEnPostulacion  WHERE AccionEnPostulacionAccion=4 and AccionEnPostulacionActiva=1 and  Postulacion_idPostulacion=".$_POST['idpost'];
		$act_valid_=$db->query($sql_act_valid);
		$act_valid=$act_valid_->fetch(PDO::FETCH_ASSOC);
		if($act_valid['user_username']==$_POST['Validador_Postulacion']){
				// SI SE ESCOGIO AL MISMO TECNICO, SOLO ACTUALIZO EL ESTADO DE LA SOLICITUD Y NOTIFICO NUEVAMENTE,
			$sql_act_post="UPDATE Postulacion SET PostulacionAsignado=1, PostulacionFechaV= NULL, PostulacionVerificado=0 WHERE idPostulacion=".$_POST['idpost']."";
			
		}else{
				// SI SE ESCOGIO OTRO TECNICO, ACTUALIZO EL ESTADO DE LA SOLICITUD Y NOTIFICO AL NUEVO TECNICO, ADEMAS DE INSERTAR EL REGISTRO RESPECTIVO EN ACCIONENPOSTUALCION
			$sql_act_post="UPDATE Postulacion SET PostulacionAsignado=1, PostulacionFechaV= NULL, PostulacionVerificado=0 WHERE idPostulacion=".$_POST['idpost']."";
			$sql_deact_prev_val="UPDATE AccionEnPostulacion SET  AccionEnPostulacionActiva=0 WHERE Postulacion_idPostulacion=".$_POST['idpost']." and user_username='".$act_valid['user_username']."'";

			$sql="INSERT INTO AccionEnPostulacion";		//ASIGNACION AL NUEVO TECNICO PARA LA REVISION
			$sql.=" (AccionEnPostulacionAccion,user_username,AccionEnPostulacionFechaAs,Postulacion_idPostulacion)";
			$sql.=" VALUES (4,'".$_POST['Validador_Postulacion']."',CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),".$_POST['idpost'].")";
		
		};
		

		$get_mail_validador = $db->query("SELECT realname,email,email2 FROM user WHERE username = '".$_POST['Validador_Postulacion']."'");
		$mails= $get_mail_validador->fetch(PDO::FETCH_ASSOC);
	};

try {
	$db->beginTransaction();
	if(isset($sql)){$stmt = $db->prepare($sql);};
	if(isset($sql_deact_prev_val)){$stmt2 = $db->prepare($sql_deact_prev_val);};
	$stmtpos = $db->prepare($sql_act_post);
	if(isset($stmt)){$stmt->execute();};
	if(isset($stmt2)){$stmt2->execute();};
	if(isset($stmtpos)){$stmtpos->execute();};
	$db->commit();


} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};

if (!isset($ex)){
		$st_pro= $db->query("SELECT Profesional_idProfesional,TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones=".$_POST['idprofesi']);
		$profesional= $st_pro->fetch(PDO::FETCH_ASSOC);	

	$html_body="
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
	<HTML>
	<HEAD>
	  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
	  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
	</HEAD>
	<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
	Estimado(a)<B> ".$mails['realname']." </B>:<BR><BR>
	Se le Re-asign&oacute; la revisi&oacute;n de la solicitud de registro de <b>".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])." </b> con la siguiente onbservación:<BR><BR><b>".$_POST['obsr']."</b><BR><BR>
	Por favor ingrese al Sistema para atender las solicitudes pendientes<BR><BR>
	<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR>
	<BR>";
	$html_body.=$footer_html;
 	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

	$altbody="
	Estimado(a) ".$mails['realname']." :\n\n
	Se le Re-asignó la revisión de la solicitud de registro de ".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])." con la siguiente onbservación:\n\n".$_POST['obsr']."\n\n
	Por favor ingrese al Sistema para atender las solicitudes pendientes\n\n
	http://".$_SERVER['SERVER_NAME']."/\n\n";
	$altbody.=$footer_text;
	 $altbody=utf8_decode($altbody);

	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	 $subj="Notificación de Reasignación para revisión de solicitud";
	$mail->Subject = $subj;
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);

	// podemos hacer varios AddAdress
	$coma='';
	$mail->AddAddress($mails['email'], $mails['realname']);
	if(isset($mails) and $mails['email2']!=''){
	$mail->AddAddress($mails['email2'], $mails['realname']);
	$coma=', ';
	};
	// fin envio notificacion
echo 	$ok_text="
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
	<font size='+1'>
	 La Re-asignaci&oacute;n a <b>".$mails['realname']."</b> para revisar la solicitud de Registro de ".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])."
	 se realiz&oacute; con &eacute;xito.
	<br><br>
	 Se envi&oacute; una notificaci&oacute;n a la(s) cuenta(s) de correo del t&eacute;cnico(a) especialista: <strong>".$mails['email'].$coma.$mails['email2']."</strong>.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'><FORM method='POST'>
	  &nbsp;&nbsp;<INPUT class='buton' type='button' name='ok' value='Aceptar' size='10' onClick='reload_();window.close()'>&nbsp;&nbsp;
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

