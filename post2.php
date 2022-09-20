<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('footer-mail.php');

	for($i=0;$i < count($keyes); $i++){
		//echo $keyes[$i].' '.$values[$i]."<br>";
	};//echo $_POST['fa1'].' '.$_POST['fa2'].' '.$_POST['fa3'].' '.$_POST['fa4'].' '.$_POST['fa5'].' '.$_POST['fa6'].' hahah';	
	function pwd_gen(){
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$chars = "";
		$length='10';
		$chars .= $alpha;
		$chars .= $alpha_upper;
		$chars .= $numeric;
		$len = strlen($chars);
		$pw = str_shuffle($chars);
		for ($i=0;$i<$length;$i++){
			$pw .= substr($pw, rand(0, $len-1), 1);
		};
		$pw = substr($pw, 0, $length);
		return $pw = str_shuffle($pw);
	};
	function token_gen(){
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$chars = "";
		$length='10';
		$chars .= $alpha;
		$chars .= $alpha_upper;
		$chars .= $numeric;
		$len = strlen($chars);
		$pw = str_shuffle($chars);
		for ($i=0;$i<$length;$i++){
			$pw .= substr($pw, rand(0, $len-1), 1);
		};
		$pw = substr($pw, 0, $length);
		return $pw = str_shuffle($pw);
	};
?>
<html>
<HEAD>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
</HEAD>
<BODY onLoad="expandit2('htopic',0);">
<div id='htopic'  class="literatura" style="DISPLAY:; position:fixed; border: 0px; font-size:20px; float:center; width:400px; height:150px; " onClick="">
<center>
<p align='left' STYLE="  font-family: arial;  text-align:justify; margin-top:5; margin-right:5%; margin-bottom:5; margin-left:5%;">
	Por favor espere mientras se procesa el formulario </p>
	<img align='center' src="image/loading.gif"> 	
	</center>
