<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/format_db_content.php');
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
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
//				window.opener.parent.document.cher.target='_self';
//				window.opener.parent.cher.action='admin-gui.php';
				window.opener.parent.cher.target='_self';
				window.opener.parent.cher.action='admin-gui.php';
				window.opener.parent.cher.submit();
			};
         </SCRIPT>
<?php
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

if(isset($_POST['ex1']) and isset($_POST['ex2']) and $_POST['ex1'] and !$_POST['ex2']){
	$tmp_pwd=pwd_gen();
	$tmp_token=token_gen();
	$sql_us="INSERT INTO user";
	$sql_us.=" (username,realname,password,email,email2,userEstado,userTokenReg,TipoUsuario_idTipoUsuario)";
	$sql_us.=" VALUES ('".$_POST['username']."','".$_POST['rname']."',password('".$tmp_pwd."'),'".$_POST['mail']."','".$_POST['mail2']."',0,'".$tmp_token."','".$_POST['TipoUsuario_idTipoUsuario']."')";
};
if(isset($_POST['ex1']) and isset($_POST['ex2']) and !$_POST['ex1'] and $_POST['ex2']){
	$sql_us="UPDATE user SET realname='".$_POST['realn']."', email='".$_POST['email']."', email2='".$_POST['email2']."', userEstado=".$_POST['estado']." WHERE username='".$_POST['usrn']."'";
};

try {
	$db->beginTransaction();
#	$stmt = $db->prepare($sql);
	$stmtus = $db->prepare($sql_us);
#	if(isset($stmt)){$stmt->execute();};
	if(isset($stmtus)){$stmtus->execute();};
#	if(isset($stmt1)){$stmt1->execute();};
	$db->commit();

} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};

