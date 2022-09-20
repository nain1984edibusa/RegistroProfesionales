<?php
#		ini_set('display_errors', 1);
#	error_reporting(E_ALL);
#	ini_set('error_log', /var/tmp/regprof-error_log.txt'); // para poder ver los errores change as required
	$local_dir=substr($_SERVER['SCRIPT_FILENAME'],0,strrpos($_SERVER['SCRIPT_FILENAME'],"/")+1);
	$inclu_dir=$local_dir.'include';	

	set_include_path(get_include_path() . PATH_SEPARATOR . $inclu_dir);
	date_default_timezone_set ( 'America/Guayaquil' );
	
	//-----------varias
	$usr_bgc='#cFcFcF';
	//-----------varias
	//----ESPECIFICACION DE ENCABEZADOS-----
	//$ccod='UTF-8';	
	//$mime_type='text/html';
	header("Content-Type: text/html; charset=ISO-8859-1");
	header("Expires: 0");             // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
	header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
	header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
	header("Pragma: no-cache");
	//----ESPECIFICACION DE ENCABEZADOS-----
	//DETECCION DE NAVEGADOR
	if (preg_match('/msie/i',$_SERVER['HTTP_USER_AGENT'])){
		header("Location: http://<?php echo $_SERVER[SERVER_NAME];?>/browser.php");
	};
	//DETECCION DE NAVEGADOR
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
	<SCRIPT>var HOY = new Date('<?php echo date("d M Y G:i:s");?>');
	</SCRIPT>
<HEAD>
<link rel="shortcut icon" type="image/x-icon" href="/image/favicon.png" />
	<TITLE>Registro Profesionales INPC </TITLE>
	<meta charset="ISO-8859-1">
	<META NAME="GENERATOR" CONTENT="Gedit Version 3.10">
	<meta name="description" content="Registro en linea de Profesionales Instituto Nacionl de Patrimonio Cultural Ecuador, Base de datos de Profesionales INPC">
	<meta name="keywords" content="INPC,inpc,registro,profesionales,instituto,nacional,patrimonio,cultural,base,datos,arqueologo,paleontologo,restaurador, museografo">
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<META NAME="AUTHOR" CONTENT="Ivan Camacho">
	<META NAME="CREATED" CONTENT="Thu, 21 Aug 2014  01:19:28">
	<META NAME="CHANGED" CONTENT="Mon, 20 Oct 2014  01:19:28">
	<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/html">
<!--<script language="Javascript1.2" src="java/layers12.js">
</script>
<script language="Javascript1.1" src="java/layers11.js">
</script>-->
	<script >
		<?php include("java/dis_mouse.js.inc.php");?>
	</script>
</HEAD>
