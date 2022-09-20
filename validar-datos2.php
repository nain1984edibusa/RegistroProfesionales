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
	require('maneja-archivos.php');

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
				window.opener.document.cher.target='_self';
				window.opener.document.cher.action='validador-gui-xvalidar.php';
				window.opener.document.cher.submit();
				window.close();
			};
         </SCRIPT>

<?php
	if(!isset($_POST['personal'])){$ipersonal=0;}else{$ipersonal=1;};
	if(!isset($_POST['faca'])){$ifaca=0;}else{$ifaca=1;};
	if(!isset($_POST['RestSinT'])){$RestSinT=0;}else{$RestSinT=1;};
	if( isset($_POST['idpost'])){
		for($i=0;$i < count($keyes); $i++){
			if(strstr($keyes[$i],'faca_')){
#			 echo $keyes[$i].' '.$values[$i]."<br>";
			 $facaid=substr($keyes[$i],5,strlen($keyes[$i]-5));
			 $sql_act_faca[$i]="UPDATE FAcademica SET FAcademicaTituloValido =".$values[$i].",FAcademicaTituloUsado = 1 WHERE idFAcademica=".$facaid;
			} 
		};
		$sql_act_post="UPDATE Postulacion SET PostulacioncCumpleInfoP=".$ipersonal.",PostulacionCumpleInfoA = ".$ifaca." WHERE idPostulacion=".$_POST['idpost']."";
		$sql_act_prof="UPDATE Profesional SET ProfesionalRestSinT=".$RestSinT." WHERE idProfesional='".$_POST['idprof']."'";
	};

try {
	$db->beginTransaction();
	$sentm= $db->prepare($sql_act_post);
	$sentp= $db->prepare($sql_act_prof);
	if(isset($sentm)){$sentm->execute();};
	if(isset($sentp)){$sentp->execute();};
	foreach ($sql_act_faca as $sql){
		$sent= $db->prepare($sql);
		if(isset($sent)){$sent->execute();};
	}
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){  // si se insertaron los registros......
#	$html_body="
#	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
#	<HTML>
#	<HEAD>
#	  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
#	  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
#	</HEAD>
#	<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
#	Estimado(a)<B> ".$mails['realname']." </B>:<BR><BR>
#	 El/la t&eacute;cnico(a) <b>".$_SESSION['user_realn']."</b> ha realizado la revisi&oacute;n y el informe t&eacute;cnico de una solicitud de registro 
#	para ingreso en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B><BR><BR>
#	Por favor ingrese al Sistema para validar la solicitud pendiente<BR><BR>
#	<A HREF='http://regprof.inpc.gob.ec/'>SERVICIO DE REGISTRO DE PROFESIONALES</A><BR>
#	<BR>";
#$html_body.=$footer_html;
#$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

#	 $altbody="
#	Estimado(a) ".$mails['realname']." :\n\n
#	 El/la técnico(a) ".$_SESSION['user_realn']." ha realizado la revisi&oacute;n y el informe técnico de una solicitud de registro 
#	para ingreso en la Base de Datos:&nbsp; ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."\n\n
#	Por favor ingrese al Sistema para validar la solicitud pendiente\n\n";
#$altbody.=$footer_text;
#$altbody=utf8_decode(utf8_encode($altbody));

	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
#	$subj=utf8_decode(utf8_encode("Notificación de Validación de solicitud"));
#	$mail->Subject = $subj;
#	$mail->AltBody = $altbody; 
#	// si el cuerpo del mensaje es HTML
#	$mail->MsgHTML($html_body);

#	// podemos hacer varios AddAdress
#	$mail->AddAddress($mails['email'], $mails['realname']);
#	if(isset($mails) and $mails['email2']!=''){
#	$mail->AddAddress($mails['email2'], $mails['realname']);
#	};
#	// fin envio notificacion
#	$ok_text="
#	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES INPC</h3></center>
#	<font size='+1'>
#	 La revisi&oacute;n de la solicitud de registro para ingresar en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B>  ha sido exitosa.
#	<br><br>
#	 Se ha enviado una notificaci&oacute;n a la(s) cuenta(s) de correo del Director de Conservaci&oacute;n y Salvaguardia de Bienes Patrimoniales Culturales ".$mails['realname']." especificada(s) : <strong>".$mails['email'].", ".$mails['email2']."</strong>.
#	</font></td></tr></table><br><br><br>
#	<table align='center' border='0'><tr><td align='center'><FORM name='fr' method='POST' action='validador-gui-xvalidar.php'>
#		<input type='hidden' name='us_maneja' value='".$_POST['us_maneja']."'>
#	  &nbsp;&nbsp;<INPUT class='button' type='button' name='ok' value='Aceptar' size='10' onClick='fr.submit()'>&nbsp;&nbsp;
#	</FORM></td></tr></table>
#	";
		if ($ipersonal and $ifaca){
			$file_prefix='cert-post-';
			$doc_dir=$_SERVER['DOCUMENT_ROOT'].'/storage/';
			$file=$file_prefix.$_POST['idpost'].'.pdf'; 
			if (exist_doc($file)){
			  $mv="rm -f ".$doc_dir.$file;
			  system ($mv);			
			}		
		}

echo "<script LANGUAGE='JavaScript'> reload_()</script>";
};
$db=null;
exit;
?>