</div>
<?php
	$salto=0;
	$siejecuta=1;
	if (isset($_POST['newp']) and $_POST['newp']){
		$acction="postulante-gui.php";
	}else{
		$acction="index.php";
	};
	$stpro = $db->query("SELECT TipoprofesionalNombre FROM TipoProfesional WHERE TipoProfesionalId ='".$_POST['TipoProfesionalId']."'");	
	if ($stpro->rowCount()>0){$stp= $stpro->fetch(PDO::FETCH_ASSOC);};
	$ok_text_adic='';

	$en_migra = $db->query("SELECT * FROM user WHERE username='".$_POST['docid']."'");
	while($mig = $en_migra->fetch(PDO::FETCH_ASSOC)) {
		if(($mig['userEstado']==0 and $mig['userTokenReg']=='generar') or ($mig['userEstado']==0 and $mig['userTokenReg']!=NULL and $mig['password']=='generar')){
			 $ok_text_p="
				<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
				<font size='+1'>
				Estimado(a) Se&ntilde;or(a):  <strong><em>".$mig['realname']."<br><br></em></strong><br>
				Usted ya posee registro como: <strong><em>".$stp['TipoprofesionalNombre']."</em></strong><br><br>
				Su registro esta en proceso de migraci&oacute;n a la base de datos en l&iacute;nea, La Direcci&oacute;n de Conservaci&oacute;n indicar&aacute; el procedimiento para actualizaci&oacute;n de sus datos 
				en los proximos d&iacute;as. Hemos registrado su direcci&oacute;n de correo para notificarle<br></font></td></tr></table><br><br><br>
				<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='index.php' method='POST'>
				  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
				</FORM></td></tr></table>
			";
#			echo $ok_text_p;
			$mail->Subject = "Intento de registro de profesional pre registrado ";
			$html_body="Identificacion: ".$_POST['docid']."<br>Nombres: ".$_POST['name']." ".$_POST['lname']."<br> Tipo Profesional: ".$_POST['espec']."<br> Mail 1:".$_POST['email']."<br> Mail 2: ".$_POST['email2'];
			$mail->MsgHTML($html_body);
			$mail->AddAddress("ivocamacho@gmail.com","Ivan Camacho");
//			$mail->AddAddress("ivan.camacho@inpc.gob.ec","Ivan Camacho");
			$mail->AddAddress("homero.duque@inpc.gob.ec","Homero Duque");
      $mail->AddAddress("sistemas@inpc.gob.ec","Sistemas");
/*			if($_POST['docid']!='0602908170' and $_POST['docid']!='1717275406'){*/
				if(!$mail->Send()) {
					echo "Error enviando intento fallido: " . $mail->ErrorInfo;
				} ;
/*			};	*/

			if(TRUE /*$_POST['docid']=='0602908170' or  $_POST['docid']=='1717275406'*/)
			{		//ACTUALIZO REGISTRO DE Profesional
#		ini_set('display_errors', 1);
#	error_reporting(E_ALL);
#$siejecuta=0;
						$sql_update_prof="UPDATE Profesional SET ProfesionalNombres='".$_POST['name']."', ProfesionalApellidos='".$_POST['lname']."', ProfesionalFecNacim='".$_POST['fnac']."', ProfesionalTlfmovil='".$_POST['tmovil']."', ProfesionalTlfFijo='".$_POST['tfijo']."', ProfesionalDireccion='".$_POST['direc']."', ProfesionalMail='".$_POST['email']."', ProfesionalMail2='".$_POST['email2']."', Ciudadr_idCiudadr=".$_POST['id_ciu'].",Ciudadr_Paisr_idPaisr='".$_POST['idPaisr']."', Nacionalidad_idNacionalidad='".$_POST['idNacionalidad']."', ProfesionalActualizo=1, ProfesionalLastActu=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'), ProfesionalEspec='".$_POST['espec']."' WHERE idProfesional='".$_POST['docid']."'";
						$tmp_pwd=pwd_gen();		//ACTUALIZO REGISTRO DE USUARIO
						$tmp_token=token_gen();
						$sql_update_user="UPDATE user SET realname='".$_POST['name'].' '.$_POST['lname']."', email='".$_POST['email']."', email2='".$_POST['email2']."', password=password('".$tmp_pwd."'), userTokenReg='".$tmp_token."' WHERE username ='".$_POST['docid']."'";
								//ACTUALIZO REGISTRO EN BASE DE DATOS
						$sql_update_reg="UPDATE RegistroP SET RegistroPNombres='".$_POST['name']."',RegistroPApellidos='".$_POST['lname']."',RegistroPTlfMovil='".$_POST['tmovil']."',RegistroPTlfFijo='".$_POST['tfijo']."',RegistroPDireccion='".$_POST['direc']."',RegistroPMail='".$_POST['email']."',RegistroPMail2='".$_POST['email2']."',RegistroPCiudadr='".format_cont_db('idCiudadr',$_POST['id_ciu'])."',RegistroPPaisr='".format_cont_db('idPaisr',$_POST['idPaisr'])."' WHERE Profesional_idProfesional ='".$_POST['docid']."'";

						$sql_reg_academicos_="SELECT * FROM FAcademica  WHERE Profesional_idProfesional ='".$_POST['docid']."'";
						$reg_academicos_=$db->query($sql_reg_academicos_);
						$regs=$reg_academicos_->rowCount();
						$fas=0;
						if(isset($_POST['fa1']) and $_POST['fa1']=='1' and  isset($_POST['NivelT']) and isset($_POST['ntitulo']) and isset($_POST['ninstitucion']) and isset($_POST['ftitulo']) and isset($_POST['codigo'])){
							if(1 <= $regs){
								$sql1="UPDATE FAcademica SET FAcademicaNivel=".$_POST['NivelT'].",FAcademicaNTitulo='".$_POST['ntitulo']."',FAcademicaInstitucion='".$_POST['ninstitucion']."',FAcademicaFecGrado='".$_POST['ftitulo']."',FAcademicaCSenescyt='".$_POST['codigo']."' WHERE Profesional_idProfesional='".$_POST['docid']."' and FAcademicaCSenescyt ='".$_POST['TipoProfesionalId'].'-actualice-'.$_POST['docid']."'";
							}else{
								$sql1="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT'].",'".$_POST['ntitulo']."','".$_POST['ninstitucion']."','".$_POST['ftitulo']."','".$_POST['codigo']."','".$_POST['docid']."')";
							};
									$stmt1 = $db->prepare($sql1);
#							echo $sql1;	
						};
						if(isset($_POST['fa2']) and $_POST['fa2']=='1' and isset($_POST['NivelT2']) and isset($_POST['ntitulo2']) and isset($_POST['ninstitucion2']) and isset($_POST['ftitulo2']) and isset($_POST['codigo2'])){
							if(2 <= $regs){
								$sql2="UPDATE FAcademica SET FAcademicaNivel=".$_POST['NivelT2'].",FAcademicaNTitulo='".$_POST['ntitulo2']."',FAcademicaInstitucion='".$_POST['ninstitucion2']."',FAcademicaFecGrado='".$_POST['ftitulo2']."',FAcademicaCSenescyt='".$_POST['codigo2']."' WHERE Profesional_idProfesional='".$_POST['docid']."' and FAcademicaCSenescyt ='".$_POST['TipoProfesionalId'].'-actualice-'.$_POST['docid']."'";
							}else{
								$sql2="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT2'].",'".$_POST['ntitulo2']."','".$_POST['ninstitucion2']."','".$_POST['ftitulo2']."','".$_POST['codigo2']."','".$_POST['docid']."')";
							};
									$stmt2 = $db->prepare($sql2);
#							echo $sql2;	
						};
						if(isset($_POST['fa3']) and $_POST['fa3']=='1' and isset($_POST['NivelT3']) and isset($_POST['ntitulo3']) and isset($_POST['ninstitucion3']) and isset($_POST['ftitulo3']) and isset($_POST['codigo3'])){
							$sql3="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT3'].",'".$_POST['ntitulo3']."','".$_POST['ninstitucion3']."','".$_POST['ftitulo3']."','".$_POST['codigo3']."','".$_POST['docid']."')";
									$stmt3 = $db->prepare($sql3);
#							echo $sql3;	
						};
						if(isset($_POST['fa4']) and $_POST['fa4']=='1' and isset($_POST['NivelT4']) and isset($_POST['ntitulo4']) and isset($_POST['ninstitucion4']) and isset($_POST['ftitulo4']) and isset($_POST['codigo4'])){
							$sql4="INSERT INTO FAcademica FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT4'].",'".$_POST['ntitulo4']."','".$_POST['ninstitucion4']."','".$_POST['ftitulo4']."','".$_POST['codigo4']."','".$_POST['docid']."')";
									$stmt4 = $db->prepare($sql4);
