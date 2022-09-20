<?php
	$es_hijo=1;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('footer-mail.php');
#	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};

?>
      <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				//			alert(window.opener.parent.cher.action);
//				window.opener.document.cher.target='_self';
//				window.opener.document.cher.action='validador-gui-xvalidar.php';
//				window.opener.document.cher.submit();
				window.parent.<?php echo $_POST['fifid']?>.submit();
				
			};
         </SCRIPT>
<?php
	$nextp='reload_()';
	$html_body_adic='';
	$alt_body_adic='';
	$titusados='';
	$migrando=0;
	$p_ya_ingresada=0;

	$sql_upd_profesional="UPDATE Profesional SET ProfesionalNombres='".$_POST['name']."',ProfesionalApellidos='".$_POST['lname']."',ProfesionalFecNacim='".$_POST['fnac']."',ProfesionalTlfmovil='".$_POST['tmovil']."',ProfesionalTlfFijo='".$_POST['tfijo']."',ProfesionalDireccion='".$_POST['direc']."',ProfesionalMail='".$_POST['email']."',ProfesionalMail2='".$_POST['email2']."',Ciudadr_idCiudadr=".$_POST['id_ciu'].",Ciudadr_Paisr_idPaisr='".$_POST['idPaisr']."', ProfesionalActualizo=1, ProfesionalLastActu=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00') WHERE idProfesional ='".$_POST['idProf']."'";
	$sql_us="UPDATE user SET realname='".$_POST['name']." ".$_POST['lname']."',email='".$_POST['email']."',email2='".$_POST['email2']."' WHERE username ='".$_POST['idProf']."'";
	$sql="SELECT idRegistroP FROM RegistroP WHERE Profesional_idProfesional='".$_POST['idProf']."' ";
	$is_reg=$db->query($sql);  
	if ($is_reg->rowCount()>0 ){
		if(!$_POST['prim_upd']){
			$sql_reg="UPDATE RegistroP SET RegistroPNombres='".$_POST['name']."',RegistroPApellidos='".$_POST['lname']."',RegistroPTlfMovil='".$_POST['tmovil']."',RegistroPTlfFijo='".$_POST['tfijo']."',RegistroPDireccion='".$_POST['direc']."',RegistroPMail='".$_POST['email']."',RegistroPMail2='".$_POST['email2']."',RegistroPCiudadr='".format_cont_db('idCiudadr',$_POST['id_ciu'])."',RegistroPPaisr='".format_cont_db('idPaisr',$_POST['idPaisr'])."' WHERE Profesional_idProfesional ='".$_POST['idProf']."'";
		}else{
			$sql_reg="UPDATE RegistroP SET RegistroPNombres='".$_POST['name']."',RegistroPApellidos='".$_POST['lname']."',RegistroPTlfMovil='".$_POST['tmovil']."',RegistroPTlfFijo='".$_POST['tfijo']."',RegistroPDireccion='".$_POST['direc']."',RegistroPMail='".$_POST['email']."',RegistroPMail2='".$_POST['email2']."',RegistroPCiudadr='".format_cont_db('idCiudadr',$_POST['id_ciu'])."',RegistroPPaisr='".format_cont_db('idPaisr',$_POST['idPaisr'])."' WHERE RegistroPProfesionalID=".$_POST['profes']." and Profesional_idProfesional ='".$_POST['idProf']."'";
			//INGRESAR SOLICITUD PARA REVISION
      //0603038936  aguirre merino    c_aguirre@espoch.edu.ec    jack_inti@hotmail.com
			$migrando=1;
			$titusados=", FAcademicaTituloValido =0,FAcademicaTituloUsado = 0 ";
			$get_act_profes=$db->query("SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['profes']."  AND Profesional_idProfesional='".$_POST['idProf']."' ") ;
			$act_p= $get_act_profes->fetch(PDO::FETCH_ASSOC);
			if($get_act_profes->rowCount()==0){
			//echo 'aki nunca entra';
				//$sql_ins_profs="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES (".$_POST['profes'].", '".$_POST['idProf']."')"; //INGRESO POSTULACION
			};
			$sql_ac_p="select idPostulacion from Postulacion where Profesiones_idProfesiones =".$act_p['idProfesiones']." and PostulacionEstado=0 and PostulacionFechaF is NULL";
			$get_act_post=$db->query($sql_ac_p);
			if($get_act_post->rowCount()==0){
				$sql_post="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones)  VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),(SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['profes']." and Profesional_idProfesional='".$_POST['idProf']."'))"; //INGRESO POSTULACION
				if(isset($sql_post)){$stmt_post = $db->prepare($sql_post);};
			}else{
				$p_ya_ingresada=1;
?>
				<table align='center' border='0'><tr><td align='center'class='tobut'><FORM name='redir' action='postulante-gui.php' method='POST'>
		  &nbsp;&nbsp;&nbsp;&nbsp;
		</FORM></td></tr></table>
<?php
				echo " <script> alert('Solicitud ya ingresada');redir.submit();</script> ";
			};      
			$get_mail_verficador = $db->query("SELECT realname,email,email2 FROM user WHERE username in (SELECT user_username FROM UsuarioManejaProfesional WHERE TipoProfesional_TipoProfesionalId in (SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional ='".$_POST['idProf']."')) and TipoUsuario_idTipoUsuario = 5");
			$mails_v= $get_mail_verficador->fetch(PDO::FETCH_ASSOC);

			$html_body_adic="<br>Una vez se revisen y validen los datos actualizados, su registro en la Base de Datos se habilitar&aacute;, cualquier novedad le ser&aacute; notificada<br>";
			$alt_body_adic="\n Una vez se revisen y validen los datos actualizados, su registro en la Base de Datos se habilitarÃ¡, cualquier novedad le serÃ¡ notificada\n";
			$nextp='window.parent.location.reload();';
			$html_body_notif="
				<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
				  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
				  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
				<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
				Estimado(a)<B> ".$mails_v['realname']." </B>:<BR><BR>El/la Profesional <b>".$_POST['name'].' '.$_POST['lname']."</b> actualiz&oacute; el registro en proceso  
				de migraci&oacute;n en la Base de Datos de Profesionales :&nbsp; <B>".format_cont_db('TipoProfesionalId',$_POST['profes'])."</B><BR><BR>
				Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
				<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
			$html_body_notif.=$footer_html;
			$html_body_notif.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

			$altbody_notif="
				Estimado(a) ".$mails_v['realname']." :\n\n
				 El/la Profesional ".$_POST['name'].' '.$_POST['lname']." actualizÃ³ el registro en proceso de migraciÃ³n en la Base de Datos de Profesionales:&nbsp; ".format_cont_db('TipoProfesionalId',$_POST['profes'])."\n\n
				Por favor ingrese al Sistema para revisar las solicitudes pendientes\n\n
				http://".$_SERVER['SERVER_NAME']." \n\n";
			$altbody_notif.=$footer_text;
			$altbody_notif=utf8_decode($altbody_notif);
      $verif_subjet = utf8_decode("Solicitud de Registro en proceso de migración");
				//envio de notifiacion
				// asunto y cuerpo alternativo del mensaje
			//FIN INGRESAR SOLICITUD PARA REVISAR
		};
		if(isset($sql_reg)){$stmt_updr = $db->prepare($sql_reg);};
	}else{
 //SI NO TIENE REGISTRO, MUY POSIBLEMENTE LE NEGARON LA PRIMERA POSTULACION, DEBE INGRESAR COMO NUEVA
 //echo 'aka cae<br>';
			$titusados=", FAcademicaTituloValido =0,FAcademicaTituloUsado = 0 ";
			$get_act_profes=$db->query("SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['profes']."  AND Profesional_idProfesional='".$_POST['idProf']."' ") ;
			$act_p= $get_act_profes->fetch(PDO::FETCH_ASSOC);
			if($get_act_profes->rowCount()==0){
	//		echo 'aki nunca entra';
				//$sql_ins_profs="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES (".$_POST['profes'].", '".$_POST['idProf']."')"; //INGRESO POSTULACION
			};
			$sql_ac_p="select idPostulacion from Postulacion where Profesiones_idProfesiones =".$act_p['idProfesiones']." and PostulacionEstado=0 and PostulacionFechaF is NULL";
			$get_act_post=$db->query($sql_ac_p);
			if($get_act_post->rowCount()==0){
				$sql_post="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones)  VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),(SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['profes']." and Profesional_idProfesional='".$_POST['idProf']."'))"; //INGRESO POSTULACION
				if(isset($sql_post)){$stmt_post = $db->prepare($sql_post);};
			}else{
				$p_ya_ingresada=1;
?>
				<table align='center' border='0'><tr><td align='center'class='tobut'><FORM name='redir' action='postulante-gui.php' method='POST'>
		  &nbsp;&nbsp;&nbsp;&nbsp;
		</FORM></td></tr></table>
<?php
				echo " <script> alert('Solicitud ya ingresada');redir.submit();</script> ";
			};      
			$get_mail_verficador = $db->query("SELECT realname,email,email2 FROM user WHERE username in (SELECT user_username FROM UsuarioManejaProfesional WHERE TipoProfesional_TipoProfesionalId in (SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional ='".$_POST['idProf']."')) and TipoUsuario_idTipoUsuario = 5");
			$mails_v= $get_mail_verficador->fetch(PDO::FETCH_ASSOC);

			$html_body_adic="<br>Una vez se revisen y validen los datos actualizados, su registro en la Base de Datos se habilitar&aacute;, cualquier novedad le ser&aacute; notificada<br>";
			$alt_body_adic="\n Una vez se revisen y validen los datos actualizados, su registro en la Base de Datos se habilitarÃ¡, cualquier novedad le serÃ¡ notificada\n";
			$nextp='window.parent.location.reload();';
			$html_body_notif="
				<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
				  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
				  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
				<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
				Estimado(a)<B> ".$mails_v['realname']." </B>:<BR><BR>El/la Profesional <b>".$_POST['name'].' '.$_POST['lname']."</b> actualiz&oacute; sus datos y repostula para
				ingreso en la Base de Datos de Profesionales :&nbsp; <B>".format_cont_db('TipoProfesionalId',$_POST['profes'])."</B><BR><BR>
				Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
				<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
			$html_body_notif.=$footer_html;
			$html_body_notif.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

			$altbody_notif="
				Estimado(a) ".$mails_v['realname']." :\n\n
				 El/la Profesional ".$_POST['name'].' '.$_POST['lname']." actualizó su datos y repostula para ingreso en la Base de Datos de Profesionales:&nbsp; ".format_cont_db('TipoProfesionalId',$_POST['profes'])."\n\n
				Por favor ingrese al Sistema para revisar las solicitudes pendientes\n\n
				http://".$_SERVER['SERVER_NAME']." \n\n";
			$altbody_notif.=$footer_text;
			$altbody_notif=utf8_decode($altbody_notif);
 			$verif_subjet = utf8_decode("Solicitud de Registro");
				//envio de notifiacion
				// asunto y cuerpo alternativo del mensaje
			//FIN INGRESAR SOLICITUD nueva PARA REVISAR
 
 //SI NO TIENE REGISTRO, MUY POSIBLEMENTE LE NEGARON LA PRIMERA POSTULACION, DEBE INGRESAR COMO NUEVA 
 };
