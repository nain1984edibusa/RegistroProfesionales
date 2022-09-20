<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
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

#	$stpro = $db->query("SELECT TipoprofesionalNombre FROM TipoProfesional WHERE TipoProfesionalId ='".$_POST['TipoProfesionalId']."'");	
#	if ($stpro->rowCount()>0){$stp= $stpro->fetch(PDO::FETCH_ASSOC);};

$existe= $db->query("SELECT * FROM user WHERE username='".$_POST['us_']."' and (email='".$_POST['mail']."' or email2='".$_POST['mail']."')");
if ($existe->rowCount()){
	$datos= $existe->fetch(PDO::FETCH_ASSOC);
	if($datos['userEstado']){
		$tmp_token=token_gen();
		$sql_us="UPDATE user SET userTokenReg='".$tmp_token."' WHERE username='".$datos['username']."'";
		$stmt = $db->prepare($sql_us);
	}else{
		$ok_text="
			<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
			<font size='+1'>
			Estimado(a) Se&ntilde;or(a):  <strong><em>".$datos['realname']."<br><br></em></strong><br>
			Usted ya posee una cuenta en el servicio de Registro de Profesionales, pero esta inhabilitada<br>
			Comunicarse a info.rpc@inpc.gob.ec para soluciones<br>
			</font></td></tr></table><br><br><br>
			<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='index.php' method='POST'>
			  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
			</FORM></td></tr></table>
		";
		echo $ok_text;
	};
}else{
	$ok_text="
		<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
		<font size='+1'>
		Estimado(a) Usuario(a): 
		El par 'nombre de usuario' -- 'email' no coinciden.<br>
		Para poder restablecer su contrase&ntilde;a su identidad debe verificarse con &eacute;xito.<br><br>
		</font></td></tr></table><br><br><br>
		<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='log-im.php' method='POST'>
		  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
		</FORM></td></tr></table>
	";
	echo $ok_text;
	exit;
};

try {
	$db->beginTransaction();
	if(isset($sql_us)){$stmt->execute();};
	$db->commit();
} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
if (!isset($ex)){  // si se actualizaron los registros......
$html_body="
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>
	<HTML>
	<HEAD>
	  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
	  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>
	</HEAD>
	<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
	Estimado(a) Se&ntilde;or(a):<B> ".$datos['realname']." </B>:<BR><BR>
	Solicit&oacute; restablecer su contrase&ntilde;a en el SERVICIO DE REGISTRO DE PROFESIONALES del INPC <BR><BR>
	Para completar este proceso ingrese al siguiente enlace y confirme su nueva contrase&ntilde;a :<BR>
	<A HREF='http://".$_SERVER['SERVER_NAME']."/rest-c.php?token=".$tmp_token."'>Confirmaci&oacute;n de restablecimiento de contrase&ntilde;a</A><BR>
	<BR><BR>";
$html_body.=$footer_html;
$html_body.="<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

$altbody="
	Estimado(a) Señor(a): ".$datos['realname']." :\n
	Solicitó restablecer su contraseña en el SERVICIO DE REGISTRO DE PROFESIONALES del INPC \n\n
	Para completar este proceso ingrese al siguiente enlace y confirme su nueva contraseña :\n
	Enlace de restablecimiento de contraseña (copie el enlace y péguelo en la barra de direcciones de su navegador): http://".$_SERVER['SERVER_NAME']."/rest-c.php&?oken=".$tmp_token."\n\n\n";
$altbody.=$footer_text;
$altbody=utf8_decode($altbody);
//envio de notifiacion
// asunto y cuerpo alternativo del mensaje
$subj= utf8_decode("Restablecimiento de Contraseña ");
$mail->Subject = $subj;
$mail->AltBody = $altbody; 
// si el cuerpo del mensaje es HTML
$mail->MsgHTML($html_body);

// podemos hacer varios AddAdress
$mail->AddAddress($datos['email'], $datos['realname']);
if($datos['email2']!=''){
$mail->AddAddress($datos['email2'], $datos['realname']);
};
// fin envio notificacion
$ok_text="
	<table align='center' border='0' width='70%' cellpadding='10'><tr><td class='literatura2'><center><h3>REGISTRO DE PROFESIONALES </h3></center>
	<font size='+1'>
	Estimado(a) Se&ntilde;or(a):  <strong><em>".$datos['realname']."<br><br></em></strong><br>
	Revise su(s) cuenta(s) de correo registrada(s), se ha envia&oacute; a la(s) misma(s) instrucciones para el restablecimiento de la contrase&ntilde;a.
	</font></td></tr></table><br><br><br>
	<table align='center' border='0'><tr><td align='center'class='tobut'><FORM action='log-im.php' method='POST'>
	  &nbsp;&nbsp;<INPUT type='submit' name='ok' value='Aceptar' size='10'>&nbsp;&nbsp;
	</FORM></td></tr></table>
";

	if(!$mail->Send()) {
		echo "Error enviando: " . $mail->ErrorInfo;
	} else {
		echo $ok_text;
	};
};
//echo $sql;
$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>

	