#							echo $sql4;	
						};
						if(isset($_POST['fa5']) and $_POST['fa5']=='1' and isset($_POST['NivelT5']) and isset($_POST['ntitulo5']) and isset($_POST['ninstitucion5']) and isset($_POST['ftitulo5']) and isset($_POST['codigo5'])){
							$sql5="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT5'].",'".$_POST['ntitulo5']."','".$_POST['ninstitucion5']."','".$_POST['ftitulo5']."','".$_POST['codigo5']."','".$_POST['docid']."')";
									$stmt5 = $db->prepare($sql5);
#							echo $sql5;	
						};
						if(isset($_POST['fa6']) and $_POST['fa6']=='1' and isset($_POST['NivelT6']) and isset($_POST['ntitulo6']) and isset($_POST['ninstitucion6']) and isset($_POST['ftitulo6']) and isset($_POST['codigo6'])){
							$sql6="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional) VALUES (".$_POST['NivelT6'].",'".$_POST['ntitulo6']."','".$_POST['ninstitucion6']."','".$_POST['ftitulo6']."','".$_POST['codigo6']."','".$_POST['docid']."')";
									$stmt6 = $db->prepare($sql6);
#							echo $sql6;	
						};
						$get_act_profes=$db->query("SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['TipoProfesionalId']."  AND Profesional_idProfesional='".$_POST['docid']."' ") ;
						if($get_act_profes->rowCount()==0){
							$sql_ins_profs="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES (".$_POST['TipoProfesionalId'].", '".$_POST['docid']."')"; //INGRESO POSTULACION
		};

						$mail->clearAddresses();
						$html_body='';
						$html_body_adic='';
						$alt_body_adic='';

						$html_body_adic="Nombre de usuario:&nbsp; <B>".$_POST['docid']."</B><BR>Contrase&ntilde;a Temporal:&nbsp;&nbsp;&nbsp; <B>".$tmp_pwd."</B><BR><BR>
						Su solicitud ser&aacute; procesada una vez que cambie su Contrase&ntilde;a Temporal <BR><BR>
						<A HREF='http://".$_SERVER['SERVER_NAME']."/confirmap.php?token=".$tmp_token."&tipop=".$_POST['TipoProfesionalId']."'>Confirmaci&oacute;n de solicitud de registro</A><BR>";
	
						$alt_body_adic="Nombre de usuario:  ".$_POST['docid']."\nContraseña Temporal: ".$tmp_pwd."\n\n
						Su solicitud será procesada una vez que cambie su Contraseña Temporal.\n\n
						Confirmación de solicitud de registro (copie el enlace y péguelo en la barra de direcciones de su navegador): http://".$_SERVER['SERVER_NAME']."/confirmap.php&?oken=".$tmp_token."&tipop=".$_POST['TipoProfesionalId']."\n";
						$salto=1;
					};


		};
			
