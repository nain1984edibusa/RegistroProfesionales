<?php
#		ini_set('display_errors', 1);
#	error_reporting(E_ALL);
#	set_include_path(get_include_path() . PATH_SEPARATOR . $inclu_dir);
#	date_default_timezone_set ( 'America/Guayaquil' );
#	
#	//-----------varias
#	//-----------varias
#	//----ESPECIFICACION DE ENCABEZADOS-----
#	//$ccod='UTF-8';	
#	//$mime_type='text/html';
#	header("Content-Type: text/html; charset=UTF-8");
#	header("Expires: 0");             // Date in the past
#	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
#	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
#	header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
#	header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
#	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
#	header("Pragma: no-cache");
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');

switch ($_GET['tipo']){
	case 'tit':
#		$fp=file("/tmp/tit-arqueo-csv.csv");
		$fp=file("/tmp/tit-resta-csv.csv");
		$j=1;
		foreach ($fp as $fila){
	#	echo '<br>'.$fila;
			$sql="INSERT INTO FAcademica (FAcademicaNivel,FAcademicaNTitulo,FAcademicaInstitucion,FAcademicaFecGrado,FAcademicaCSenescyt,Profesional_idProfesional,FAcademicaTituloValido,FAcademicaTituloUsado) VALUES (";
			$campos=explode(";",$fila);
			$sql.="".$campos[0].","; //nivel
			$sql.="'".$campos[1]."',"; //titu
			$sql.="'".$campos[2]."',"; //institut
			$sql.="'".$campos[3]."',"; //fgrado
			$sql.="'".$campos[4]."',"; //sene
			$sql.="'".$campos[5]."',"; //ced
			$sql.="'".$campos[6]."',"; //valido
			$sql.="'".str_replace("\n",'',$campos[7])."')"; //usado
			echo $j.'----'.$sql."<br>";
			try {
				$db->beginTransaction();
				$stmt = $db->prepare($sql);
#				if(isset($stmt)){$stmt->execute();};
				$db->commit();
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				$db->rollBack();
				echo '<br>'.$ex->getMessage();
			};
		$j++;
		};
	break;
	case 'reg':
#		$fp=file("/tmp/reg-arqueo-csv3.csv");
		$fp=file("/tmp/reg-resta-csv.csv");
		$j=1;
		foreach ($fp as $fila){
	#	echo '<br>'.$fila;
			$sql="INSERT INTO RegistroP (RegistroPCodigo,RegistroPApellidos,RegistroPNombres,RegistroPGenero,RegistroPDireccion,RegistroPCiudadr,RegistroPPaisr,RegistroPTlfFijo,RegistroPTlfMovil,RegistroPMail,RegistroPMail2,Profesional_idProfesional,RegistroPProfesionalID,RegistroPFechaRegistro,RegistroPActivo) VALUES (";
			$campos=explode(";",$fila);
			$sql.="'".$campos[0]."',"; //cod
			$sql.="'".$campos[1]."',"; //ap
			$sql.="'".$campos[2]."',"; //nom
			$sql.="'".$campos[3]."',"; //sexo
			$sql.="'".$campos[4]."',"; //direc
			$sql.="'".$campos[5]."',"; //ciudad
			$sql.="'".$campos[6]."',"; //pais
			$sql.="'".$campos[7]."',"; //tlf
			$sql.="'".$campos[8]."',"; //tlf2
			$sql.="'".$campos[9]."',"; //mail
			$sql.="'".$campos[10]."',"; //mail2
			$sql.="'".$campos[11]."',"; //ced
			$sql.="".$campos[12].","; //tipop
			$sql.="'".$campos[13]."',"; //fechar
			$sql.="".$campos[14].")"; //activo
			echo $j.'----'.$sql."<br>";
			try {
				$db->beginTransaction();
				$stmt = $db->prepare($sql);
#				if(isset($stmt)){$stmt->execute();};
				$db->commit();
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				$db->rollBack();
				echo '<br>'.$ex->getMessage();
			};
		$j++;
		};
	break;
	case 'prof':
#		$fp=file("/tmp/dper-arqueo-csv2.csv");
		$fp=file("/tmp/dper-resta-csv.csv");
		$j=1;
		foreach ($fp as $fila){
	#	echo '<br>'.$fila;
			$sql="INSERT into Profesional VALUES (";
			$sql2="INSERT into Profesiones (Profesional_idProfesional,TipoProfesional_TipoProfesionalId) VALUES (";
			$campos=explode(";",$fila);
			$sql.="'".$campos[0]."',"; //ced
			$sql2.="'".$campos[0]."',"; //ced
			$sql.="'".$campos[1]."',"; //nom
			$sql.="'".$campos[2]."',"; //ap
			$sql.="'".$campos[3]."',"; //fnac
			$sql.="'".$campos[4]."',"; //sexo
			$sql.="'".$campos[5]."',"; //tlf
			$sql.="'".$campos[6]."',"; //tlf2
			$sql.="'".$campos[7]."',"; //dir
			$sql.="'".$campos[8]."',"; //correo
			$sql.="'".$campos[9]."',"; //correo
			$sql.="".$campos[10].","; //ciudad
			$sql.="'".$campos[11]."',"; //pais
			$sql.="'".$campos[12]."',"; //nacion
			$sql.="".$campos[13].","; //tipodoc
			$sql2.="2)"; //tipop
			$sql.="".$campos[14].","; //actualizo
			$sql.="'".$campos[15]."')"; //fac
			$sql=$sql; //fac
#			echo $j.'----'.$sql2.'<br>';
$ya=$db->query("SELECT idProfesional FROM Profesional where idProfesional='$campos[0]' ");

if (/*$campos[0]!='1709842387'*/ !$ya->rowCount()){
			echo $j.'----'.$sql.'<<<<>>>>'.$sql2.'<br>';
			try {
				$db->beginTransaction();
				$stmt = $db->prepare($sql);
				$stmt2 = $db->prepare($sql2);
#				if(isset($stmt)){$stmt->execute();};
#				if(isset($stmt2)){$stmt2->execute();};
				$db->commit();
			} catch(PDOException $ex) {
				//Something went wrong rollback!
				$db->rollBack();
				echo '<br>'.$ex->getMessage();
			};
			}else{
			echo $campos[0].'  ya insertado<br>';
			}
			
		$j++;
		};
	break;
};
	exit;
?>


