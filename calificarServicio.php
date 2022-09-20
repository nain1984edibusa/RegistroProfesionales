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
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if(!$noses){
		if($_SERVER['REQUEST_METHOD']!='POST'){
			//echo 'ataque';
			header("Location: index");
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

	<form name="cr" action=" " method="post" >
		
<?php

$chkCalidad1 = 'unchecked';
$chkCalidad2 = 'unchecked';
$chkCalidad3 = 'unchecked';
$chkCalidad4 = 'unchecked';
$chkCalidad5 = 'unchecked';

$chkTiempo1 = 'unchecked';
$chkTiempo2 = 'unchecked';
$chkTiempo3 = 'unchecked';
$chkTiempo4 = 'unchecked';
$chkTiempo5 = 'unchecked';

$chkResultado1 = 'unchecked';
$chkResultado2 = 'unchecked';
$chkResultado3 = 'unchecked';
$chkResultado4 = 'unchecked';
$chkResultado5 = 'unchecked';

$post_in_proc = $db->query("SELECT calidad,tiempo,resultado FROM calificacionServicio WHERE username ='".$_SESSION['user']."'");

while($row = $post_in_proc->fetch(PDO::FETCH_ASSOC)) {
	$var1 = $row['calidad'];
	$var2 = $row['tiempo'];
	$var3 = $row['resultado'];

	if($var1 == '1') {	$chkCalidad1 = 'checked';} 
	else if($var1 == '2') { $chkCalidad2 = 'checked';} 
	else if($var1 == '3') { $chkCalidad3 = 'checked';} 
	else if($var1 == '4') { $chkCalidad4 = 'checked';} 
	else if($var1 == '5') {$chkCalidad5 = 'checked';} 

	if($var2 == '1') {	$chkTiempo1 = 'checked';} 
	else if($var2 == '2') { $chkTiempo2 = 'checked';} 
	else if($var2 == '3') { $chkTiempo3 = 'checked';} 
	else if($var2 == '4') { $chkTiempo4 = 'checked';} 
	else if($var2 == '5') { $chkTiempo5 = 'checked';} 

	if($var3 == '1') {	$chkResultado1 = 'checked';} 
	else if($var3 == '2') { $chkResultado2 = 'checked';} 
	else if($var3 == '3') { $chkResultado3 = 'checked';} 
	else if($var3 == '4') { $chkResultado4 = 'checked';} 
	else if($var3 == '5') {	$chkResultado5 = 'checked';} 

	break;
};

?>

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
					<td nowrap width='25%'><h1>Par&#225;metros a calificar</h1> </td>
					<td nowrap width='25%'><h1>Valor(1 menor - 5 mayor)</h1> </td>
				</tr>
				<tr>
					<td nowrap width='25%'><h1>Calidad</h1> </td>
					<td nowrap width='50%'>
						<input type="RADIO" name="chkCalidad" value="1" <?php print $chkCalidad1; ?>> 1
						<input type="RADIO" name="chkCalidad" value="2" <?php print $chkCalidad2; ?>> 2
						<input type="RADIO" name="chkCalidad" value="3" <?php print $chkCalidad3; ?>> 3
						<input type="RADIO" name="chkCalidad" value="4" <?php print $chkCalidad4; ?>> 4
						<input type="RADIO" name="chkCalidad" value="5" <?php print $chkCalidad5; ?>> 5
 					</td>
				</tr>
				<tr>
					<td nowrap width='25%'><h1>Tiempo</h1> </td>
					<td nowrap width='50%'>
						<input type="RADIO" name="chkTiempo" value="1" <?php print $chkTiempo1; ?>> 1
						<input type="RADIO" name="chkTiempo" value="2" <?php print $chkTiempo2; ?>> 2
						<input type="RADIO" name="chkTiempo" value="3" <?php print $chkTiempo3; ?>> 3
						<input type="RADIO" name="chkTiempo" value="4" <?php print $chkTiempo4; ?>> 4
						<input type="RADIO" name="chkTiempo" value="5" <?php print $chkTiempo5; ?>> 5
 					</td>
				</tr>
				<tr>
					<td nowrap width='25%'><h1>Resultado</h1> </td>
					<td nowrap width='50%'>
						<input type="RADIO" name="chkResultado" value="1" <?php print $chkResultado1; ?>> 1
						<input type="RADIO" name="chkResultado" value="2" <?php print $chkResultado2; ?>> 2
						<input type="RADIO" name="chkResultado" value="3" <?php print $chkResultado3; ?>> 3
						<input type="RADIO" name="chkResultado" value="4" <?php print $chkResultado4; ?>> 4
						<input type="RADIO" name="chkResultado" value="5" <?php print $chkResultado5; ?>> 5
 					</td>
				</tr>
				<tr>
					<td></td>
					<td><input class='buton' type="button" name="Guardar" value="Guardar" onClick="cr.action='guardarCalificarServicio.php';cr.submit()" ></td>

				</tr>

				<tr><td  colspan=2><?php include ("footer-p.php")?></td></tr>
			</table>

	</form>
</body>
</html>


