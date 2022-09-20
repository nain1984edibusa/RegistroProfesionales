<?php
		ini_set('display_errors', 1);
	error_reporting(E_ALL);

	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require ('class/aes.class.php');     // AES PHP implementation
	require ('class/aesctr.class.php');  // AES Counter Mode implementation 
	require('class/format_db_content.php');
	require_once ("PHPMailer/mailer.php");
	require('footer-mail.php');

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
#phpinfo();


//INGRESO DE USUARIOS PRE-REGISTRADOS


	$sql="INSERT INTO Profesional";   //CREO REGISTRO DE PROFESIONAL POSTULANTE
	$sql.=" (idProfesional,ProfesionalNombres,ProfesionalApellidos,ProfesionalFecNacim,ProfesionalTlfmovil,ProfesionalTlfFijo,ProfesionalDireccion,ProfesionalMail,ProfesionalMail2,TipoDocID_idTipoDocID,Nacionalidad_idNacionalidad,Ciudadr_idCiudadr,Ciudadr_Paisr_idPaisr, ProfesionalActualizo, ProfesionalLastActu,ProfesionalEspec )";
	$sql.=" VALUES ('QH569820','Laurie Anne','Beckwith','0000-00-00','1 6045275400','especificar','Douglas College Po. Box 2503New Westminster BC Canada V3L 5B2','1beckwith@douglascollege.ca','',1,'US',145404,'US',0,'0000-00-00 00:00:00','A')";
#$res=$db->query($sql);

	$sql_us="INSERT INTO user";   //CREO REGISTRO DE USUARIO EXTERNO
	$sql_us.=" (username,realname,password,email,email2,userEstado,userTokenReg,TipoUsuario_idTipoUsuario)";
	$sql_us.=" VALUES ('QH569820','Laurie Anne Beckwith','generar','1beckwith@douglascollege.ca','',0,'generar',3)";
#$res=$db->query($sql_us);

						   //CREO REGISTRO DE PROFESIONAL PARA LA BASE DE DATOS PUBLICA, (DESHABILITADO MIENTRAS NO PASE EL TRAMITE)
	$sql_registro="INSERT INTO RegistroP (RegistroPCodigo,RegistroPApellidos,RegistroPNombres,RegistroPGenero,RegistroPDireccion,RegistroPCiudadr,RegistroPPaisr,RegistroPTlfFijo,RegistroPTlfMovil,RegistroPMail,RegistroPMail2,Profesional_idProfesional,RegistroPProfesionalID,RegistroPFechaRegistro,RegistroPActivo, RegistroPSinT)";
	$sql_registro.="VALUES	('Arqueo-091','Beckwith','Laurie Anne','F','especificar','Canada','US','especificar','especificar','1beckwith@douglascollege.ca','','QH569820',1,'2015-01-01 00:00:00',0,0)";
#$res=$db->query($sql_registro);

 $sql_titulo="INSERT into `regprof`.`FAcademica` (FAcademicaNivel, FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado, FAcademicaCSenescyt, Profesional_idProfesional,FAcademicaTituloValido,FAcademicaTituloUsado ) VALUES (3,  'especificar', 'especificar', '0000-00-00',  '1-actualice-QH569820','QH569820',1,1)";
#$res=$db->query($sql_titulo);

#echo $sql5med="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES (1, '1721648184')"; //INGRESO PROFESION 
#echo '<br>';
#echo $sql6="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones) VALUES ('2015-05-11 13:25:37',558)"; //INGRESO POSTULACION
#echo '<br>';

#$res1=$db->query($sql1);
#$res2=$db->query($sql2);
#$res3=$db->query($sql3);
#$res4=$db->query($sql4);
#$res5=$db->query($sql5);
#$res5=$db->query($sql5med);
#$res6=$db->query($sql6);

				$html_body="
					<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
					  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
					  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
					<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
					Estimado(a)<B> Director Conservación </B>:<BR><BR>El/la Profesional <b>Valeria Estefanía Suarez Caymayo</b> ingres&oacute; una solicitud  
					para registrarse en la Base de Datos de Profesionales :&nbsp; <B>Arqueólogo(a) y Paleontólogo(a)	</B><BR><BR>
					Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
					<A HREF='http://".$_SERVER['SERVER_NAME']."/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
				$html_body.=$footer_html;
