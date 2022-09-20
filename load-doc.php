<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
#   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
#	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
<HTML>
<BODY >
<script LANGUAGE="JavaScript1.2" charset="ISO-8859-1">
<!---
	function validate(){
		var file=document.forms[0].userfile.value
		var err=false
		if (file==''){
			alert('Debe seleccionar un Archivo DPF')
			err=true
		}else{
			var filename=file.substr((file.length-14),14);
			var ced=filename.substr(0,10);
			var ext=filename.substr((filename.length-3),3);
			if (ext!='pdf' && ext!='PDF'){
				alert('La extensión del archivo debe ser \n \t \t \t pdf  o PDF')
				err=true
			};
		}
		if (err){
			return false
		}else{
			return true
		}
	}
-->
</script>
<?php
	if($_POST['recomendacion_']=='aprobada'){
		$doc='Certificado de Registro';
	}else{
		$doc='Oficio de Respuesta';
	}
?>
<table border="0" align="center" class='seccion'>
	<tr>
		<td align="left" class='literatura'><br><p align='left' STYLE="text-align:justify; margin-top:5; margin-right:5%; margin-bottom:5; margin-left:5%;">
			Cargar <b><?php echo $doc?> </b> en formato PDF. Estar&aacute; disponible para que el solicitante lo descargue, si lo requiere.<br><br>
<strong>Atenci&oacute;n</strong>:&nbsp; el tama&ntilde;o del archivo est&aacute; limitado a 2048 KB (2 MB), el tipo de archivo debe ser <strong>PDF<br></p>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;&nbsp;&nbsp
		</td>
	</tr>
	<tr>
		<td align="center">
			<FORM ENCTYPE="multipart/form-data" ACTION="load-doc2.php" METHOD="POST" onSubmit="return validate()">
				<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="2048000">
				<b>Documento (PDF):</b>&nbsp;&nbsp;&nbsp; <input name="userfile" type="file" accept="application/pdf"><br><br>
				<input type='hidden' name='rmdoc' value='0'>
				<input type='hidden' name='idpost' value="<?php echo $_POST['idpost']?>">
				<INPUT class='buton' TYPE="submit" VALUE="Aceptar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input class='buton' type="button" name="cancel" value="Cancelar" onClick="window.close()">
			</FORM>
		</td>
	</tr>
</table>
</BODY>
</HTML>