#			if ($_POST['docid'=='0602908170']){echo 'sañe';exit;};
	};
	$post_en_proceso = $db->query("SELECT * FROM Postulacion WHERE Profesiones_idProfesiones IN (SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['TipoProfesionalId']." and Profesional_idProfesional='".$_POST['docid']."')");
	while($proc = $post_en_proceso->fetch(PDO::FETCH_ASSOC)) {
		if($proc['PostulacionFechaI']!='' and $proc['PostulacionFechaF']==''){
			 $ok_text_proc="
				<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
				<font size='+1'>
				Estimado(a) Se&ntilde;or(a):  <strong><em>".format_cont_db('idProfesional',$_POST['docid'])."<br><br></em></strong><br>
				Usted ya posee solicitud de registro como: <strong><em>".format_cont_db('TipoProfesionalId',$_POST['TipoProfesionalId'])."</em></strong> en proceso<br><br>
				Puede dar seguimiento a la misma ingresando a su cuenta de usuario.<br></font></td></tr></table><br><br><br>
				<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='log-im.php' method='POST'>
				  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
				</FORM></td></tr></table>
			";
			echo $ok_text_proc;
			exit;
		};
	};

if(!$salto){
	#$existe= $db->query("SELECT idProfesional FROM Profesional WHERE idProfesional='".$_POST['docid']."'");
	$existe= $db->query("SELECT idProfesional FROM Profesional WHERE idProfesional='".$_POST['docid']."'");
	if ($existe->rowCount()){  //registro de profesional existe, solo ingreso nueva postulacion
	 	$ok_text_adic="Usted registr&oacute; solicitudes anteriormente y ya posee una cuenta en el servicio de Registro de Profesionales . Esta nueva solicitud se 
		registr&oacute; directamente<br><br>
			Ingrese al servicio con sus credenciales o utilice la opci&oacute;n 'Olvid&eacute; mi contrase&ntilde;a' de la p&aacute;gina 'Ingreso al Sistema'.";
		$html_body_adic="Para dar seguimiento a su nueva solicitud, ingrese al sistema con sus credenciales o utilice la opci&oacute;n 'Olvid&eacute; mi contrase&ntilde;a'
		 de la p&aacute;gina 'Ingreso al Sistema'.<br><A HREF='http://".$_SERVER['SERVER_NAME']."/log-im.php'>SERVICIO DE REGISTRO DE PROFESIONALES</A><BR>";
		$alt_body_adic="Para dar seguimiento a su nueva solicitud, ingrese al sistema con sus credenciales o utilice la opción 'Olvidé mi contraseña'
		 de la página 'Ingreso al Sistema'.\nhttp://".$_SERVER['SERVER_NAME']."/log-im.php";
		$get_act_profes=$db->query("SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['TipoProfesionalId']."  AND Profesional_idProfesional='".$_POST['docid']."' ") ;
	#	$act_p= $get_act_profes->fetch(PDO::FETCH_ASSOC);
		if($get_act_profes->rowCount()==0){
			$sql_ins_profs="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES (".$_POST['TipoProfesionalId'].", '".$_POST['docid']."')"; //INGRESO POSTULACION
		};
	#$sql_post="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones)  VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),'".$_POST['docid']."')"; //INGRESO POSTULACION#
		$sql_mig="SELECT count(idRegistroP) FROM RegistroP WHERE Profesional_idProfesional='".$_POST['docid']."' and RegistroPProfesionalID=".$_POST['TipoProfesionalId']." and RegistroPActivo=0";
		$is_reg=$db->query($sql_mig); //esta migrando
		if ($is_reg->rowCount()==0 ){
			$sql_post="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones)  VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),(SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$_POST['TipoProfesionalId']." and Profesional_idProfesional='".$_POST['docid']."'))"; //INGRESO POSTULACION
			$get_mail_verficador = $db->query("SELECT realname,email,email2 FROM user WHERE username in (SELECT user_username FROM UsuarioManejaProfesional WHERE TipoProfesional_TipoProfesionalId in (SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional ='".$_POST['docid']."')) and TipoUsuario_idTipoUsuario = 5");
			$mails_v= $get_mail_verficador->fetch(PDO::FETCH_ASSOC);

					$html_body_notif="
						<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
						  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
						  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
						<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
						Estimado(a)<B> ".$mails_v['realname']." </B>:<BR><BR>El/la Profesional <b>".$_POST['name'].' '.$_POST['lname']."</b> ingres&oacute; una solicitud  
						para registrarse en la Base de Datos de Profesionales :&nbsp; <B>".$stp['TipoprofesionalNombre']."</B><BR><BR>
						Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
						<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
					$html_body_notif.=$footer_html;
					$html_body_notif.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

					$altbody_notif="
						Estimado(a) ".$mails_v['realname']." :\n\n
						 El/la Profesional ".$_POST['name'].' '.$_POST['lname']." ingresó una solicitud para registrarse en la Base de Datos de Profesionales:&nbsp; ".$stp['TipoprofesionalNombre']."\n\n
						Por favor ingrese al Sistema para revisar las solicitudes pendientes\n\n
						http://".$_SERVER['SERVER_NAME']." \n\n";
					$altbody_notif.=$footer_text;
					$altbody_notif=utf8_decode($altbody_notif);
					//envio de notifiacion
					// asunto y cuerpo alternativo del mensaje
			}else{
				 $ok_text_p="
					<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
					<font size='+1'>
					Estimado(a) Se&ntilde;or(a):  <strong><em>".$_POST['name'].' '.$_POST['lname']."<br><br></em></strong><br>
					Usted ya posee registro como: <strong><em>".format_cont_db('TipoProfesionalId',$_POST['TipoProfesionalId'])."</em></strong><br><br>
					Su registro esta en proceso de migraci&oacute;n, si recibe este mensaje y tiene problemas env&iacute; un mail con la descripci&oacute; del mismo
					a info.rpc@inpc.gob.ec para que nuestro personal de servicio t&eacute;cnico le brinde asistencia. 
					</font></td></tr></table><br><br><br>
					<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='index.php' method='POST'>
					  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
					</FORM></td></tr></table>
				";
				echo $ok_text_p;
				exit;
		
			};
	#	exit;
	}else{	//registro de profesional no existe, ingreso datos y creo usuario

		$sql="INSERT INTO Profesional";   //CREO REGISTRO DE PROFESIONAL POSTULANTE
		$sql.=" (idProfesional,ProfesionalNombres,ProfesionalApellidos,ProfesionalFecNacim,ProfesionalTlfmovil,ProfesionalTlfFijo,ProfesionalDireccion,ProfesionalMail,ProfesionalMail2,TipoDocID_idTipoDocID,Nacionalidad_idNacionalidad,Ciudadr_idCiudadr,Ciudadr_Paisr_idPaisr, ProfesionalActualizo, ProfesionalLastActu,ProfesionalEspec )";
		$sql.=" VALUES ('".$_POST['docid']."','".$_POST['name']."','".$_POST['lname']."','".$_POST['fnac']."','".$_POST['tmovil']."','".$_POST['tfijo']."','".$_POST['direc']."','".$_POST['email']."','".$_POST['email2']."',".$_POST['idTipoDocID'].",'".$_POST['idNacionalidad']."',".$_POST['id_ciu'].",'".$_POST['idPaisr']."',1,CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),'".$_POST['espec']."')";

		$sql_ins_profs="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional) VALUES (".$_POST['TipoProfesionalId'].", '".$_POST['docid']."')";

		$tmp_pwd=pwd_gen();		//CREO REGISTRO DE USUARIO
		$tmp_token=token_gen();
		$sql_us="INSERT INTO user";
		$sql_us.=" (username,realname,password,email,email2,userEstado,userTokenReg,TipoUsuario_idTipoUsuario)";
		$sql_us.=" VALUES ('".$_POST['docid']."','".$_POST['name']." ".$_POST['lname']."',password('".$tmp_pwd."'),'".$_POST['email']."','".$_POST['email2']."',0,'".$tmp_token."',3)";

	#	$ok_text_adic="
	#	Confirme su solicitud y registro como usuario ingresando al enlace en el correo que recibir&aacute; y cambiando la contrase&ntilde;a temporal.<br>
	#	";
		 $ok_text='';

		$html_body_adic="Nombre de usuario:&nbsp; <B>".$_POST['docid']."</B><BR>Contrase&ntilde;a Temporal:&nbsp;&nbsp;&nbsp; <B>".$tmp_pwd."</B><BR><BR>
		Su solicitud ser&aacute; procesada una vez que cambie su Contrase&ntilde;a Temporal <BR><BR>
		<A HREF='http://".$_SERVER['SERVER_NAME']."/confirmap.php?token=".$tmp_token."&tipop=".$_POST['TipoProfesionalId']."'>Confirmaci&oacute;n de solicitud de registro</A><BR>";
	
		$alt_body_adic="Nombre de usuario:  ".$_POST['docid']."\nContraseña Temporal: ".$tmp_pwd."\n\n
		Su solicitud será procesada una vez que cambie su Contraseña Temporal.\n\n
		Confirmación de solicitud de registro (copie el enlace y péguelo en la barra de direcciones de su navegador): http://".$_SERVER['SERVER_NAME']."/confirmap.php&?oken=".$tmp_token."&tipop=".$_POST['TipoProfesionalId']."\n";
	};

	//echo $sql.'<br>'.$sql_us.'<br>';

		if(isset($_POST['fa1']) and $_POST['fa1']=='1' and  isset($_POST['NivelT']) and isset($_POST['ntitulo']) and isset($_POST['ninstitucion']) and isset($_POST['ftitulo']) and isset($_POST['codigo'])){
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
		if(isset($_POST['fa3']) and $_POST['fa3']=='1' and isset($_POST['NivelT3']) and isset($_POST['ntitulo3']) and isset($_POST['ninstitucion3']) and isset($_POST['ftitulo3']) and isset($_POST['codigo3'])){
			$sql3="INSERT INTO FAcademica ";
			$sql3.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional)";
			$sql3.=" VALUES (".$_POST['NivelT3'].",'".$_POST['ntitulo3']."','".$_POST['ninstitucion3']."','".$_POST['ftitulo3']."','".$_POST['codigo3']."','".$_POST['docid']."')";
			$stmt3 = $db->prepare($sql3);
	#		echo $sql3;	
		};
		if(isset($_POST['fa4']) and $_POST['fa4']=='1' and isset($_POST['NivelT4']) and isset($_POST['ntitulo4']) and isset($_POST['ninstitucion4']) and isset($_POST['ftitulo4']) and isset($_POST['codigo4'])){
			$sql4="INSERT INTO FAcademica ";
			$sql4.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional)";
			$sql4.=" VALUES (".$_POST['NivelT4'].",'".$_POST['ntitulo4']."','".$_POST['ninstitucion4']."','".$_POST['ftitulo4']."','".$_POST['codigo4']."','".$_POST['docid']."')";
			$stmt4 = $db->prepare($sql4);
	#		echo $sql4;	
		};
		if(isset($_POST['fa5']) and $_POST['fa5']=='1' and isset($_POST['NivelT5']) and isset($_POST['ntitulo5']) and isset($_POST['ninstitucion5']) and isset($_POST['ftitulo5']) and isset($_POST['codigo5'])){
			$sql5="INSERT INTO FAcademica ";
			$sql5.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional)";
			$sql5.=" VALUES (".$_POST['NivelT5'].",'".$_POST['ntitulo5']."','".$_POST['ninstitucion5']."','".$_POST['ftitulo5']."','".$_POST['codigo5']."','".$_POST['docid']."')";
			$stmt5 = $db->prepare($sql5);
	#		echo $sql5;	
		};
		if(isset($_POST['fa6']) and $_POST['fa6']=='1' and isset($_POST['NivelT6']) and isset($_POST['ntitulo6']) and isset($_POST['ninstitucion6']) and isset($_POST['ftitulo6']) and isset($_POST['codigo6'])){
			$sql6="INSERT INTO FAcademica";
			$sql6.=" (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional,)";
			$sql6.=" VALUES (".$_POST['NivelT6'].",'".$_POST['ntitulo6']."','".$_POST['ninstitucion6']."','".$_POST['ftitulo6']."','".$_POST['codigo6']."','".$_POST['docid']."')";
			$stmt6 = $db->prepare($sql6);
	#		echo $sql6;	
		};
};
#exit;

