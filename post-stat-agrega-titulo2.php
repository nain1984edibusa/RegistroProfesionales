<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	for($i=0;$i < count($keyes); $i++){
#		echo $keyes[$i].' '.$values[$i]."<br>";
	};
?>
 <SCRIPT LANGUAGE="JavaScript1.2" >
	function reload_(){
		window.opener.document.cher.target='_self';
		window.opener.document.cher.action='post_stat.php';
    window.opener.document.cher.gen_new_post.value=1;
//    alert(window.opener.document.cher.gen_new_post.value);
		window.opener.document.cher.submit();
	};
 </SCRIPT>
<?php
	if(isset($_POST['fa1']) and $_POST['fa1']=='1' and isset($_POST['NivelT']) and isset($_POST['ntitulo']) and isset($_POST['ninstitucion']) and isset($_POST['ftitulo']) and isset($_POST['codigo'])){
		$sql1="INSERT INTO FAcademica ";
		$sql1.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional)";
		$sql1.=" VALUES (".$_POST['NivelT'].",'".$_POST['ntitulo']."','".$_POST['ninstitucion']."','".$_POST['ftitulo']."','".$_POST['codigo']."','".$_POST['docid']."')";
		$stmt1 = $db->prepare($sql1);
#		echo $sql1;	
	};
	if(isset($_POST['fa2']) and $_POST['fa2']=='1' and isset($_POST['NivelT2']) and isset($_POST['ntitulo2']) and isset($_POST['ninstitucion2']) and isset($_POST['ftitulo2']) and isset($_POST['codigo2'])){
		$sql2="INSERT INTO FAcademica ";
		$sql2.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional)";
		$sql2.=" VALUES (".$_POST['NivelT2'].",'".$_POST['ntitulo2']."','".$_POST['ninstitucion2']."','".$_POST['ftitulo2']."','".$_POST['codigo2']."','".$_POST['docid']."')";
		$stmt2 = $db->prepare($sql2);
#		echo $sql2;	
	};
#	if(isset($_POST['fa3']) and $_POST['fa3']=='1' and isset($_POST['NivelT3']) and isset($_POST['ntitulo3']) and isset($_POST['ninstitucion3']) and isset($_POST['ftitulo3']) and isset($_POST['codigo3'])){
#		$sql3="UPDATE FAcademica SET";
#		$sql3.=" FAcademicaNivel=".$_POST['NivelT3'].",FAcademicaNTitulo='".$_POST['ntitulo3']."',FAcademicaInstitucion='".$_POST['ninstitucion3']."',FAcademicaFecGrado='".$_POST['ftitulo3']."',FAcademicaCSenescyt='".$_POST['codigo3']."' WHERE IdFAcademica=".$_POST['idFa3'];
#		$stmt3 = $db->prepare($sql3);
##		echo $sql3;	
#	};
#	if(isset($_POST['fa4']) and $_POST['fa4']=='1' and isset($_POST['NivelT4']) and isset($_POST['ntitulo4']) and isset($_POST['ninstitucion4']) and isset($_POST['ftitulo4']) and isset($_POST['codigo4'])){
#		$sql4="UPDATE FAcademica SET";
#		$sql4.=" FAcademicaNivel=".$_POST['NivelT4'].",FAcademicaNTitulo='".$_POST['ntitulo4']."',FAcademicaInstitucion='".$_POST['ninstitucion4']."',FAcademicaFecGrado='".$_POST['ftitulo4']."',FAcademicaCSenescyt='".$_POST['codigo4']."' WHERE IdFAcademica=".$_POST['idFa4'];
#		$stmt4 = $db->prepare($sql4);
##		echo $sql4;	
#	};
#	if(isset($_POST['fa5']) and $_POST['fa5']=='1' and isset($_POST['NivelT5']) and isset($_POST['ntitulo5']) and isset($_POST['ninstitucion5']) and isset($_POST['ftitulo5']) and isset($_POST['codigo5'])){
#		$sql5="UPDATE FAcademica SET";
#		$sql5.=" FAcademicaNivel=".$_POST['NivelT5'].",FAcademicaNTitulo='".$_POST['ntitulo5']."',FAcademicaInstitucion='".$_POST['ninstitucion5']."',FAcademicaFecGrado='".$_POST['ftitulo5']."',FAcademicaCSenescyt='".$_POST['codigo5']."' WHERE IdFAcademica=".$_POST['idFa5'];
#		$stmt5 = $db->prepare($sql5);
##		echo $sql5;	
#	};
#	if(isset($_POST['fa6']) and $_POST['fa6']=='1' and isset($_POST['NivelT6']) and isset($_POST['ntitulo6']) and isset($_POST['ninstitucion6']) and isset($_POST['ftitulo6']) and isset($_POST['codigo6'])){
#		$sql6="UPDATE FAcademica SET";
#		$sql6.=" FAcademicaNivel=".$_POST['NivelT6'].",FAcademicaNTitulo='".$_POST['ntitulo6']."',FAcademicaInstitucion='".$_POST['ninstitucion6']."',FAcademicaFecGrado='".$_POST['ftitulo6']."',FAcademicaCSenescyt='".$_POST['codigo6']."' WHERE IdFAcademica=".$_POST['idFa6'];
#		$stmt6 = $db->prepare($sql6);
##		echo $sql6;	
#	};

