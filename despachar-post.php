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
	require('maneja-archivos.php');
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
		//echo 'ataque';
		//header("Location: http://regprof.inpc.gob.ec
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
         <SCRIPT LANGUAGE="JavaScript1.2" >
			function reload_(){
				window.parent.document.getElementById('dbx<?php echo $_POST['us_maneja']?>').submit();
//				window.parent.cher.action='director-gui.php';
//				window.parent.cher.submit();
				
			};
         </SCRIPT>
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
		$file=$file_prefix.$_POST['idpost'].'.pdf';
		
#		$sql_act_post="UPDATE Postulacion SET PostulacionAprobado='".$resp['InformeTecnicoRecomendacion']."', PostulacionFechaD=concat(CURDATE(),' ',CURTIME()) WHERE idPostulacion=".$_POST['idpost']."";
		$sql_act_post="UPDATE Postulacion SET PostulacionEstado=1, PostulacionFechaF=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00') WHERE idPostulacion=".$_POST['idpost']."";
		$stmtpos = $db->prepare($sql_act_post);
		if(isset($_POST['res_post']) and $_POST['res_post']=='aprobada'){
			$negativa='';
			$get_sql_registro=$db->query("SELECT DISTINCTrow t2.ProfesionalApellidos,t2.ProfesionalNombres,t2.ProfesionalGenero,t2.ProfesionalDireccion,t5.CiudadrNombre,t3.PaisrNombre,t2.ProfesionalTlfFijo,t2.ProfesionalTlfMovil,t2.ProfesionalMail,t2.ProfesionalMail2,t4.InformeTecnicoCodPro, t2.ProfesionalRestSinT FROM Postulacion as t0 left OUTER join Profesiones as t1 on t0.Profesiones_idProfesiones =t1.idProfesiones left OUTER join Profesional as t2 on t1.Profesional_idProfesional=t2.idProfesional left OUTER join Paisr as t3 on t2.Ciudadr_Paisr_idPaisr=t3.idPaisr left OUTER join InformeTecnico as t4 on t0.idPostulacion=t4.Postulacion_idPostulacion left OUTER join Ciudadr as t5 on t2.Ciudadr_idCiudadr=t5.idCiudadr left OUTER join SolicitudRespuesta as t6 on t0.idPostulacion=t6.Postulacion_idPostulacion WHERE t2.idProfesional='".$_POST['idprof']."'");
			$get_registro=$get_sql_registro->fetch(PDO::FETCH_ASSOC);
			//INICIO MIGRACION , REPGUNTO SI YA TIENE REGISTRO
			$pre_reg="SELECT RegistroPCodigo FROM RegistroP WHERE Profesional_idProfesional='".$_POST['idprof']."' and RegistroPProfesionalID=".$_POST['us_maneja'];
			$pre_reg_=$db->query($pre_reg);
			if($pre_reg_->rowCount()==0){//SI NO TIENE REGISTRO ES PROCESO NORMAL Y SE INSERTA EL NUEVO REGISTRO
				$sql_registro="INSERT INTO RegistroP (RegistroPCodigo,RegistroPApellidos,RegistroPNombres,RegistroPGenero,RegistroPDireccion,RegistroPCiudadr,RegistroPPaisr,RegistroPTlfFijo,RegistroPTlfMovil,RegistroPMail,RegistroPMail2,Profesional_idProfesional,RegistroPProfesionalID,RegistroPFechaRegistro,RegistroPActivo, RegistroPSinT) VALUES	('".$get_registro['InformeTecnicoCodPro']."','".$get_registro['ProfesionalApellidos']."','".$get_registro['ProfesionalNombres']."','".format_cont_db('ProfesionalGenero',$get_registro['ProfesionalGenero'])."','".$get_registro['ProfesionalDireccion']."','".$get_registro['CiudadrNombre']."','".$get_registro['PaisrNombre']."','".$get_registro['ProfesionalTlfFijo']."','".$get_registro['ProfesionalTlfMovil']."','".$get_registro['ProfesionalMail']."','".$get_registro['ProfesionalMail2']."','".$_POST['idprof']."',".$_POST['us_maneja'].",CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),1,".$get_registro['ProfesionalRestSinT'].")";
			}else{// SI EXISTE REGISTRO ES MIGRACION ASI QUE SOLO SE ACTUALIZA FECHA DE HABILITACION Y REGISTRO ACTIVO
				$sql_registro="UPDATE RegistroP SET RegistroPFechaRegistro=CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'), RegistroPActivo=1, RegistroPSinT=".$get_registro['ProfesionalRestSinT']." WHERE RegistroPProfesionalID=".$_POST['us_maneja']." and Profesional_idProfesional ='".$_POST['idprof']."'";
			};
			//FIN MIGRACION , 
			$stmtreg = $db->prepare($sql_registro);
		}else{			//SI SE NIEGA LA SOLICITUD
			$get_adic_inf=$db->query("SELECT t1.InformeTecnicoObservacion, t2.SolicitudRespuestaResumen FROM InformeTecnico as t1, SolicitudRespuesta as t2 WHERE t1.Postulacion_idPostulacion=".$_POST['idpost']." and t2.Postulacion_idPostulacion=".$_POST['idpost']);
			$adic_inf=$get_adic_inf->fetch(PDO::FETCH_ASSOC);
			$negativa=utf8_decode(utf8_encode("<br><br>Resumen Informe:<br>".$adic_inf['InformeTecnicoObservacion']."<br><br>Resumen Oficio Respuesta:<br>".$adic_inf['SolicitudRespuestaResumen']."<br><br>"));
		};
		$get_mail_profesional = $db->query(" SELECT ProfesionalNombres,ProfesionalApellidos,ProfesionalMail,ProfesionalMail2 FROM Profesional WHERE idProfesional='".$_POST['idprof']."' ");
		if ($get_mail_profesional->rowCount()){
			$mails= $get_mail_profesional->fetch(PDO::FETCH_ASSOC);
		}else{
			 "<html><body><script>alert('Imposible remitir,no se encuentra datos del Profesional');
						document.body.innerHTML += \"<form id='redir' action='director-gui.php' method='post'></form>\";
						document.getElementById('redir').submit();</script></body></html>";
			exit;
		};
	};
	if (isset($_POST['cod_pro']) and $_POST['cod_pro']!=''){
		$txt_cod="su código de registro es: ".$_POST['cod_pro']."\n";
		$html_cod="su c&oacute;digo de registro es: ".$_POST['cod_pro']."<br>";
#		$html_dblink='Revise su registro en la <a href="http://regprof.inpc.gob.ec/browse-db-gui.php" target="rpc-inpc">BASE DE DATOS DE PROFESIONALES INPC</a>';
#		$txt_dblink='Revise su registrio en la BASE DE DATOS DE PROFESIONALES INPC : http://regprof.inpc.gob.ec/browse-db-gui.php';
		$html_dblink='Revise su registro en la <a href="http://'.$_SERVER['SERVER_NAME'].'/print-cert.php?profes='.$_POST['us_maneja'].'&cod='.urlencode($_POST['cod_pro']).'&prof_='.urlencode($_POST['idprof']).'&noses=1" target="rpc-inpc">BASE DE DATOS DE PROFESIONALES INPC</a>';
		$txt_dblink='Revise su registrio en la BASE DE DATOS DE PROFESIONALES INPC : http://'.$_SERVER['SERVER_NAME'].'/print-cert.php?profes='.$_POST['us_maneja'].'&cod='.urlencode($_POST['cod_pro']).'&prof_='.urlencode($_POST['idprof']).'&noses=1';
		$nega_html_link='';
		$nega_txt_link='';
	}else{
		$html_cod=$negativa;
		$txt_cod=str_replace('<br>',"\n",$negativa);
		$html_dblink='';
		$txt_dblink='';
		$nega_html_link="Para conocer m&aacute;s acerca de esta disposici&oacute;n, descargue <b><a style='color: black;' href='http://".$_SERVER['SERVER_NAME']."/storage/".$file."' target='new'>Oficio de Respuesta</a></b> <BR>";
		$nega_txt_link="Para conocer más acerca de esta disposición, descargue Oficio de Respuesta http://".$_SERVER['SERVER_NAME']."/storage/".$file." \n";
	};
	$txt_cod=utf8_decode($txt_cod);
