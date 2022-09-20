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
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	for($i=0;$i < count($keyes); $i++){
		//echo $keyes[$i].' '.$values[$i]."<br>";
	};//echo $_POST['fa1'].' '.$_POST['fa2'].' '.$_POST['fa3'].' '.$_POST['fa4'].' '.$_POST['fa5'].' '.$_POST['fa6'].' hahah';	

	if(isset($_POST['Validador_Postulacion']) and isset($_POST['idpost'])){
		$sql="INSERT INTO AccionEnPostulacion";
		$sql.=" (AccionEnPostulacionAccion,user_username,AccionEnPostulacionFechaAs,Postulacion_idPostulacion)";
		$sql.=" VALUES (4,'".$_POST['Validador_Postulacion']."',CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),".$_POST['idpost'].")";
		$sql_act_post="UPDATE Postulacion SET PostulacionAsignado=1 WHERE idPostulacion=".$_POST['idpost']."";
		$get_mail_validador = $db->query("SELECT realname,email,email2 FROM user WHERE username = '".$_POST['Validador_Postulacion']."'");
		$mails= $get_mail_validador->fetch(PDO::FETCH_ASSOC);
		$st_pro= $db->query("SELECT Profesional_idProfesional,TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones=".$_POST['idprofesi']);
		$profesional= $st_pro->fetch(PDO::FETCH_ASSOC);	

	};
?>
         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.opener.parent.document.getElementById('dbx<?php echo $profesional['TipoProfesional_TipoProfesionalId']?>').submit();
//				window.opener.parent.cher.action='verificador-gui.php';
//				window.opener.parent.cher.submit();
			};
         </SCRIPT>
<?php

//exit;
try {
	$db->beginTransaction();
	$stmt = $db->prepare($sql);
	$stmtpos = $db->prepare($sql_act_post);
	if(isset($stmt)){$stmt->execute();};
	if(isset($stmtpos)){$stmtpos->execute();};
	$db->commit();

$html_body="
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
<HTML>
<HEAD>
  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
</HEAD>
<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
Estimado(a)<B> ".$mails['realname']." </B>:<BR><BR>
 Recibi&oacute; la asignaci&oacute;n para revisar la solicitud de registro de <b>".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])." </b>
para ingreso en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $profesional['TipoProfesional_TipoProfesionalId'])."</B><BR><BR>
Por favor ingrese al Sistema para atender las solicitudes pendientes<BR><BR>
<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR>
<BR>";
$html_body.=$footer_html;
 $html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

$altbody="
Estimado(a) ".$mails['realname']." :\n\n
 Recibió la asignación para revisar la solicitud de registro de ".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])."
para ingreso en la Base de Datos:&nbsp; ".format_cont_db('TipoProfesionalId', $profesional['TipoProfesional_TipoProfesionalId'])."\n\n
Por favor ingrese al Sistema para atender las solicitudes pendientes\n\n
http://".$_SERVER['SERVER_NAME']."/\n\n";
$altbody.=$footer_text;
 $altbody=utf8_decode($altbody);

//envio de notifiacion
// asunto y cuerpo alternativo del mensaje
 $subj=utf8_decode("Notificación de revisión de solicitud");
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
$ok_text="
<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
<font size='+1'>
 La asignaci&oacute;n a <b>".$mails['realname']."</b> para revisar la solicitud de registro profesional de ".format_cont_db('idProfesional', $profesional['Profesional_idProfesional'])."
 para ingresar en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $profesional['TipoProfesional_TipoProfesionalId'])."</B>, se realiz&oacute; con &eacute;xito.
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
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};

$db=null;
exit;
?>

	


