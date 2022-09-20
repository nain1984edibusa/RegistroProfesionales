<?php
	$es_hijo=2;
	if(isset($_POST['profes'])){$Profes=$_POST['profes'];}else{$Profes=$_GET['profes'];};
	if(isset($_POST['cod'])){$Cod=$_POST['cod'];}else{$Cod=$_GET['cod'];};
	if(isset($_POST['prof_'])){$Prof_=$_POST['prof_'];}else{$Prof_=$_GET['prof_'];};
	if(isset($_POST['noses'])){$noses=$_POST['noses'];}else{$noses=$_GET['noses'];};

	if(!$noses){
		require_once ('session.php');	
	};
	require("include/header.inc.php");
	require("css/main-style-p.inc.php");
   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if(!$noses){
		if($_SERVER['REQUEST_METHOD']!='POST'){
			#header("Location: http://regprof.inpc.gob.ec/");
			header ("Location: http://".$_SERVER['SERVER_NAME']);
			exit;
		};	
	};
?>

<style type='text/css'>
.tableWithBackground { 
	position:absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    }

.tableBackground {
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    margin: auto;
  }
  </style>

  <style type='text/css' media="print">
.tableWithBackground { 
	position:relative;
    top: 25%;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    }

.tableBackground {
    position: absolute;
    z-index: -1;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    margin: auto;
  }
  </style>
  
</head>
 <HTML>
<body style="margin:0;  padding:0;">
  <table align=center class="tableWithBackground" width="506px" height="505px" border="0" >
				<tr>
					<td><br><br><br><br><br><br><br></td>
				</tr>
				<tr valign='top'>
					<td  colspan='2' align='center' >
					<h2>
						INSTITUTO NACIONAL DE PATRIMONIO CULTURAL<BR>REGISTRO DE PROFESIONAL
					</h2> </td>
				</tr>
				<tr>
					<td nowrap width='25%'><h1>Base de Datos:</h1> </td>
					<td nowrap ><h1><?php echo format_cont_db('TipoProfesionalId',$Profes)?></h1> </td>
				</tr>
				<tr>
					<td nowrap width='25%'><h1>C&oacute;digo de Registro:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1> </td>
					<td><h1><?php echo $Cod?></h1> </td>
				</tr>
				<tr>
					<td width='25%'><h1>Nombre:</h1> </td>
					<td><h1><?php echo format_cont_db('idProfesional', $Prof_)?></h1> </td>
				</tr>
				<tr>
					<td width='25%'><h1>Identificaci&oacute;n:</h1> </td>
					<td><h1><?php echo $Prof_?></h1> </td>
				</tr>
				<tr><td><img class="tableBackground" src="image/iso_inpc.png"><br><br><br><br><br><br><br></td></tr>
				<tr><td colspan='2'>
					<font style="text-align: justify; ">
					En uso de las facultades que le confiere la Ley de Patrimonio Cultural y su Reglamento, el INPC continuar&aacute; llevando la Base de Datos
					 de los profesionales que realizan tareas de investigaci&oacuten, restauraci&oacuten - conservaci&oacute;n, excavaci&oacuten, sobre bienes pertenecientes 
					 al Patrimonio Cultural del Estado, de modo de poder realizar las tareas de control correspondientes.
					</font><br><br>
				</td></tr>
				<tr><td style="text-align: justify; " colspan='2'>Para comprobar la autenticidad de este Registro ingrese a la Base de Datos de 
				Profesionales y ubique el C&oacute;digo de Registro utilizando el filtro correspondiente:<br> 
				<a href='http://<?php echo $_SERVER['SERVER_NAME'];?>/browse-db-gui.php' target='viewdb'>http://<?php echo $_SERVER['SERVER_NAME'];?>/browse-db-gui.php</a> </td></tr>
				<tr><td  colspan=2><?php include ("footer-p.php")?></td></tr>
			</table>
</body>
</html>


