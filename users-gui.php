<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/format_db_content.php');
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
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_users.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
<HTML>
<BODY >
				<form name="cher" action="homeg.php" method="post" >
				<input type="hidden" name="resol">
				<input name='clos' type='hidden'>
				<input type="hidden" name="subsys">
				</form>
<a name='begin'></a>	
<?php include("theader.php")?>
<!--<DIV ID="formatos" STYLE="POSITION:absolute;  VISIBILITY: hidden; color: #290D84; font-family: sans-serif; font-size: 11px;  text-align:left; margin-top:2; margin-right:10; margin-bottom:2; margin-left:10;">-->
	<table align="center" border="0" cellspacing='0' width='90%'>
		<tr>
			<td colspan='2'>
				<table width="100%" align='left' border="0" cellpadding='2'>
					<tr>
						<td align='left' bgcolor='#ffffff' colspan='2' class='literatura'>
							<strong>Creaci&oacute;n de usuarios internos: </strong><br>
							 <p align='left' STYLE="  font-family: arial;  text-align:justify; margin-top:5; margin-right:5; margin-bottom:5; margin-left:5%;">
							 Especifique los datos informativos del usuario, qu&eacute; tipo de usuario es (rol que desempe&ntilde;a en el proceso de registro) y el o los correos 
							 electr&oacute;nicos para la recepci&oacute;n de las notificaciones que env&iacute;a la aplicaci&oacute;n.
							</p>
						</td>
					</tr>
				</table>
			</td>
	       </tr>
	</table>
<!--	</DIV>-->

	<form name="post1" action="" method="post" onSubmit="" >
				<input type="hidden" name="id_">
				<input type="hidden" name="ex1">
				<input type="hidden" name="ex2">
				<input type="hidden" name="subsys">
			<tr>
				<td colspan='3'><br><br> </td>
			</tr>
		<table border='0' cellspacing='2' align='center' width='90%'>
			<tr>
				<td align='center' class='seccion'>
					<strong><font size='+1'>DATOS DE NUEVO USUARIO</font> </strong>
					<table border='0' width ='100%' cellpadding='5'>
						<tr  bgcolor='#ffffff'>
							<td>
							<b><font color='red' size='+1'>*</font>NOMBRE DE USUARIO:</b><br>
							<input type="text" name="username" value="" size="20" maxlength="50" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
							</td>
							<td>
							<b><font color='red' size='+1'>*</font>NOMBRES y APELLIDOS:</b><br> <input type="text" name="rname" value="" size="30" maxlength="100" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
							</td>
							<td>
							<b><font color='red' size='+1'>*</font>TIPO USUARIO:</b><br> <?php load_of_db('TipoUsuario_idTipoUsuario',4)?>
							</td>
						</tr>
						<tr bgcolor='#ffffff'>
							<td>
							<b><font color='red' size='+1'>*</font>CORREO ELECTRONICO:</b><br> <input type="text" name="mail" value="" size="30" maxlength="255" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
							</td>
							<td>
							<b><font color='red' size='+1'><!--*--></font>CORREO ELECTRONICO 2:</b><br> <input type="text" name="mail2" value="" size="30" maxlength="255" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td><b>
								<font color='red' size='+1'>*</font>: Campos Obligatorios<br>
							</td>
						</tr>
					</table><br><br>
				</td>
			</tr>
			<tr>
				<td colspan='3'><br><br> </td>
			</tr>
			<tr>
				<td colspan='3' align='center'>
					<input class='buton' type="button" name="send" value="ACEPTAR" onFocus="" onBlur="" onClick="if(validate()){post1.ex1.value=1;post1.ex2.value=0;post1.target='_self';post1.action='usr-post.php';post1.submit();}">
				</td>
			</tr>
		</table>
	</form>
</BODY>
</HTML>
