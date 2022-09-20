<?php
	$es_hijo=1;
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
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.parent.document.getElementById('dbx<?php echo $_POST['us_maneja']?>').submit();
//				window.parent.cher.action='validador-gui.php';
//				window.parent.cher.submit();
				
			};
         </SCRIPT>

<?php
#	for($i=0;$i < count($keyes); $i++){
#		//echo $keyes[$i].' '.$values[$i]."<br>";
#	};//echo $_POST['fa1'].' '.$_POST['fa2'].' '.$_POST['fa3'].' '.$_POST['fa4'].' '.$_POST['fa5'].' '.$_POST['fa6'].' hahah';	

	if(isset($_POST['doc-ref']) and isset($_POST['idpost'])){
		if($_POST['recomendacion_']=='rechazada'){$_POST['cod_pro']='';};

		$sql_inf_exist="SELECT idInformeTecnico FROM InformeTecnico WHERE Postulacion_idPostulacion=".$_POST['idpost'];
		$inf_ex=$db->query($sql_inf_exist);
		if($inf_ex->RowCount()==0){
		$sql="INSERT INTO InformeTecnico";
		$sql.=" (InformeTecnicoRefDoc,InformeTecnicoObservacion,InformeTecnicoRecomendacion,InformeTecnicoCodPro,Postulacion_idPostulacion)";
		$sql.=" VALUES ('".$_POST['doc-ref']."','".$_POST['obs']."','".$_POST['recomendacion_']."','".$_POST['cod_pro']."',".$_POST['idpost'].")";  
		$stmt = $db->prepare($sql);

		}else{
			$sql="UPDATE InformeTecnico SET InformeTecnicoRefDoc='".$_POST['doc-ref']."', InformeTecnicoObservacion='".$_POST['obs']."',InformeTecnicoRecomendacion = '".$_POST['recomendacion_']."', InformeTecnicoCodPro='".$_POST['cod_pro']."' WHERE Postulacion_idPostulacion=".$_POST['idpost']."";
			$stmt = $db->prepare($sql);
		};


	};
	if(isset($_POST['resp_ref']) and isset($_POST['idpost'])){

		$sql_res_exist="SELECT idSolicitudRespuesta FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$_POST['idpost'];
		$res_ex=$db->query($sql_res_exist);
		if($res_ex->RowCount()==0){
			$sql_resp="INSERT INTO SolicitudRespuesta";
			$sql_resp.=" (SolicitudRespuestaRefDoc,SolicitudRespuestaResumen,Postulacion_idPostulacion)";
			$sql_resp.=" VALUES ('".$_POST['resp_ref']."','".$_POST['obsr']."',".$_POST['idpost'].")";  
			$stmresp = $db->prepare($sql_resp);
		}else{
			$sql_resp="UPDATE SolicitudRespuesta SET SolicitudRespuestaRefDoc='".$_POST['resp_ref']."', SolicitudRespuestaResumen='".$_POST['obsr']."' WHERE Postulacion_idPostulacion=".$_POST['idpost']."";
			$stmresp = $db->prepare($sql_resp);
		};

	};
	if(isset($_POST['idpost'])){
		$sql_act_post="UPDATE Postulacion SET PostulacionVerificado=1,PostulacionFechaV=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00') WHERE idPostulacion=".$_POST['idpost']."";
		$stmtpos = $db->prepare($sql_act_post);

		$get_mail_verficador = $db->query(" SELECT realname,email,email2 FROM user WHERE username in
			(SELECT user_username FROM UsuarioManejaProfesional WHERE TipoProfesional_TipoProfesionalId in
				(SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$_SESSION['user']."')) and TipoUsuario_idTipoUsuario = 5 and userEstado=1");
		$mails= $get_mail_verficador->fetch(PDO::FETCH_ASSOC);
	};
#exit;
try {
	$db->beginTransaction();
	if(isset($stmt)){$stmt->execute();};
	if(isset($stmtpos)){$stmtpos->execute();};
	if(isset($stmresp)){$stmresp->execute();};

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
	Estimado(a)<B> ".$mails['realname']." </B>:<BR><BR>
	 El/la t&eacute;cnico(a) <b>".$_SESSION['user_realn']."</b> realiz&oacute; la revisi&oacute;n y el informe t&eacute;cnico de una solicitud de registro 
	para ingreso en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B><BR><BR>
	Por favor ingrese al Sistema para validar la solicitud pendiente<BR><BR>
	<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES</A><BR>
	<BR>";
$html_body.=$footer_html;
 $html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

	 $altbody="
	Estimado(a) ".$mails['realname']." :\n\n
	 El/la técnico(a) ".$_SESSION['user_realn']." realizó la revisión y el informe técnico de una solicitud de registro 
	para ingreso en la Base de Datos: ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."\n\n
	Por favor ingrese al Sistema para validar la solicitud pendiente\n\n";
$altbody.=$footer_text;
 $altbody=utf8_decode($altbody);

	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$subj=utf8_decode("Notificación de Revisión de solicitud");
	$mail->Subject = $subj;
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);

	// podemos hacer varios AddAdress
	$mail->AddAddress($mails['email'], $mails['realname']);
	$coma='';
	if(isset($mails) and $mails['email2']!=''){
	$mail->AddAddress($mails['email2'], $mails['realname']);
	$coma=', ';
	};
	// fin envio notificacion
	$ok_text="
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES INPC</h3></center>
	<font size='+1'>
	 La revisi&oacute;n de la solicitud de registro para ingresar en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B>  fue exitosa.
	<br><br>
	 Se envi&oacute; una notificaci&oacute;n a la(s) cuenta(s) de correo del Director(a) de Conservaci&oacute;n y Salvaguardia de Bienes Patrimoniales Culturales especificada(s) : <strong>".$mails['email'].$coma.$mails['email2']."</strong>.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'><FORM name='fr' method='POST' action='validador-gui-xvalidar.php'>
		<input type='hidden' name='us_maneja' value='".$_POST['us_maneja']."'><input type='hidden' name='pagina' value='".$_POST['pagina']."'>
	  &nbsp;&nbsp;<INPUT class='button' type='button' name='ok' value='Aceptar' size='10' onClick='reload_();'>&nbsp;&nbsp;
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