#echo				$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
				$mail->Subject = "Nueva Solicitud de Registro";
				$mail->MsgHTML($html_body);
				$mail->AddAddress("direccion.conservacion@inpc.gob.ec", "Dirección de Conservación");
#					if(!$mail->Send()) {
#						echo "Error enviando: " . $mail->ErrorInfo;
#					};


echo 'ejecucion terminada';
//INGRESO DE USUARIOS PRE-REGISTRADOS
exit;



#echo $sql="UPDATE `regprof`.`RegistroP` SET `RegistroPDireccion` = 'Cesar Andrade y Cordero y Ordoñez Lasso (sector San José de Balzay)', `RegistroPTlfFijo` = '0724185871', `RegistroPTlfMovil` = '0998053703', `RegistroPMail2` = '' WHERE `RegistroP`.`idRegistroP` = 1494 and Profesional_idProfesional='0101601904'";
#echo $sql="UPDATE `regprof`.`Profesional` SET  `ProfesionalTlfmovil` = '0998053703', `ProfesionalTlfFijo` = '0724185871', `ProfesionalDireccion` = 'Cesar Andrade y Cordero y Ordoñez Lasso (sector San José de Balzay)', `ProfesionalMail2` = '', `ProfesionalActualizo` = '1', `ProfesionalLastActu` = '2015-01-21 22:11:38' WHERE `Profesional`.`idProfesional` = '0101601904'";
#echo $sql="UPDATE `regprof`.`FAcademica` SET FAcademicaNivel=4, `FAcademicaNTitulo` = 'MAESTRO EN ARQUEOLOGIA', `FAcademicaInstitucion` = 'EL COLEGIO DE MICHOACAN, A.C. ', `FAcademicaFecGrado` = '2007-08-07', `FAcademicaCSenescyt` = '5779R-12-12613 ' WHERE `FAcademica`.`idFAcademica` = 95";
#exit;
#	$post_en_proceso = $db->query("select * from Postulacion where Profesiones_idProfesiones in (select idProfesiones from Profesiones where TipoProfesional_TipoProfesionalId=".$_GET['TipoProfesionalId']." and Profesional_idProfesional='".$_GET['docid']."')");
#	while($row = $post_en_proceso->fetch(PDO::FETCH_ASSOC)) {
#		if($row['PostulacionFechaI']!='' and $row['PostulacionFechaF']==''){
#	 $ok_text="
#		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
#		<font size='+1'>
#		Estimado(a) Se&ntilde;or(a):  <strong><em>".$_POST['name'].' '.$_POST['lname']."<br><br></em></strong><br>
#		Usted ya posee registro como: <strong><em>".$stp['TipoprofesionalNombre']."</em></strong><br><br>
#		Su registro esta en proceso de migraci&oacute;n a la base de datos en l&iacute;nea, La Direcci&oacute;n de Conservaci&oacute;n indicar&aacute; el procedimiento para actualizaci&oacute;n de sus datos 
#		en los proximos d&iacute;as<br></font></td></tr></table><br><br><br>
#		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='index.php' method='POST'>
#		  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
#		</FORM></td></tr></table>
#	";
#	$html_cod="su c&oacute;digo de registro es: Arqueo-119 <br>";
#	$html_dblink='Revise su registro en la <a href="http://regprof.inpc.gob.ec/print-cert.php?profes=1&cod='.urlencode('Arqueo-119').'&prof_='.urlencode('1714350764').'&noses=1" target="rpc-inpc">BASE DE DATOS DE PROFESIONALES INPC</a>';
#	$html_body= $html_cod.$html_dblink;
#	if(!$mail->Send()) {
#		echo "Error enviando: " . $mail->ErrorInfo;
#	} else {
#		echo $ok_text;
#	};