#exit;
try {
		$db->beginTransaction();
		if(isset($stmt)){$stmt->execute();};
		if(isset($stmtpos)){$stmtpos->execute();};
		if(isset($_POST['res_post']) and $_POST['res_post']=='aprobada'){
			if(isset($stmtreg)){$stmtreg->execute();};
		};
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
	Estimado(a)<B> ".$mails['ProfesionalNombres'].' '.$mails['ProfesionalApellidos']." </B>:<BR><BR>
	 Su solicitud para registro en la base de datos de profesionales ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])." del INPC ha sido <b>".strtoupper($_POST['res_post'])."</b><BR><BR>
	 ".$html_cod." ".$html_dblink." ".$nega_html_link;
	$html_body.=$footer_html;
	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
#$txtoretirado="	<A HREF='http://regprof.inpc.gob.ec/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR>";
	 $altbody="
	Estimado(a) ".$mails['ProfesionalNombres'].' '.$mails['ProfesionalApellidos']." :\n\n
	Su solicitud para registro en la base de datos de profesionales ".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])." del INPC ha sido ".strtoupper($_POST['res_post']).". \n\n
	 ".$txt_cod." ".$txt_dblink." ".$nega_txt_link;
	$altbody.=$footer_text;
	$altbody=utf8_decode($altbody);

	//envio de notifiacion
	// asunto y cuerpo alternativo del mensaje
	$subj=utf8_decode("Respuesta a la solicitud de Registro de Profesionales");
	$mail->Subject = $subj;
	$mail->AltBody = $altbody; 
	// si el cuerpo del mensaje es HTML
	$mail->MsgHTML($html_body);

	// podemos hacer varios AddAdress
	$mail->AddAddress($mails['ProfesionalMail'], $mails['ProfesionalNombres'].' '.$mails['ProfesionalApellidos']);
	$coma='';
	if(isset($mails) and $mails['ProfesionalMail2']!=''){
	$mail->AddAddress($mails['ProfesionalMail2'], $mails['ProfesionalNombres'].' '.$mails['ProfesionalApellidos']);
	$coma=', ';
	};
	// fin envio notificacion
	$ok_text="
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
	<font size='+1'>
	 Se ha despach&oacute; exitosamente la respuesta a la solicitud de registro profesional para ingresar en la Base de Datos:&nbsp; <B>".format_cont_db('TipoProfesionalId', $_POST['us_maneja'])."</B>
	 del/la Sr./Sra.: <b>  ".$mails['ProfesionalNombres'].' '.$mails['ProfesionalApellidos']." </b> a las direcciones de correo especificada(s) : <strong>".$mails['ProfesionalMail'].", ".$mails['ProfesionalMail2']."</strong>.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'class='tobut'><FORM name='fr' method='POST' action='director-gui-xdespachar.php'>
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
exit;
?>
