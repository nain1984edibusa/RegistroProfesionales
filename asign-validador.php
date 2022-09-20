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
<BODY language=JavaScript onLoad="cr.Validador_Postulacion.focus()">
<a name='begin'></a>	
<b><table border='0' width='90%' align='center'><tr valign='bottom'><td width='30%'><img width='80%' border="0" src="image/LogoINPC2014-last.jpg"</td>
<td align='center'><font size='+1'>Asignaci&oacute;n de T&eacute;cnico para Revisar Solicitud de Registro</font></td></tr></table> </b><HR>

	<form name="cr" action="" method="post" >
				<input type="hidden" name="idpost" value="<?php echo $_POST['subsys']?>">
			<tr>
				<td colspan='3'><br> </td>
			</tr>
<?php
        $stfac = $db->query("SELECT * FROM Postulacion WHERE idPostulacion ='".$_POST['subsys']."'");
        
?>
	<br><br><br>
                <center><strong><font size='+1'>Elija al T&eacute;cnico para revisar la solicitud y haga click en Asignar</font> </strong></center>
                <table border='1' width ='90%' align='center' cellpadding='5' cellspacing='1' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH><B>Solicitante:</b>
								</th>
								<th><b>Fecha Ingreso Solicitud:</b>
								</th>
								<th><b>Estado:</b>
								</th>
								<th><b>T&eacute;cnicos:</b>
								</th>
							</tr>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
        	$st_val=$db->query("SELECT t1.realname,t1.username FROM user as t1, UsuarioManejaProfesional as t2 WHERE t1.Tipousuario_IdTipoUsuario = 4 and t2.TipoProfesional_TipoProfesionalId=".$_POST['prof']." and t1.username=t2.user_username and t1.userEstado=1");
			$st_pro= $db->query("SELECT Profesional_idProfesional FROM Profesiones WHERE idProfesiones=".$row['Profesiones_idProfesiones']."");
			$stpro= $st_pro->fetch(PDO::FETCH_ASSOC);	

?>
                        <tr bgcolor='#ffffff'  align='center'>
							<td><?php echo format_cont_db('idProfesional',$stpro['Profesional_idProfesional'])?>
							<input type="hidden" name="idprofesi" value="<?php echo $row['Profesiones_idProfesiones']?>">
                            </td>
                            <td><?php echo $row['PostulacionFechaI']?>
                            </td>
                            <td><?php echo format_cont_db('PostulacionEstado',$row['PostulacionEstado'])?>
                            </td>
                            <td  align='center'>
								<SELECT NAME="Validador_Postulacion" size="1"  onFocus="set_bgcolor(this,'#99ffff')" onBlur="set_bgcolor(this,'');">
<?php
			while ($vali = $st_val->fetch(PDO::FETCH_ASSOC)){
?>
 									<OPTION  value="<?php echo $vali['username'];?>"><?php echo $vali['realname'];?> </OPTION>
<?php
			};
?>
        						</SELECT><br>        						

                            </td>
           </tr>

<?php
		};
?>
	</table><br>
	<table border='0' align='center'><tr><td><input class='buton' type="button" name="ok" value="Asignar" onClick="cr.action='asign-validador2.php';cr.submit()" ></td></tr></table>

	</form>
	<center></center>

</BODY>
</HTML>