#	if($_POST['idProf']=='0902194570'){
//echo $sql.'<br>'.$sql_us.'<br>'.$sql_reg.'<br>'.$sql_post.'<br>'.$html_body_notif;  //AQUI VEMOS QUE SENTENCIAS SE VAN A EJECUTAR 
#	};

	if(isset($_POST['fa1']) and $_POST['fa1']=='1' and isset($_POST['NivelT']) and isset($_POST['ntitulo']) and isset($_POST['ninstitucion']) and isset($_POST['ftitulo']) and isset($_POST['codigo'])){
		if($_POST['ftitulo']==''){$_POST['ftitulo']='0000-00-00';};
		$sql1="UPDATE FAcademica SET";
		$sql1.=" FAcademicaNivel=".$_POST['NivelT'].",FAcademicaNTitulo='".$_POST['ntitulo']."',FAcademicaInstitucion='".$_POST['ninstitucion']."',FAcademicaFecGrado='".$_POST['ftitulo']."',FAcademicaCSenescyt='".$_POST['codigo']."' $titusados WHERE IdFAcademica=".$_POST['idFa'];
		$stmt1 = $db->prepare($sql1);
#		echo $sql1;	
	};
	if(isset($_POST['fa2']) and $_POST['fa2']=='1' and isset($_POST['NivelT2']) and isset($_POST['ntitulo2']) and isset($_POST['ninstitucion2']) and isset($_POST['ftitulo2']) and isset($_POST['codigo2'])){
		if($_POST['ftitulo2']==''){$_POST['ftitulo2']='0000-00-00';};
		$sql2="UPDATE FAcademica SET";
		$sql2.=" FAcademicaNivel=".$_POST['NivelT2'].",FAcademicaNTitulo='".$_POST['ntitulo2']."',FAcademicaInstitucion='".$_POST['ninstitucion2']."',FAcademicaFecGrado='".$_POST['ftitulo2']."',FAcademicaCSenescyt='".$_POST['codigo2']."' $titusados WHERE IdFAcademica=".$_POST['idFa2'];
		$stmt2 = $db->prepare($sql2);
#		echo $sql2;	
	};
	if(isset($_POST['fa3']) and $_POST['fa3']=='1' and isset($_POST['NivelT3']) and isset($_POST['ntitulo3']) and isset($_POST['ninstitucion3']) and isset($_POST['ftitulo3']) and isset($_POST['codigo3'])){
		if($_POST['ftitulo3']==''){$_POST['ftitulo3']='0000-00-00';};
		$sql3="UPDATE FAcademica SET";
		$sql3.=" FAcademicaNivel=".$_POST['NivelT3'].",FAcademicaNTitulo='".$_POST['ntitulo3']."',FAcademicaInstitucion='".$_POST['ninstitucion3']."',FAcademicaFecGrado='".$_POST['ftitulo3']."',FAcademicaCSenescyt='".$_POST['codigo3']."' $titusados WHERE IdFAcademica=".$_POST['idFa3'];
		$stmt3 = $db->prepare($sql3);
#		echo $sql3;	
	};
	if(isset($_POST['fa4']) and $_POST['fa4']=='1' and isset($_POST['NivelT4']) and isset($_POST['ntitulo4']) and isset($_POST['ninstitucion4']) and isset($_POST['ftitulo4']) and isset($_POST['codigo4'])){
		if($_POST['ftitulo4']==''){$_POST['ftitulo4']='0000-00-00';};
		$sql4="UPDATE FAcademica SET";
		$sql4.=" FAcademicaNivel=".$_POST['NivelT4'].",FAcademicaNTitulo='".$_POST['ntitulo4']."',FAcademicaInstitucion='".$_POST['ninstitucion4']."',FAcademicaFecGrado='".$_POST['ftitulo4']."',FAcademicaCSenescyt='".$_POST['codigo4']."' $titusados WHERE IdFAcademica=".$_POST['idFa4'];
		$stmt4 = $db->prepare($sql4);
#		echo $sql4;	
	};
	if(isset($_POST['fa5']) and $_POST['fa5']=='1' and isset($_POST['NivelT5']) and isset($_POST['ntitulo5']) and isset($_POST['ninstitucion5']) and isset($_POST['ftitulo5']) and isset($_POST['codigo5'])){
		if($_POST['ftitulo5']==''){$_POST['ftitulo5']='0000-00-00';};
		$sql5="UPDATE FAcademica SET";
		$sql5.=" FAcademicaNivel=".$_POST['NivelT5'].",FAcademicaNTitulo='".$_POST['ntitulo5']."',FAcademicaInstitucion='".$_POST['ninstitucion5']."',FAcademicaFecGrado='".$_POST['ftitulo5']."',FAcademicaCSenescyt='".$_POST['codigo5']."' $titusados WHERE IdFAcademica=".$_POST['idFa5'];
		$stmt5 = $db->prepare($sql5);
#		echo $sql5;	
	};
	if(isset($_POST['fa6']) and $_POST['fa6']=='1' and isset($_POST['NivelT6']) and isset($_POST['ntitulo6']) and isset($_POST['ninstitucion6']) and isset($_POST['ftitulo6']) and isset($_POST['codigo6'])){
		if($_POST['ftitulo6']==''){$_POST['ftitulo6']='0000-00-00';};
		$sql6="UPDATE FAcademica SET";
		$sql6.=" FAcademicaNivel=".$_POST['NivelT6'].",FAcademicaNTitulo='".$_POST['ntitulo6']."',FAcademicaInstitucion='".$_POST['ninstitucion6']."',FAcademicaFecGrado='".$_POST['ftitulo6']."',FAcademicaCSenescyt='".$_POST['codigo6']."' $titusados WHERE IdFAcademica=".$_POST['idFa6'];
		$stmt6 = $db->prepare($sql6);
#		echo $sql6;	
	};