#exit;
try {
	$db->beginTransaction();
#	$stmt = $db->prepare($sql);
#	$stmtus = $db->prepare($sql_us);
#	if(isset($stmt)){$stmt->execute();};
#	if(isset($stmtus)){$stmtus->execute();};
	if(isset($stmt1)){$stmt1->execute();};
	if(isset($stmt2)){$stmt2->execute();}; 
##	if(isset($stmt3)){$stmt3->execute();};
#	if(isset($stmt4)){$stmt4->execute();};
#	if(isset($stmt5)){$stmt5->execute();};
#	if(isset($stmt6)){$stmt6->execute();};
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){  // si se actualizo la informacion
#	$html_body="
#		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
#		<HTML>
#		<HEAD>
#		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
#		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
#		</HEAD>
#		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
#		Estimado(a)<B> ".$_POST['name']." ".$_POST['lname']." </B>:<BR><BR>
#		 Ha actualizado su informaci&oacute;n en la BASE DE DATOS DE PROFESIONALES DEL INPC<BR><BR>
#		 Este correo se ha enviado s&oacute;lo como informaci&oacute;n, especialmente si actualiz&oacute; sus direcciones de correo<BR><BR>
#		No responder a este correo, esta direcci&#243;n es s&#243;lo para notificaciones<BR>
#		<BR>
#		<TABLE CELLSPACING='0' CELLPADDING='0' WIDTH='100%'><TR><TD><BR>
#		<B><FONT SIZE='2'><FONT COLOR='#0000ff'>Atentamente</FONT></FONT></B><BR><BR><hr>
#		<B><FONT SIZE='2'><FONT COLOR='#0000ff'>SERVICIO DE REGISTRO DE PROFESIONALES INPC</FONT></FONT></B><BR>
#		<B><FONT SIZE='2'><FONT COLOR='#0000ff'>Direcci&#243;n de Conservaci&#243;n y Salvaguarda del Patrimonio Cultural</FONT></FONT></B><BR>
#		<B><FONT SIZE='2'><FONT COLOR='#0000ff'>INSTITUTO NACIONAL DE PATRIMONIO CULTURAL</FONT></FONT></B><BR><BR>
#		<I><FONT SIZE='2'><FONT COLOR='#0000ff'>Av. Col&#243;n Oe1-93 y Av. 10 de Agosto LA CIRCASIANA</FONT></FONT></I><BR>
#		<I><FONT SIZE='2'><FONT COLOR='#0000ff'>Telf: 2543-527, 2227-927 ext. 11</FONT></FONT></I><FONT COLOR='#0000ff'><FONT SIZE='2'>2</FONT></FONT><BR>
#		<I><FONT SIZE='2'><FONT COLOR='#0000ff'>Quito - Ecuador</FONT></FONT></I><BR>
#		<IMG SRC='http://mail.inpc.gob.ec/logo-inpc-firma.jpg' ALIGN='bottom' BORDER='0'><BR>
#		<BR><BR><BR></TD></TR></TABLE></BODY></HTML>
#	";

#	$altbody="
#		Estimado(a) ".$_POST['name']." ".$_POST['lname']." :\n
#		Ha Actualizado su informacion en la BASE DE DATOS DE PROFESIONALES DEL INPC\n\n
#		Este correo se ha enviado solo como informacion, especialmente si ha actualizado sus direcciones de correo\n\n
#		No responder a este correo, esta direccion es solo para notificaciones\n\n\n\n
#		Atentamente\n\n
#		SERVICIO DE REGISTRO DE PROFESIONALES INPC\n
#		Direccion de Conservacion y Salvaguarda del Patrimonio Cultural\n
#		INSTITUTO NACIONAL DE PATRIMONIO CULTURAL\n\n
#		Av. Colon Oe1-93 y Av. 10 de Agosto LA CIRCASIANA
#		Telf: 2543-527, 2227-927 ext. 112
#		Quito - Ecuador
#	";
	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
#	$mail->Subject = "Asunto: Postulacion Registro Base de Datos Profesionales INPC";
#	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
#	$mail->MsgHTML($html_body);

	// podemos hacer varios AddAdress
#	$mail->AddAddress($_POST['email'], $_POST['name']." ".$_POST['lname']);
#	if(isset($_POST['email2']) and $_POST['email2']!=''){
#	$mail->AddAddress($_POST['email2'], $_POST['name']." ".$_POST['lname']);
#	};
	// fin envio notificacion
#	$ok_text="
#		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES INPC</h3></center>
#		<font size='+1'>
#		Estimad@:  <strong><em>".$_POST['name'].' '.$_POST['lname']."<br><br></em></strong>
#		<br>
#		Sus datos personales as&iacute;n como de formaci&oacute;n Acad&eacute;mica han sido actualizados<br><br>

#		 Se ha enviado un correo electr&oacute;nico a la(s) cuenta(s) de correo especificada(s) por usted : <strong>".$_POST['email'].", ".$_POST['email2'].",</strong>
#		 como notificaci&oacute;n, indicativo que la(s) direcci&oacute;n(es) de correo editada(S) son correcta(s), por favor, si no visualiza el correo, revise su carpeta
#		 de correo no deseado (SPAM) y marque la direcci&oacute;n <strong>info.rpc@inpc.gob.ec</strong> como remitente seguro, para recibir notificaciones futuras del 
#		 proceso de registro.<br><br>		
#		</font></td></tr></table><br><br><br>
#		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='post_stat.php' method='POST'>
#		  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
#		</FORM></td></tr></table>
#	";

#	if(!$mail->Send()) {
#		echo "Error enviando: " . $mail->ErrorInfo;
#	} else {
#		echo $ok_text;
#	};
};
?>
<table align='center' border='0'><tr><td align='center'><FORM action='post_stat.php' method='POST'>
		  &nbsp;&nbsp;<INPUT class='buton' type='button' name='ok' value='Aceptar' size='10' onClick="reload_();window.close()">&nbsp;&nbsp;
		</FORM></td></tr></table>
<?php
//echo $sql;
$db=null;
exit;
?>


