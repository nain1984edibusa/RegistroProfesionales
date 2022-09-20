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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>

         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.parent.document.getElementById('dbxv<?php echo $_POST['us_maneja']?>').submit();
//				window.parent.cher.action='verificador-gui.php';
//				window.parent.cher.submit();
				
			};
         </SCRIPT>
<html>
<body>
<div id='htopic'  class="literatura" style="DISPLAY:; position:fixed; border: 0px; font-size:20px; float:center; width:400px; height:150px; " onClick="">
<p align='left' STYLE="  font-family: arial;  text-align:justify; margin-top:5; margin-right:5%; margin-bottom:5; margin-left:5%;">
	Por favor espere mientras se procesa la transacci&oacute;n y se env&iacute;n las notificaciones	 </p>
	<img align='center' src="image/loading.gif"> 	
</div>

<?php
#	for($i=0;$i < count($keyes); $i++){
#		//echo $keyes[$i].' '.$values[$i]."<br>";
#	};//echo $_POST['fa1'].' '.$_POST['fa2'].' '.$_POST['fa3'].' '.$_POST['fa4'].' '.$_POST['fa5'].' '.$_POST['fa6'].' hahah';	

	if(isset($_POST['resp_ref']) and isset($_POST['idpost'])){
#		$sql="INSERT INTO InformeTecnico";
#		$sql.=" (InformeTecnicoRefDoc,InformeTecnicoObservacion,InformeTecnicoRecomendacion,InformeTecnicoCodPro,Postulacion_idPostulacion)";
		$get_resp=$db->query("SELECT InformeTecnicoRecomendacion FROM InformeTecnico WHERE Postulacion_idPostulacion=".$_POST['idpost']." ");
		$resp=$get_resp->fetch(PDO::FETCH_ASSOC);
		$sql="INSERT INTO SolicitudRespuesta";
		$sql.=" (SolicitudRespuestaRefDoc,SolicitudRespuestaResumen,Postulacion_idPostulacion)";
		$sql.=" VALUES ('".$_POST['resp_ref']."','".$_POST['obsr']."',".$_POST['idpost'].")";  
		$stmt = $db->prepare($sql);
	};
	if(isset($_POST['idpost'])){
		$get_resp=$db->query("SELECT InformeTecnicoRecomendacion FROM InformeTecnico WHERE Postulacion_idPostulacion=".$_POST['idpost']." ");
		$resp=$get_resp->fetch(PDO::FETCH_ASSOC);
		$sql_act_post="UPDATE Postulacion SET PostulacionAprobado='".$resp['InformeTecnicoRecomendacion']."', PostulacionFechaD=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00') WHERE idPostulacion=".$_POST['idpost']."";
		$stmtpos = $db->prepare($sql_act_post);

		$get_mail_dejecutivo = $db->query(" SELECT realname,email,email2 FROM user WHERE TipoUsuario_idTipoUsuario = 2 and userEstado=1");
		if ($get_mail_dejecutivo->rowCount()){
			$mails= $get_mail_dejecutivo->fetch(PDO::FETCH_ASSOC);
		}else{
			 "<html><body><script>alert('Imposible remitir,no hay usuario Director(a) Ejecutiv@ registrado');
						document.body.innerHTML += \"<form id='redir' action='verificador-gui-xverificar.php' method='post'></form>\";
						document.getElementById('redir').submit();</script></body></html>";
			exit;
		};
	};
#exit;
try {
	$db->beginTransaction();
	if(isset($stmt)){$stmt->execute();};
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
	Estimado(a)<B> ".$mails['realname']." </B>:<BR><BR>
	 La Direcci&oacute;n de Conservaci&oacute;n y Salvaguardia de Bienes Patrimoniales Culturales realiz&oacute; la revisi&oacute;n del informe t&eacute;cnico de una solicitud de registro 
	para ingreso en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B><BR><BR>
	Por favor ingrese al Sistema para despachar la respuesta a la solicitud.<BR><BR>
	<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES</A><BR>
	<BR>";
	$html_body.=$footer_html;
	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

#$texto_retirado="<b>".$_SESSION['user_realn']."</b>";

	 $altbody="
	Estimado(a) ".$mails['realname']." :\n\n
	 La Dirección de Conservación y Salvaguardia de Bienes Patrimoniales Culturales realizó la verificación del informe técnico de una solicitud de registro 
	para ingreso en la Base de Datos:&nbsp; ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."\n\n
	Por favor ingrese al Sistema para revisar la respuesta a la solicitud.\n\n
	http://".$_SERVER['SERVER_NAME']."/\n\n";
	$altbody.=$footer_text;
	$altbody=utf8_decode($altbody);
	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$subj=utf8_decode("Notificación de Validación de solicitud de registro de profesionales");
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
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES</h3></center>
	<font size='+1'>
	 La emisi&oacute;n y validaci&oacute;n del informe para el registro en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B> fue exitosa
	<br><br>
	 Se envi&oacute; una notificaci&oacute;n a la(s) cuenta(s) de correo de Director(a) Ejecutivo(a): <b>  ".$mails['realname']." </b> especificada(s) : <strong>".$mails['email'].$coma.$mails['email2']."</strong>.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'class='tobut'><FORM name='fr' method='POST' action='verificador-gui-xverificar.php'>
	  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='reload_()'>&nbsp;&nbsp;
	</FORM></td></tr></table>
	";

		if(!$mail->Send()) {
			echo "Error enviando: " . $mail->ErrorInfo;
		} else {
			echo $ok_text;
		};
};
$db=null;

?>
 <SCRIPT LANGUAGE="JavaScript1.2" >expandit2('htopic',0) </script>
</body>
</html>