# exit;  //PARA EVIATR ENVIO DE CORREOS
try {
	$db->beginTransaction();
	$stmt = $db->prepare($sql_upd_profesional);  
	$stmtus = $db->prepare($sql_us);
#		if($_POST['idProf']=='0902194570'){exit;};

	if(!$p_ya_ingresada){//AQUI SE EJECUTAN LAS SENETNCIAS Y LUEGO SE ENVIAN LOS CORREOS
		if(isset($stmt)){$stmt->execute();};
		if(isset($stmt_updr)){$stmt_updr->execute();};
		if(isset($stmtus)){$stmtus->execute();};
		if(isset($stmt1)){$stmt1->execute();};
		if(isset($stmt2)){$stmt2->execute();}; 
		if(isset($stmt3)){$stmt3->execute();};
		if(isset($stmt4)){$stmt4->execute();};
		if(isset($stmt5)){$stmt5->execute();};
		if(isset($stmt6)){$stmt6->execute();};
		if(isset($stmt_post)){$stmt_post->execute();};
	};
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){  // si se actualizo la informacion
	$html_body="
		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
		<HTML>
		<HEAD>
		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
		</HEAD>
		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
		Estimado(a)<B> ".$_POST['name']." ".$_POST['lname']." </B>:<BR><BR>
		 Actualiz&oacute; su informaci&oacute;n PERSONAL <BR><BR>
		 Este correo se env&iacute;a s&oacute;lo como informaci&oacute;n, especialmente si actualiz&oacute; sus direcciones de correo<BR><BR>".$html_body_adic."
		No responder a este correo, esta direcci&#243;n es s&#243;lo para notificaciones<BR>
		<BR>";
		$html_body.=$footer_html;
		
	$altbody="
		Estimado(a) ".$_POST['name']." ".$_POST['lname']." :\n
		ActualizÃ³ su informacion en la BASE DE DATOS DE PROFESIONALES \n\n
		Este correo se ha envÃ­a solo como informaciÃ³n, especialmente si ha actualizÃ³ sus direcciones de correo\n\n".$alt_body_adic."
		No responder a este correo, esta direcciÃ³n es solo para notificaciones\n\n\n\n";
		$altbody.=$footer_text;
		 $altbody=utf8_decode($altbody);
	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$subj=utf8_decode("Actualización de Datos");
	$mail->Subject = $subj;
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);
	$coma='';
	// podemos hacer varios AddAdress''	
	$mail->AddAddress($_POST['email'], $_POST['name']." ".$_POST['lname']);
	if(isset($_POST['email2']) and $_POST['email2']!=''){
		$coma=', ';
		$mail->AddAddress($_POST['email2'], $_POST['name']." ".$_POST['lname']);
	};
	// fin envio notificacion
	$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Estimad@:  <strong><em>".$_POST['name'].' '.$_POST['lname']."<br><br></em></strong>
		<br>
		Sus datos personales y/o de Formaci&oacute;n Acad&eacute;mica se actualizaron<br><br>
		 Se envi&oacute; un correo electr&oacute;nico a la(s) cuenta(s) de correo especificada(s) por usted : <strong>".$_POST['email'].$coma.$_POST['email2'].",</strong>
		 como notificaci&oacute;n, indicativo que la(s) direcci&oacute;n(es) de correo editada(S) son correcta(s), por favor, si no visualiza el correo, revise su carpeta
		 de correo no deseado (SPAM) y marque la direcci&oacute;n <strong>info.rpc@inpc.gob.ec</strong> como remitente seguro, para recibir notificaciones.<br><br>		
		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='post_stat.php' method='POST'>
		  &nbsp;&nbsp;<INPUT onClick='".$nextp."' type='button' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
		</FORM></td></tr></table>
	";
	if(!$p_ya_ingresada){
		if(!$mail->Send()) {
			echo "Error enviando: " . $mail->ErrorInfo;
		} else {
			echo $ok_text;
		};
		$mail->clearAddresses();
		if ($migrando){
			$mail->clearAddresses();
			$mail->Subject = utf8_decode($verif_subjet);
			$altbody_notif=utf8_decode($altbody_notif);
			$mail->AltBody = $altbody_notif; 
			// si el cuerpo del mensaje es HTML
			$mail->MsgHTML($html_body_notif);

			// podemos hacer varios AddAdress
      $mail->AddAddress("sistemas@inpc.gob.ec","Sistemas");
			$mail->AddAddress($mails_v['email'], $mails_v['realname']);
			if($mails_v['email2']!=''){
				$mail->AddAddress($mails_v['email2'], $mails_v['realname']);
			};
			if(!$mail->Send()) {
				echo "Error enviando: " . $mail->ErrorInfo;
			};
		};
	};
};

#echo $sql;
$db=null;
exit;
?>