#	 $ok_text="
#		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
#		<font size='+1'>
#		Estimado(a) Se&ntilde;or(a):  <strong><em>".format_cont_db('idProfesional',$_GET['docid'])."<br><br></em></strong><br>
#		Usted ya posee solicitudes de registro como: <strong><em>".format_cont_db('TipoProfesionalId',$_GET['TipoProfesionalId'])."</em></strong> en proceso<br><br>
#		Puede dar seguimiento a las mismas ingresando a su cuenta de usuario.<br></font></td></tr></table><br><br><br>
#		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='log-im.php' method='POST'>
#		  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
#		</FORM></td></tr></table>
#	";
# $ok_text;
#	$altbody="Estimado(a) Señor(a): ".$_POST['name']." ".$_POST['lname']." :\nUsted ya posee registro como: ".$stp['TipoprofesionalNombre']."\n\n
#	".$stp['TipoprofesionalNombre']." del INPC  \n\n
#	Su registro esta en proceso de migración a la base de datos en línea, La Dirección de Conservación indicará el procedimiento para actualización de sus datos 
#	en los proximos días\n\n";
#	$altbody.=$footer_text;
#	 $altbody=utf8_decode($altbody);

#};
/*
include ("footer-mail.php");
exit;
function CallAPI($method, $url, $data = false){
    $curl = curl_init();

    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt($curl, CURLOPT_USERPWD, "INPC:20r3gpr0f141nPc");
	curl_setopt($curl, CURLOPT_SSLVERSION,3);			//ESTABLECIMIENTO DE PARAMETROS DE PROTOCOLO HTPPS
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);			//ESTABLECIMIENTO DE PARAMETROS DE PROTOCOLO HTPPS 
	curl_setopt($curl, CURLOPT_HEADER, false); 			//PERMITE MOSTRAR ENCABEZADO DE RESPUESTA CON INFORMACION DEL SERVICIO
    curl_setopt($curl, CURLOPT_URL, $url);			//SETEA LA URL DE CONSULTA
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			//INDICA QUE LA RESPUESTA SE RECIBE COMO UNA VARIABLE. NO SE VUELCA EN EL BROWSER

    $result = curl_exec($curl);			//EJECUTA URL DE CONSULTA Y ALMACENA LOS DATOS EN RESULT
    curl_close($curl);			//TERMINA LA SESION 
    return $result;
};
#$sql="update TipoProfesional set TipoProfesionalNombre ='Arqueólogo(a) y Paleontólogo(a)' where TipoProfesionalId=1";
#$stmt = $db->prepare(utf8_decode($sql));
#$stmt->execute();


#echo utf8_decode($footer_html);
#echo '<br>';
#echo utf8_decode(utf8_encode($footer_text));
#echo '<br>';

exit;

$data=NULL;
#$datos = CallAPI('GET','https://www.datoseguro.gob.ec/ws/rest/relacionconfianza/publico/?_wadl',$data);
#$json = CallAPI('GET','https://www.datoseguro.gob.ec/ws/rest/relacionconfianza/publico/rpINPC/1002071965/vigencia',$data);
$json='{"DatosTramite":{"NombreIRC":"rpINPC","InformacionCivil":[{"NombreCampo":"CEDULA","Valor":"0602908170"},{"NombreCampo":"NOMBRE","Valor":"CAMACHO YEROVI IVAN PATRICIO"},{"NombreCampo":"GENERO","Valor":"MASCULINO"},{"NombreCampo":"FECHANACIMIENTO","Valor":"06\/08\/1978"},{"NombreCampo":"LUGARNACIMIENTO","Valor":"PICHINCHA\/QUITO\/SAN BLAS"},{"NombreCampo":"NACIONALIDAD","Valor":"ECUATORIANA"}],"InformacionSenescyt":{"NivelTitulo":[{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"null "},{"NombreCampo":"IES","Valor":"ESCUELA SUPERIOR POLITECNICA DE CHIMBORAZO"},{"NombreCampo":"NOMBRETITULO","Valor":"TECNOLOGO EN INFORMATICA APLICADA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1002-03-389101"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Nivel Técnico o Tecnológico Superior"}}},{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"Thu May 16 00:00:00 ECT 2013 "},{"NombreCampo":"IES","Valor":"UNIVERSIDAD TECNOLOGICA AMERICA"},{"NombreCampo":"NOMBRETITULO","Valor":"ECUATORIANA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1043-13-1283"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Tercer Nivel Nacionales"}}}]}}}';
#$json='{"DatosTramite":{"NombreIRC":"rpINPC","InformacionCivil":[{"NombreCampo":"CEDULA","Valor":1720941036},{"NombreCampo":"NOMBRE","Valor":"JARAMILLO VALDEZ KARINA VANESSA"},{"NombreCampo":"GENERO","Valor":"FEMENINO"},{"NombreCampo":"FECHANACIMIENTO","Valor":"30\/12\/1985"},{"NombreCampo":"LUGARNACIMIENTO","Valor":"PICHINCHA\/QUITO\/SANTA PRISCA"},{"NombreCampo":"NACIONALIDAD","Valor":"ECUATORIANA"}],"InformacionSenescyt":{"NivelTitulo":{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"Fri Jun 17 00:00:00 ECT 2011 "},{"NombreCampo":"IES","Valor":"ESCUELA SUPERIOR POLITECNICA DE CHIMBORAZO"},{"NombreCampo":"NOMBRETITULO","Valor":"LICENCIADA EN DISEÑO GRAFICO"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1002-11-1079269"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Tercer Nivel Nacionales"}}}}}}';
#$json='java.lang.NullPointerException';
$datoseguro=json_decode($json);

if ($json!='java.lang.NullPointerException'){		//SI DEVUELVE DATOS, ES DECIR SI LA PERSONA EXISTE EN EL REGISTRO DE DATO SEGURO
	echo 'DATOS REGISTRO CIVIL:<BR>';

	foreach ($datoseguro->DatosTramite->InformacionCivil as $registro) {
		echo '<b>'.$registro->NombreCampo . ':</b> '.$registro->Valor.'<br>';
	}

	echo '<hr><br>DATOS SENESCYT:<BR>';
	if (is_array($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo )){		//si uno o mas titulos
		foreach ($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo as $niveltitulo) {
			foreach($niveltitulo->Titulos->Titulo as $titulo){
				echo '<b>'.$titulo->NombreCampo . ':</b> ';
				if(isset($titulo->Valor)){echo $titulo->Valor.'<br>';};
			};
			echo '<br>Descripcion:<br>';
				echo '<b>'.$niveltitulo->Titulos->Descripcion->NombreCampo . ':</b> ';
				if(isset($niveltitulo->Titulos->Descripcion->Valor)){echo $niveltitulo->Titulos->Descripcion->Valor.'<br>';};
			echo '<hr>';
		}
	}

	if (is_object($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo )){		//si un solo titulo
		foreach($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Titulo as $titulo){
			echo '<b>'.$titulo->NombreCampo . ':</b> ';
			if(isset($titulo->Valor)){echo $titulo->Valor.'<br>';};
		};
		echo '<br>Descripcion:<br>';
			echo '<b>'.$datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Descripcion->NombreCampo . ':</b> ';
			if(isset($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Descripcion->Valor)){echo $datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Descripcion->Valor.'<br>';};
		echo '<hr>';
	}
}else{
	echo 'No existen datos en INFODIGITAL';
}

/*foreach ($datoseguro as $name => $value) {
    echo 'nivel1'.$name . ':';
    $typeof= gettype($value);
    if($typeof!='object'){echo $value.'<br>';};
    if ($typeof=='object'){
		echo '<br>&nbsp;nivel2';
	    foreach ($value as $name2 => $value2) {
			echo '<br>&nbsp;&nbsp;'.$name2 . ':';
			$typeof2= gettype($value2);
		    if($typeof2!='object'){echo $value2.'<br>';};
			
	    }
	};
}*/

