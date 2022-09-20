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
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js">
	 </SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js">
	 </SCRIPT>
<HTML>
<BODY language=JavaScript onLoad="cr.realn.focus()">
<a name='begin'></a>	
<b><table border='0' width='90%' align='center'><tr valign='bottom'><td width='30%'><img width='80%' border="0" src="image/LogoINPC2014-last.jpg"</td>
<td align='center'><font size='+1'>EDICI&Oacute;N DE USUARIOS</font></td></tr></table> </b><HR>

	<form name="cr" action="" method="post" >
				<input type="hidden" name="usrn" value="<?php echo $_POST['usr_']?>">
				<input type="hidden" name="subsys">
				<input type="hidden" name="ex1">
				<input type="hidden" name="ex2">
			<tr>
				<td colspan='3'><br> </td>
			</tr>
<?php
        $stfac = $db->query("SELECT * FROM user WHERE username ='".$_POST['usr_']."'");
        
?>
	<br><br><br>
                <center><strong><font size='+1'>Modifique los privilegios del Usuario:</font> </strong></center>
                <table border='1' width ='90%' align='center' cellpadding='5' cellspacing='1' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH><B>Nombre Usuario:</b>
								</th>
								<th><b>Nombre Real:</b>
								</th>
								<th><b>Tipo Usuario:</b>
								</th>
								<th><b>Correo Electronico:</b>
								</th>
								<th><b>Correo Electronico 2:</b>
								</th>
<!--								<th><b>Atiende solicitudes de:</b>
								</th>-->
								<th><b>Activo/Inactivo:</b>
								</th>
							</tr>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
#        	$stpr = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$_POST['usr_']."'");
#        	$tiprof = $stpr->fetch(PDO::FETCH_ASSOC);
?>
			<tr bgcolor='#ffffff'>
				<td><?php echo $row['username']?>
				</td>
				<td bgcolor='#dddddd'>
					<input type='text' size='20' maxlength='50' name='realn' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['realname']?>'>
				</td>
				<td><?php echo format_cont_db('idTipoUsuario',$row['TipoUsuario_idTipoUsuario'])?>
				</td>
				<td>
					<input type='text' size='20' maxlength='50' name='email' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['email']?>'>
				</td>
				<td>
					<input type='text' size='20' maxlength='50' name='email2' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" value='<?php echo $row['email2']?>'>
				</td>
<!--				<td>
<?php
	/*			if($row['TipoUsuario_idTipoUsuario']>2){ echo format_cont_db('TipoProfesionalId',$tiprof['TipoProfesional_TipoProfesionalId']);};*/
?>
				</td>-->
				<td  align='center'>
<?php
				if($row['TipoUsuario_idTipoUsuario']){
?>
					<SELECT NAME="estado" size="1"  onFocus="set_bgcolor(this,'#99ffff')" onBlur="set_bgcolor(this,'')">
						<OPTION <?php if ($row['userEstado']){?>selected<?php ;};?> value="1">Activo</OPTION>
						<OPTION <?php if (!$row['userEstado']){?>selected<?php ;};?> value="0">Inhabilitado</OPTION>
        			</SELECT>
<?php
				}else{
?>
					<input type='hidden' name='estado' value='<?php echo $row['userEstado']?>'><?php echo format_cont_db('userEstado',$_SESSION['tuser']) ?>
<?php
				};
?>
				</td>
           </tr>

<?php
	};
?>
	</table><br>
	
	<table border='0'  align='center'><tr><td><input class='buton' type="button" name="ok" value="Actualizar" onClick="cr.ex1.value=0;cr.ex2.value=1; cr.action='usr-post.php';cr.submit()" ></td></tr></table>

	</form>
	<center></center>

</BODY>
</HTML>
