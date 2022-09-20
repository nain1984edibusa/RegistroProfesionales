<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require('class/format_db_content.php');

	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_tipop.js"></SCRIPT>
<HTML>
<BODY language=JavaScript onLoad="cr.realn.focus()">
<a name='begin'></a>	
<b><table border='0' width='90%' align='center'><tr valign='bottom'><td width='30%'><img width='80%' border="0" src="image/LogoINPC2014-last.jpg"</td>
<td align='center'><font size='+1'>EDICI&Oacute;N DE CATEGOR&Iacute;AS PROFESIONALES</font></td></tr></table> </b><HR>
	<form name="cr" action="" method="post" >
				<input type="hidden" name="tpr_" value="<?php echo $_POST['tpr_']?>">
				<input type="hidden" name="subsys">
				<input type="hidden" name="ex1">
				<input type="hidden" name="ex2">
			<tr>
				<td colspan='3'><br> </td>
			</tr>
<?php
	$stfac = $db->query("SELECT * FROM TipoProfesional WHERE TipoProfesionalId ='".$_POST['tpr_']."'");
?>
	<br><br><br>
	<center><strong><font size='+1'>Modifique la Categor&iacute;a:</font> </strong></center>
	<table border='1' width ='90%' align='center' cellpadding='5' cellspacing='1' class='seccion'>
		<tr bgcolor='#ffffff'>
			<tH><B>Nombre:</b></th>
			<th><b>Perfil:</b></th>
			<th><b>Prefijo C&oacute;digo:</b></th>
		</tr>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
?>
		<tr bgcolor='#ffffff'>
			<td bgcolor='#dddddd' width='45%'>
				<input type='text' size='60' maxlength='50' name='tipopn' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['TipoProfesionalNombre']?>'>
			</td>
			<td  width='45%'>
				<input type='text' size='60' maxlength='50' name='tipopp' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['TipoProfesionalPerfil']?>'>
			</td>
			<td  width='10%'>
				<input type='text' size='20' maxlength='50' name='tipopr' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['TipoProfesionalPrefijoCodigo']?>'>
			</td>
		</tr>

<?php
	};
?>
	</table><br>
	
	<table border='0'  align='center'><tr><td><input class='buton' type="button" name="ok" value="Actualizar" onClick="if(validate()){cr.ex1.value=0;cr.ex2.value=1; cr.action='tipop-post.php';cr.submit();};return false" ></td></tr></table>

	</form>
</BODY>
</HTML>