#print($datos);

#print_r($datoseguro);



#HTTP/1.1 200 OK
#Content-Type: application/json
#Date: Thu, 25 Sep 2014 13:52:37 GMT
#Connection: close
#Server: Jetty(7.5.4.v20111024)

#{"DatosTramite":{"NombreIRC":"rpINPC","InformacionCivil":[{"NombreCampo":"CEDULA","Valor":"0602908170"},{"NombreCampo":"NOMBRE","Valor":"CAMACHO YEROVI IVAN PATRICIO"},{"NombreCampo":"GENERO","Valor":"MASCULINO"},{"NombreCampo":"FECHANACIMIENTO","Valor":"06\/08\/1978"},{"NombreCampo":"LUGARNACIMIENTO","Valor":"PICHINCHA\/QUITO\/SAN BLAS"},{"NombreCampo":"NACIONALIDAD","Valor":"ECUATORIANA"}],"InformacionSenescyt":{"NivelTitulo":[{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"null "},{"NombreCampo":"IES","Valor":"ESCUELA SUPERIOR POLITECNICA DE CHIMBORAZO"},{"NombreCampo":"NOMBRETITULO","Valor":"TECNOLOGO EN INFORMATICA APLICADA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1002-03-389101"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Nivel Técnico o Tecnológico Superior"}}},{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"Thu May 16 00:00:00 ECT 2013 "},{"NombreCampo":"IES","Valor":"UNIVERSIDAD TECNOLOGICA AMERICA"},{"NombreCampo":"NOMBRETITULO","Valor":"ECUATORIANA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1043-13-1283"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Tercer Nivel Nacionales"}}}]}}}




 # arreglo de postulacion de Alfredo Santamaría
 