try {
	$db->beginTransaction();		
	if(isset($sql)){$stmt = $db->prepare($sql);};
	if(isset($sql_ins_profs)){$stmt_profes = $db->prepare($sql_ins_profs);};
	if(isset($sql_us)){$stmtus = $db->prepare($sql_us);};	
	if(isset($sql_post)){$stmt_post = $db->prepare($sql_post);};
	//ACTIVACION AUTOMATICA DE PREREGISTRADOS
	if(isset($sql_update_prof)){$stmt_uprof = $db->prepare($sql_update_prof);};
	if(isset($sql_update_user)){$stmt_uuser = $db->prepare($sql_update_user);};	
	if(isset($sql_update_reg)){$stmt_ureg = $db->prepare($sql_update_reg);};
	//ACTIVACION AUTOMATICA DE PREREGISTRADOS
/*if($siejecuta){*/
	if(isset($stmt)){$stmt->execute();};
	if(isset($stmtus)){$stmtus->execute();};
	if(isset($stmt_profes)){$stmt_profes->execute();};
	if(isset($stmt_post)){$stmt_post->execute();};
	if(isset($stmt1)){$stmt1->execute();};
	if(isset($stmt2)){$stmt2->execute();}; 
	if(isset($stmt3)){$stmt3->execute();};
	if(isset($stmt4)){$stmt4->execute();};
	if(isset($stmt5)){$stmt5->execute();};
	if(isset($stmt6)){$stmt6->execute();};
	//ACTIVACION AUTOMATICA DE PREREGISTRADOS
	if(isset($stmt_uprof)){$stmt_uprof->execute();};
	if(isset($stmt_uuser)){$stmt_uuser->execute();};
	if(isset($stmt_ureg)){$stmt_ureg->execute();};
/*};	*/
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){
	$html_body="
		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
		<HTML>
		<HEAD>
		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
		</HEAD>
		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
		Estimado(a) Se&ntilde;or(a):<B> ".$_POST['name']." ".$_POST['lname']." </B>:<BR><BR>
		 Se ingres&oacute; su solicitud de registro de manera exitosa en el Sistema Autom&aacute;tico de Registro de Profesionales: <em>".$stp['TipoprofesionalNombre']."</em></strong><BR><BR>
		 ".$html_body_adic."<BR><a href=\"JavaScript:\" onClick=\"abrir('http://".$_SERVER['SERVER_NAME']."/manual/MANUAL-USUARIO-EXTERNO.pdf','help',ancho,alto,0);return false;\"><font color='#0000ff'>Manual Profesional Solicitante</font></a><BR>";
	$html_body.=$footer_html;
	 $html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

	$altbody="Estimado(a) Señor(a): ".$_POST['name']." ".$_POST['lname']." :\nSe ingresó su solicitud de registro de manera exitosa en el Sistema Automático de Registro de Profesionales: ".$stp['TipoprofesionalNombre']."  \n\n".$alt_body_adic."\n\n";
	$altbody.=$footer_text;
	 $altbody=utf8_decode($altbody);
	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$mail->Subject = "Solicitud de Registro ";
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);
	$coma='';
	// podemos hacer varios AddAdress
	$mail->AddAddress($_POST['email'], $_POST['name']." ".$_POST['lname']);
	if($_POST['email2']!=''){
		$mail->AddAddress($_POST['email2'], $_POST['name']." ".$_POST['lname']);
		$coma=', ';
	};
	// fin envio notificacion
	 $ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'><p style='text-align:justify'>
		Estimado(a) Se&ntilde;or(a):  <strong><em>".$_POST['name'].' '.$_POST['lname']."<br><br></em></strong><br>
		Su solicitud de Registro ingres&oacute; con &eacute;xito a nuestro Sistema Autom&aacute;tico y se envi&oacute; un correo electr&oacute;nico a su direcci&oacute;n
		electr&oacute;nica registrada. Es importante que usted lea la notificaci&oacute;n enviada para continuar con el proceso de registro.<br>
		Si no puede visualizar la notificaci&oacute;n en su correo electr&oacute;nico, por favor b&uacute;squela como SPAM <br><br>
		 ".$ok_text_adic."</font></p></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='".$acction."' method='POST'>
		  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
		</FORM></td></tr></table>
	";
/*	if ($siejecuta){*/
	if(!$mail->Send()) {
		echo "Error enviando: " . $mail->ErrorInfo;
	} else {
		echo $ok_text;
	};
	$mail->clearAddresses();

	if ($existe->rowCount()){
		$mail->clearAddresses();

		$mail->Subject = "Nueva Solicitud de Registro";
		$mail->AltBody = $altbody_notif; 
		// si el cuerpo del mensaje es HTML
		$mail->MsgHTML($html_body_notif);

		// podemos hacer varios AddAdress
		$mail->AddAddress($mails_v['email'], $mails_v['realname']);
		if($mails_v['email2']!=''){
			$mail->AddAddress($mails_v['email2'], $mails_v['realname']);
		};
		if(!$mail->Send()) {
			echo "Error enviando: " . $mail->ErrorInfo;
		};
	};
/*	}else{echo $html_body.'<br>'.$ok_text;};*/
};

//echo $sql;
$db=null;
?>
</body>
</html>
	


