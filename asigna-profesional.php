<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require_once ("PHPMailer/mailer.php");
	require('class/format_db_content.php');

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
				window.parent.cher.action='admin-gui.php';
				window.parent.cher.submit();
			};
         </SCRIPT>
<?php
	for($i=0;$i < count($keyes); $i++){
		//echo $keyes[$i].' '.$values[$i]."<br>";
	};//echo $_POST['fa1'].' '.$_POST['fa2'].' '.$_POST['fa3'].' '.$_POST['fa4'].' '.$_POST['fa5'].' '.$_POST['fa6'].' hahah';	

	if(isset($_POST['TipoProfesionalId']) and isset($_POST['usrn_'])){
		$sql="INSERT INTO UsuarioManejaProfesional";
		$sql.=" (user_username,TipoProfesional_TipoProfesionalId)";
		$sql.=" VALUES ('".$_POST['usrn_']."','".$_POST['TipoProfesionalId']."')";
	};
try {
	$db->beginTransaction();
	$stmt = $db->prepare($sql);
	if(isset($stmt)){$stmt->execute();};
	$db->commit();

} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
    exit;
};
?>
	<form name='back_' method='POST'></form><script>reload_()</script>
<?php
$db=null;
exit;
?>

	