# echo $sql1="UPDATE user SET email='alfredo.santamaria5@hotmail.com', email2='' WHERE username ='1705250916'";
#echo '<br>';
#echo $sql2="UPDATE Profesional SET ProfesionalMail='alfredo.santamaria5@hotmail.com',ProfesionalMail2='', ProfesionalTlfmovil='0998651152', ProfesionalActualizo=1, ProfesionalLastActu='2015-05-07 16:10:25'  WHERE idProfesional ='1705250916'";
#echo '<br>';
#echo $sql3="UPDATE RegistroP SET RegistroPMail='alfredo.santamaria5@hotmail.com', RegistroPMail2='', RegistroPTlfMovil='0998651152'  WHERE Profesional_idProfesional ='1705250916'";
#echo '<br>';
#echo $sql4="UPDATE FAcademica SET FAcademicaFecGrado='2006-06-27'  WHERE idFAcademica =72";
#echo '<br>';
#echo $sql5="INSERT into `regprof`.`FAcademica` (FAcademicaNivel, FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado, FAcademicaCSenescyt, Profesional_idProfesional,FAcademicaTituloValido,FAcademicaTituloUsado ) VALUES (4,  'MAGISTER EN ARQUEOLOGIA E IDENTIDAD NACIONAL', 'UNIVERSIDAD CENTRAL DEL ECUADOR', '2009-03-05',  '1005-09-689490','1705250916',1,1)";
#echo '<br>';
#echo $sql5med="INSERT INTO Profesiones (TipoProfesional_TipoProfesionalId,Profesional_idProfesional)  VALUES ("1, '1721648184')"; //INGRESO PROFESION 
#echo '<br>';
#echo $sql6="INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones) VALUES ('2015-05-07 16:10:25',31)"; //INGRESO POSTULACION
#echo '<br>';

##$res1=$db->query($sql1);
##$res2=$db->query($sql2);
##$res3=$db->query($sql3);
##$res4=$db->query($sql4);
##$res5=$db->query($sql5);
##$res5=$db->query($sql5med);
##$res6=$db->query($sql6);

#				$html_body="
#					<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
#					  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
#					  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
#					<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
#					Estimado(a)<B> Director Conservación </B>:<BR><BR>El/la Profesional <b>Alfredo José Santamaría Alvarez</b> ingres&oacute; una solicitud  
#					para registrarse en la Base de Datos de Profesionales :&nbsp; <B>Restaurador(a) de Bienes Culturales Patrimoniales Muebles y Museos	</B><BR><BR>
#					Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
#					<A HREF='http://regprof.inpc.gob.ec/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
#				$html_body.=$footer_html;
#echo				$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
#				$mail->Subject = "Nueva Solicitud de Registro";
#				$mail->MsgHTML($html_body);
#				$mail->AddAddress("direccion.conservacion@inpc.gob.ec", "Dirección de Conservación");
##					if(!$mail->Send()) {
##						echo "Error enviando: " . $mail->ErrorInfo;
##					};









?>


