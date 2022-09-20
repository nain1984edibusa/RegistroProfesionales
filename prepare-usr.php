<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');

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

#$get_p=$db->query("SELECT * FROM user WHERE TipoUsuario_idTipoUsuario =3 and email='ivocamacho@gmail.com' limit 1000");
$get_p=$db->query("SELECT * FROM user WHERE username='0100845916'");
$get_p->setFetchMode(PDO::FETCH_ASSOC);
$personas=$get_p->fetchAll();
echo "<table border='1'>";
	echo "<tr><td>username</td><td>realname</td><td>BD</td><td>mail</td><td>mail2</td><td>tmp token_gen</td></tr>";
foreach($personas as $persona) {
	$profes_=$db->query("SELECT * FROM Profesiones WHERE Profesional_idProfesional='".$persona['username']."' ");
	$profes_->setFetchMode(PDO::FETCH_ASSOC);
	$profes=$profes_->fetchAll();
	$bds='';
	foreach ($profes as $profe){
		$bds.=format_cont_db('TipoProfesionalId',$profe['TipoProfesional_TipoProfesionalId']).' ';
	};
#	 echo $persona['realname'].' '.$persona['ProfesionalApellidos'].'-->'.$ins_post.'<br>'.$sql_it.'<br>'.$sql_sr.'<br>'.$sql_va.'<hr>';
	$tmp_token=token_gen();
echo	$set_c="UPDATE user SET userTokenReg ='$tmp_token' WHERE username ='".$persona['username']."'";
	echo "<tr><td>".$persona['username'].'</td><td>'.$persona['realname'].'</td><td>'.$bds.'</td><td>'.$persona['email'].'</td><td>'.$persona['email2'].'</td><td>'.$tmp_token.'</td></tr>';

};
echo "</table>";
try {
	$db->beginTransaction();		
	if(isset($set_c)){$stmt_c = $db->prepare($set_c);};
			#	if(isset($sql_it)){$stmt_it = $db->prepare($sql_it);};	
			#	if(isset($sql_sr)){$stmt_sr = $db->prepare($sql_sr);};
			#	if(isset($sql_va)){$stmt_va = $db->prepare($sql_va);};
#	if(isset($stmt_c)){$stmt_c->execute();};
			#	if(isset($stmt_it)){$stmt_it->execute();};
			#	if(isset($stmt_sr)){$stmt_sr->execute();};
			#	if(isset($stmt_va)){$stmt_va->execute();};
	$db->commit();


} catch(PDOException $ex) {
    //Something went wrong rollback!
    $db->rollBack();
    echo $ex->getMessage();
};
	exit;
?>


