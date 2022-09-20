<?php
	$es_hijo=2;
	if(!isset($_POST['is_post']) and !$_POST['is_post']){
	require_once ('session.php');
	};	
	//header("Content-Type: text/html; charset=UTF-8");
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/infodigital.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
function limpiar_($s) {
	$s = preg_replace("[áàâãª]","a",$s);
	$s = preg_replace("[ÁÀÂÃ]","A",$s);
	$s = preg_replace("[éèê]","e",$s);
	$s = preg_replace("[ÉÈÊ]","E",$s);
	$s = preg_replace("[íìî]","i",$s);
	$s = preg_replace("[ÍÌÎ]","I",$s);
	$s = preg_replace("[óòôõº]","o",$s);
	$s = preg_replace("[ÓÒÔÕ]","O",$s);
	$s = preg_replace("[úùû]","u",$s);
	$s = preg_replace("[ÚÙÛ]","U",$s);
	$s = str_replace("ñ","n",$s);
	$s = str_replace("Ñ","N",$s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
};
$data=NULL;
#$datos = CallAPI('GET','https://www.datoseguro.gob.ec/ws/rest/relacionconfianza/publico/?_wadl',$data);
#echo $_POST['docid'].' a consultar';
#exit;
$query='https://www.datoseguro.gob.ec/ws/rest/relacionconfianza/publico/rpINPC/'.$_POST['docid'].'/vigencia';
$json = CallAPI('GET',$query,$data);
#$json='{"DatosTramite":{"NombreIRC":"rpINPC","InformacionCivil":[{"NombreCampo":"CEDULA","Valor":"0602908170"},{"NombreCampo":"NOMBRE","Valor":"CAMACHO YEROVI IVAN PATRICIO"},{"NombreCampo":"GENERO","Valor":"MASCULINO"},{"NombreCampo":"FECHANACIMIENTO","Valor":"06\/08\/1978"},{"NombreCampo":"LUGARNACIMIENTO","Valor":"PICHINCHA\/QUITO\/SAN BLAS"},{"NombreCampo":"NACIONALIDAD","Valor":"ECUATORIANA"}],"InformacionSenescyt":{"NivelTitulo":[{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"null "},{"NombreCampo":"IES","Valor":"ESCUELA SUPERIOR POLITECNICA DE CHIMBORAZO"},{"NombreCampo":"NOMBRETITULO","Valor":"TECNOLOGO EN INFORMATICA APLICADA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1002-03-389101"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Nivel Técnico o Tecnológico Superior"}}},{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"Thu May 16 00:00:00 ECT 2013 "},{"NombreCampo":"IES","Valor":"UNIVERSIDAD TECNOLOGICA AMERICA"},{"NombreCampo":"NOMBRETITULO","Valor":"ECUATORIANA"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1043-13-1283"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Tercer Nivel Nacionales"}}}]}}}';
#$json='{"DatosTramite":{"NombreIRC":"rpINPC","InformacionCivil":[{"NombreCampo":"CEDULA","Valor":1720941036},{"NombreCampo":"NOMBRE","Valor":"JARAMILLO VALDEZ KARINA VANESSA"},{"NombreCampo":"GENERO","Valor":"FEMENINO"},{"NombreCampo":"FECHANACIMIENTO","Valor":"30\/12\/1985"},{"NombreCampo":"LUGARNACIMIENTO","Valor":"PICHINCHA\/QUITO\/SANTA PRISCA"},{"NombreCampo":"NACIONALIDAD","Valor":"ECUATORIANA"}],"InformacionSenescyt":{"NivelTitulo":{"Titulos":{"Titulo":[{"NombreCampo":"FECHAGRADO","Valor":"Fri Jun 17 00:00:00 ECT 2011 "},{"NombreCampo":"IES","Valor":"ESCUELA SUPERIOR POLITECNICA DE CHIMBORAZO"},{"NombreCampo":"NOMBRETITULO","Valor":"LICENCIADA EN DISEÑO GRAFICO"},{"NombreCampo":"NUMEROREGISTRO","Valor":"1002-11-1079269"},{"NombreCampo":"TIPO","Valor":"NACIONAL"},{"NombreCampo":"TIPOEXTRAJEROCOLEGIO"}],"Descripcion":{"NombreCampo":"NIVEL","Valor":"Títulos de Tercer Nivel Nacionales"}}}}}}';
#$json='java.lang.NullPointerException';
$datoseguro=json_decode($json);
#print_r($datoseguro);
?>
<center>
		<img style='border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff;background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;' src='image/datoseguro.png'>
		<img height='40' style='border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff;background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;' src='http://www.datospublicos.gob.ec/wp-content/uploads/dinardap_header.png'>
	</center>
<?php
if ($json!='java.lang.NullPointerException'){		//SI DEVUELVE DATOS, ES DECIR SI LA PERSONA EXISTE EN EL REGISTRO DE DATO SEGURO
?>
<table bgcolor='#f4f4f4' style="border-color: lightgray; border-style:solid ;" border='1' cellspacing='0' width='80%' align='center'>
	<tr>
		<td bgcolor='#dcedf9' align='center' colspan='2'><b>Registro Civil:</b></td>
	</tr>
	<tr>
		<td colspan='2' align='center'><table border='0' align='center' width='100%'>
			<tr> <td  >		<hr style="height:1px; background-color:#aed0ea;"><br> </td> </tr>
			<tr>
				<td align='center' >	<img height='50' src='image/logo-RegistroCivil.png'></td>
			</tr>
			<tr> <td >		<hr style="height:1px; background-color:#aed0ea;"><br> </td> </tr>
		</table></td>
	</tr>
	<tr>
		<td bgcolor='#dcedf9' align='center' ><b>Campo</b></td>
		<td bgcolor='#dcedf9' align='center' ><b>Valor</b></td>
	</tr>
<?php

	foreach ($datoseguro->DatosTramite->InformacionCivil as $registro) {
		if($registro->NombreCampo=='GENERO'){
			switch($registro->Valor){
				case 'MASCULINO':
					$set_genero="UPDATE Profesional SET ProfesionalGenero='M' WHERE idProfesional='".$_POST['docid']."'";
				break;
				case 'FEMENINO':
					$set_genero="UPDATE Profesional SET ProfesionalGenero='F' WHERE idProfesional='".$_POST['docid']."'";
				break;
			};
			$stmt = $db->prepare($set_genero);
			if(isset($stmt)){$stmt->execute();};
		};
		echo '<tr><td width="50%"> <b>'.ucwords(strtolower(str_replace('NACIMIENTO', ' NACIMIENTO',$registro->NombreCampo))). ':</b></td><td width="50%"> '.utf8_decode($registro->Valor).'</td></tr>';
	}
?>
	<tr> <td colspan='2' align='left'><b>* La informaci&oacute;n presentada es de exclusiva responsabilidad del registro civil<br><br></b></td> </tr>
</table>
<br><br>
<?php  ?>
<table bgcolor='#f4f4f4' style="border-color: lightgray; border-style:solid ;" border='1' border='0' cellspacing='0' width='100%'>
	<tr>
		<td bgcolor='#dcedf9' align='center' colspan='2'><b>Secretar&iacute;a Nacional de Educaci&oacute;n Superior, Ciencia, Tecnolog&iacute;a e Innovaci&oacute;n</b></td>
	</tr>
	<tr>
		<td colspan='2' align='center'><table border='0' align='center' width='100%'>
			<tr> <td colspan='2' align='center'>		<hr style="height:1px; background-color:#aed0ea;"><br> </td> </tr>
			<tr>
				<td align='center' colspan='2' >	<img height='50' src='image/logo-senescyt.png'></td>
			</tr>
			<tr> <td colspan='2' align='center'>		<hr style="height:1px; background-color:#aed0ea;"><br> </td> </tr>
		</table></td>
	</tr>
<?php
	$percent=array('7%','28%','29%','13%','10%','13%');
	$hay_cont=0;
	if (is_array($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo )){		//si uno o mas titulos
		$hay_cont++;
		foreach ($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo as $niveltitulo) {
			echo '<tr><td bgcolor="#61bbe8" colspan="2"> <b><font color="#ffffff">'.utf8_decode($niveltitulo->Titulos->Descripcion->Valor).'</font></b></td></tr>';
			echo "<tr> <td align='center'><table style='border-color: lightgray; border-style:solid ;' border='1' cellspacing='0' width='100%'><tr>";
				$i=0;
			foreach($niveltitulo->Titulos->Titulo as $titulo){
				$titulo->NombreCampo=str_replace('GRADO', ' GRADO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('IES', ' INSTITUCION',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('TITULO', ' TITULO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('REGISTRO', ' REGISTRO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('GRADO', ' GRADO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('TIPOEXTRAJEROCOLEGIO', ' COLEGIO EXTRANJERO',$titulo->NombreCampo);
				echo '<td width="'.$percent[$i].'" bgcolor="#dcedf9" > <b>'.ucwords(utf8_decode(strtolower($titulo->NombreCampo))). ':</b></td>';
				$i++;
			};
			echo "</tr><tr>";
			foreach($niveltitulo->Titulos->Titulo as $titulo){
				if(strstr($titulo->NombreCampo,"FECHA")){
					if (!strstr($titulo->Valor,'null')){
						$timestamp = strtotime($titulo->Valor);
						$titulo->Valor=date("Y/m/d", $timestamp);
					};
					echo '<td> '.utf8_decode(str_replace('null','',$titulo->Valor)).'</td>';
				}else{
					if(isset($titulo->Valor) && !strstr($titulo->Valor,'null')){
						echo '<td> '.utf8_decode(str_replace('null','',$titulo->Valor)).'</td>';
					};
				};
			};
			echo "</tr></table></td></tr>";
		};
	};

	if (is_object($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo )){		//si un solo titulo
		$hay_cont++;
			echo '<tr><td bgcolor="#61bbe8" colspan="2"> <b><font color="#ffffff">'.utf8_decode($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Descripcion->Valor).'</font></b></td></tr>';
			echo "<tr> <td align='center'><table style='border-color: lightgray; border-style:solid ;' border='1' cellspacing='0' width='100%'><tr>";
				$i=0;
		foreach($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Titulo as $titulo){
				$titulo->NombreCampo=str_replace('GRADO', ' GRADO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('IES', ' INSTITUCION',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('TITULO', ' TITULO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('REGISTRO', ' REGISTRO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('GRADO', ' GRADO',$titulo->NombreCampo);
				$titulo->NombreCampo=str_replace('TIPOEXTRAJEROCOLEGIO', ' COLEGIO EXTRANJERO',$titulo->NombreCampo);
				echo '<td  width="'.$percent[$i].'" bgcolor="#dcedf9" > <b>'.ucwords(utf8_decode(strtolower($titulo->NombreCampo))). ':</b></td>';
				$i++;
		};
		echo "</tr><tr>";
		foreach($datoseguro->DatosTramite->InformacionSenescyt->NivelTitulo->Titulos->Titulo as $titulo){
				if(strstr($titulo->NombreCampo,"FECHA")){
					if (!strstr($titulo->Valor,'null')){
						$timestamp = strtotime($titulo->Valor);
						$titulo->Valor=date("Y/m/d", $timestamp);
					};
					echo '<td> '.utf8_decode(str_replace('null','',$titulo->Valor)).'</td>';
				}else{
					if(isset($titulo->Valor) &&!strstr($titulo->Valor,'null')){
						echo '<td> '.utf8_decode(str_replace('null','',$titulo->Valor)).'</td>';
					};
				};
		};
	echo "</tr></table></td></tr>";
	};
	if($hay_cont<1){
?>
	<tr> <td colspan='2' align='center'><b>La consulta a Datoseguro no devolvi&oacute; datos, pruebe el enlace con la SENESCYT <br><br></b></td> </tr>
<?php
	};
?>
	<tr> <td colspan='2' align='left'><b>* La informaci&oacute;n presentada es de exclusiva responsabilidad de Secretar&iacute;a Nacional de Educaci&oacute;n Superior, Ciencia, Tecnolog&iacute;a e Innovaci&oacute;n<br><br></b></td> </tr>


</table>
<?php
		
}else{
	echo '<center><h1>No existen datos en INFODIGITAL</h1><center>';
}

?>


