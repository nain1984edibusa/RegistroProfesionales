<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require('class/format_db_content.php');
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require ('class/aes.class.php');     // AES PHP implementation
	require ('class/aesctr.class.php');  // AES Counter Mode implementation 
	require_once ("PHPMailer/mailer.php");
	require('footer-mail.php');

	if($_SERVER['REQUEST_METHOD']!='POST'){
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		//header("Location: http://regprof.inpc.gob.ec/malll");
		exit;
	};
?>

<html>
<body style="background-image:url(image/loading.gif);background-repeat: no-repeat; background-position: center top;">
	<center>
		<!--<img src='image/loading.gif'><br>-->
		<br><br><br> <h3>CONECTANDO...y RESTABLECIENDO CONTRASE&Ntilde;A</h3>
		<br><br><br><br><br><br><br><br><br>
		<h3>POR FAVOR SEA PACIENTE MIENTRAS SE COMPLETA EL PROCESO</h3>
	</center>
<?php
	$clave_actual= AesCtr::decrypt($_POST['xx'], $_POST['x'], 256);
	if(isset($_POST['aa'])){ $npass=AesCtr::decrypt($_POST['aa'], $_POST['x'], 256);};
#	if (isset($_POST['tt']) and $_POST['tt']!=''){
#	   $token= AesCtr::decrypt($_POST['tt'], $_POST['x'], 256);
#	};
	$stmt = $db->query("SELECT password,realname,userEstado,userTokenReg FROM user WHERE username='".$_SESSION['user']."' and password = password('".$clave_actual."')");	
	if ($stmt->rowCount()>0){
		$us= $stmt->fetch(PDO::FETCH_ASSOC);
/*			if (isset($token) and $us['userEstado'] and $us['userTokenReg']==$token){*/
				$sql_act_user="UPDATE user SET password=password('".$npass."') WHERE username='".$_SESSION['user']."'";//activo la cuenta de usuario
				try {
				  $db->beginTransaction();
				  $stmt_au= $db->prepare($sql_act_user);
				  if(isset($stmt_au)){$stmt_au->execute();};
				  $db->commit();
				} catch(PDOException $ex) {
				  //Something went wrong rollback!
    			  $db->rollBack();
    			  echo $ex->getMessage();
				  exit;
				};
?>
			<script>alert('Cambio de clave exitoso, procure memorizar su clave');window.close();</script>
<?php
			exit;
/*		  }else{
			if (isset($token) ){
?>
		      <script>alert('Error: Enlace de restablecimiento incorrecto o ya usado');history.go(-1);</script>
<?php
				exit;
			};
	     };*/
	}else{
?>
	<script>alert('Clave actual no coincide!!');history.go(-1);
	/*document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
	document.getElementById("redir").submit();*/</script>
<?php
	};
$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
</body>
</html>
