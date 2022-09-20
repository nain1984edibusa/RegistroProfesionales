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
//	require('class/mysql_crud.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');

$get_p=$db->query("SELECT idProfesional,ProfesionalNombres, ProfesionalApellidos FROM Profesional limit 1");
$get_p->setFetchMode(PDO::FETCH_ASSOC);
$personas=$get_p->fetchAll();
foreach($personas as $persona) {
	$profes_=$db->query("SELECT * FROM Profesiones WHERE Profesional_idProfesional='".$persona['idProfesional']."' ");
	$profes_->setFetchMode(PDO::FETCH_ASSOC);
	$profes=$profes_->fetchAll();
	foreach ($profes as $profe){
		$get_cod=$db->query("SELECT RegistroPCodigo FROM RegistroP WHERE Profesional_idProfesional='".$persona['idProfesional']."' and RegistroPProfesionalID=".$profe['TipoProfesional_TipoProfesionalId']);
		$codi= $get_cod->fetch(PDO::FETCH_ASSOC);
		
		$ins_post="INSERT INTO Postulacion (PostulacionFechaI,PostulacionEstado, PostulacionAsignado,PostulacionFechaV, PostulacionVerificado,PostulacionFechaD,PostulacionAprobado,PostulacionFechaF, PostulacioncCumpleInfop,PostulacionCumpleInfoA, Profesiones_idProfesiones)";
		$ins_post.=" VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),1,1,CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),1,CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),'aprobada',CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),1,1,".$profe['idProfesiones'].")";

		$sql_it="INSERT INTO InformeTecnico";
		$sql_it.=" (InformeTecnicoRefDoc,InformeTecnicoObservacion,InformeTecnicoRecomendacion,InformeTecnicoCodPro,Postulacion_idPostulacion)";
		$sql_it.=" VALUES ('p-migracion','','aprobada','".$codi['RegistroPCodigo']."',(SELECT idPostulacion from Postulacion where Profesiones_idProfesiones = (SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$profe['TipoProfesional_TipoProfesionalId']." and Profesional_idProfesional='".$profe['Profesional_idProfesional']."')))";  

		$sql_sr="INSERT INTO SolicitudRespuesta";
		$sql_sr.=" (SolicitudRespuestaRefDoc,SolicitudRespuestaResumen,Postulacion_idPostulacion)";
		$sql_sr.=" VALUES ('p-migracion','',(SELECT idPostulacion from Postulacion where Profesiones_idProfesiones = (SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$profe['TipoProfesional_TipoProfesionalId']." and Profesional_idProfesional='".$profe['Profesional_idProfesional']."')))";  

		$validador=($profe['TipoProfesional_TipoProfesionalId']==1)?'fernando.mejia':'michele.arroyo';

		$sql_va="INSERT INTO AccionEnPostulacion";
		$sql_va.=" (AccionEnPostulacionAccion,user_username,AccionEnPostulacionFechaAs,Postulacion_idPostulacion)";
		$sql_va.=" VALUES (4,'$validador',CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),(SELECT idPostulacion from Postulacion where Profesiones_idProfesiones = (SELECT idProfesiones FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=".$profe['TipoProfesional_TipoProfesionalId']." and Profesional_idProfesional='".$profe['Profesional_idProfesional']."')))";  

	 echo $persona['ProfesionalNombres'].' '.$persona['ProfesionalApellidos'].'-->'.$ins_post.'<br>'.$sql_it.'<br>'.$sql_sr.'<br>'.$sql_va.'<hr>';
	};
};

try {
	$db->beginTransaction();		
	if(isset($ins_post)){$stmt_post = $db->prepare($ins_post);};
	if(isset($sql_it)){$stmt_it = $db->prepare($sql_it);};	
	if(isset($sql_sr)){$stmt_sr = $db->prepare($sql_sr);};
	if(isset($sql_va)){$stmt_va = $db->prepare($sql_va);};
#	if(isset($stmt_post)){$stmt_post->execute();};
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