//exit;
if (!isset($ex)){  // si se insertaron los registros......
	if(isset($_POST['ex1']) and isset($_POST['ex2']) and $_POST['ex1'] and !$_POST['ex2']){
		$html_body="
		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
		<HTML>
		<HEAD>
		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
		</HEAD>
		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
		Estimado(a)<B> ".ucfirst($_POST['rname'])." </B>:<BR><BR>
		 Se cre&oacute; la cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])."<BR><BR>
		Nombre de usuario:&nbsp; <B>".$_POST['username']."</B><BR>
		Clave Temporal:&nbsp;&nbsp;&nbsp; <B>".$tmp_pwd."</B><BR><BR>
		Por favor confirme la activaci&oacute;n de su cuenta de usuario, cambiando su clave temporal <BR><BR>
		<A HREF='http://".$_SERVER['SERVER_NAME']."/confirmap.php?token=".$tmp_token."'>Confirmaci&oacute;n de creaci&oacute;n de cuenta de usuario</A><BR>
		<BR><BR>
		";
	$html_body.=$footer_html;
	$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";


		$altbody="
		Estimado(a) ".ucfirst($_POST['rname'])." :\n
		Se creó la cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])."\n\n
		Cuenta de usuario:  ".$_POST['username']."\n
		Clave Temporal:    ".$tmp_pwd."\n\n
		Por favor confirme la activación de su cuenta de usuario, cambiando su clave temporal\n\n
		POr favor copie y pegue este enlace en la barra de direcciones de su navegador web (recomendados Chrome, Firefox, Opera)
		http://".$_SERVER['SERVER_NAME']."/confirmap.php?token=".$tmp_token."
		Confirmación de creación de cuenta de usuario aquí: http://".$_SERVER['SERVER_NAME']."/confirmap.php&?oken=".$tmp_token."\n\n\n
		Si no puede ver el enlace de confirmación, abra el archivo adjunto en formato html que debe constar con este correo";
		$altbody.=$footer_text;
		$altbody=utf8_decode($altbody);
		//envio de notifiacion
		// asunto y cuerpo alternativo del mensaje
		$subj=utf8_decode("Creación cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario']));
		$mail->Subject = $subj;
		$mail->AltBody = $altbody; 
		// si el cuerpo del mensaje es HTML
		$mail->MsgHTML($html_body);

		// podemos hacer varios AddAdress
		$coma='';
		$mail->AddAddress($_POST['mail'], $_POST['rname']);
		if(isset($_POST['mail2']) and $_POST['mail2']!=''){
			$coma=', ';
			$mail->AddAddress($_POST['mail2'], $_POST['rname']);
		};
		// fin envio notificacion
		$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>ADMINISTRACI&Oacute;N DE USUARIOS DEL SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Se cre&oacute; una cuenta de usuario: ".format_cont_db('idTipoUsuario',$_POST['TipoUsuario_idTipoUsuario'])."  <strong> username: <em>".$_POST['username']."<br><br></em></strong>
		<br>
		<br>
		Se envi&oacute; una confirmaci&oacute;n a la(s) cuenta(s) de correo especificada(s)  : <strong>".$_POST['mail'].$coma.$_POST['mail2'].",</strong> por favor, sino
	 visualiza la confirmaci&oacute;n, busque en la carpeta de correo no deseado (SPAM) la siguiente direcci&oacute;n <strong>info.rpc@inpc.gob.ec</strong>.<br>

	Confirme su solicitud y registro como usuario ingresando al enlace en el correo que recibir&aacute; y cambiando la clave temporal.
	
		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM  method='POST'>
		  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='reload_();window.close()'>&nbsp;&nbsp;
		</FORM></td></tr></table>
		";
	};
	if(isset($_POST['ex1']) and isset($_POST['ex2']) and !$_POST['ex1'] and $_POST['ex2']){
		$html_body="
		<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
		<HTML>
		<HEAD>
		  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
		  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
		</HEAD>
		<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
		Estimado(a)<B> ".ucfirst($_POST['realn'])." </B>:<BR><BR>
		 Se modificaron datos de su cuenta de usuario  ".$_POST['usrn']."<BR><BR>
		Nombre de usuario:&nbsp; <B>".$_POST['realn']."</B><BR>
		Correo Electronico:&nbsp;&nbsp;&nbsp; <B>".$_POST['email']."</B><BR>
		Correo Electronico 2:&nbsp;&nbsp;&nbsp; <B>".$_POST['email2']."</B><BR>
		Estado:&nbsp;&nbsp;&nbsp; <B>".format_cont_db('userEstado',$_POST['estado'])."</B><BR>";
		$html_body.=$footer_html;
		$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";
		
		$altbody="
		Estimado(a) ".ucfirst($_POST['realn'])." :\n
		 Se modificaron datos de su cuenta de usuario :".$_POST['usrn']."\n\n
		Nombre de usuario:&nbsp; ".$_POST['realn']."\n
		Correo Electronico:  ".$_POST['email']."\n
		Correo Electronico 2:  ".$_POST['email2']."\n
		Estado:  ".format_cont_db('userEstado',$_POST['estado'])."\n\n";
		$altbody.=$footer_text;
		$altbody=utf8_decode($altbody);
		
		//envio de notifiacion
		// asunto y cuerpo alternativo del mensaje
		$mail->Subject = "Cambios en cuenta de usuario ".$_POST['usrn'];
		$mail->AltBody = $altbody; 
		// si el cuerpo del mensaje es HTML
		$mail->MsgHTML($html_body);

		// podemos hacer varios AddAdress
		$coma='';
		$mail->AddAddress($_POST['email'], $_POST['realn']);
		if(isset($_POST['email2']) and $_POST['email2']!=''){
			$coma=', ';
			$mail->AddAddress($_POST['email2'], $_POST['realn']);
		};
		// fin envio notificacion
		$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>ADMINISTRACI&Oacute;N DE USUARIOS DEL SERVICIO DE REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Se modificaron datos la cuenta de usuario: <strong> <em>".$_POST['usrn']."<br><br></em></strong>
		 
		<br>
		<br>
		 Se envi&oacute; una notificaci&oacute;n de los cambios a la(s) cuenta(s) de correo especificada(s)  : <strong>".$_POST['email'].$coma.$_POST['email2'].",</strong><br>

		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM  method='POST'>
		  &nbsp;&nbsp;<INPUT type='button' name='ok' value='Aceptar' size='10' onClick='reload_();window.close()'>&nbsp;&nbsp;
		</FORM></td></tr></table>
		";
	};
	if(!$mail->Send()) {
		echo "Error enviando: " . $mail->ErrorInfo;
	} else {
		echo $ok_text;
	};

}else{
echo 'error en la insercion/actualizacion';
};
//echo $sql;
$db=null;
//exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>

