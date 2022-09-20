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
		header("Location: index");
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
if($_POST['chkCalidad']!=0 || $_POST['chkTiempo']!=0 || $_POST['chkResultado']!=0){
	$sql_delete="delete from calificacionServicio where username ='".$_SESSION['user']."'";

	$sql_us="INSERT INTO calificacionServicio";
	$sql_us.=" (username,calidad,tiempo,resultado)";
	$sql_us.=" VALUES ('".$_SESSION['user']."','".$_POST['chkCalidad']."','".$_POST['chkTiempo']."','".$_POST['chkResultado']."')";
	try {
		$db->beginTransaction();
		$stmtus = $db->prepare($sql_delete);
		if(isset($stmtus)){$stmtus->execute();};
		$db->commit();

	} catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $db->rollBack();
	    echo $ex->getMessage();
	};
	try {
		$db->beginTransaction();
		$stmtus = $db->prepare($sql_us);
		if(isset($stmtus)){$stmtus->execute();};
		$db->commit();

	} catch(PDOException $ex) {
	    //Something went wrong rollback!
	    $db->rollBack();
	    echo $ex->getMessage();
	};
}

$db=null;

echo "<script lenguaje=\"JavaScript\">window.close();</script>";

//exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>

