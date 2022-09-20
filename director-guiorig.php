<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
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
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js">
	 </SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_dejec.js">
	 </SCRIPT>
 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type='hidden' name='basecod' >
        </form>
<b><table border='0' width='89%' align='center' background='image/web2014.png'>
	  	     <tr valign='top' class='menu_'>
                        <td width='80%' align='center'><font size='+1'><div class='cajita'>SERVICIO DE REGISTRO DE PROFESIONALES INPC </div> </font>
                        </td>
                        <td width='20%' align='right'><div class='literatura2'><br> Sesion Usuario:&nbsp;&nbsp;<?php echo $_SESSION['user']?> &nbsp;<br></div> 
                        </td>
                </tr>
        </table> </b><HR>
<?php
	$sql_us_maneja = $db->query("SELECT TipoProfesionalId FROM TipoProfesional " );	
	
#	$_SESSION['us_maneja']=$us_maneja['TipoProfesional_TipoProfesionalId'];
?>
<table align="center" width="100%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
                <tr>
                        <td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="Javascript:"><font size='+1'>INICIO</font></a>
                        </td>
                        <td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
                        <H1>DESPACHO DE SOLICITUDES DE REGISTRO Y NOTIFICACION A SOLICITANTES</H1> 
                        <table border='0' cellspacing='4' cellpadding='3' class='menubar'>
<!--                        	<tr bgcolor='#ffffff'>
                        		<td><b>Administraci&oacute;n Usuarios:</b></td>
                        		<td><b>Administraci&oacute;n de Par&aacute;metros:</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        	</tr>-->
                        	<tr bgcolor='#ffffff'>
                        		<td>&nbsp;<b><a href="Javascript:" onClick="cher.target='_self';cher.action='director-gui.php';cher.submit();">[Refresca listado]</a></b></td>
<!--                        		<td><b></b></td>
                        		<td><b></b></td>
                        		<td><b></b></td>
                        		<td><b></b></td>-->
                        	</tr>
                        </table><br><br>
    			 		</td>
                    	<td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};"><font size='+1'>Salir</font></a>
                        </td>
                </tr>
                </table>
                <hr>

<?php
	while($us_maneja = $sql_us_maneja->fetch(PDO::FETCH_ASSOC)) {
?>
	<br><br><br><TABLE border='1'   width='100%'><tr><td>
                <table border='0' class='cajita'><tr><td><strong>BASE DE DATOS: <?php echo format_cont_db('TipoProfesionalId',$us_maneja['TipoProfesionalId']) ?> </strong> </td> </tr></table>
<?php
			$stfac = $db->query("SELECT * FROM Postulacion WHERE PostulacionEstado=0 and PostulacionAsignado=1 and PostulacionVerificado=1 and PostulacionFechaD IS NOT NULL and PostulacionAprobado IS NOT NULL");
?>
	<br><br><br>
		<center><strong><font size='+1'>SOLICITUDES DE REGISTRO VERIFICADAS POR DESPACHAR: </font> </strong></center>
		<table border='1' width ='90%' align='center' cellpadding='5' cellspacing='5' class='seccion1'>
			<tr bgcolor='#ffffff'>
				<tH><B>Solicitante:</b></th>
				<th><b>Fecha Solicitud:</b></th>
				<th><b>Validador Asignado:</b></th>
				<th><b>Fecha Asignaci&oacute;n :</b></th>
				<th><b>Fecha validaci&oacute;n:</b></th>
				<th><b>Informe T&eacute;nico:</b></th>
				<th><b>Respuesta a Solicitud:</b></th>
				<th><b>Acciones:</b></th>
			</tr>
<?php
			while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
				$st_tipro= $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$row['Profesional_idProfesional']."'");
				$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);
				if ($stipro['TipoProfesional_TipoProfesionalId']==$us_maneja['TipoProfesionalId']){
					$st_val_as = $db->query("SELECT user_username,AccionEnPostulacionFechaAs FROM AccionEnPostulacion WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
					$val_as= $st_val_as->fetch(PDO::FETCH_ASSOC);
					$st_inf_te = $db->query("SELECT * FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
					$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);
					$st_inf_sr = $db->query("SELECT * FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
#					if ($st_inf_te->rowCount()){
#						$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);print_r($inf_te);
#					};					
#					if ($st_inf_sr->rowCount()){
#						$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);
#					};
					$fname='fr_'.$row['idPostulacion'];

?>
			<tr bgcolor='#ffffff'>
				<td><?php echo format_cont_db('idProfesional',$row['Profesional_idProfesional'])?></td>
				<td nowrap><?php echo $row['PostulacionFechaI']?></td>
				<td><?php echo format_cont_db('username',$val_as['user_username'])?></td>
				<td nowrap><?php echo $val_as['AccionEnPostulacionFechaAs']?></td>
				<td nowrap><?php echo $row['PostulacionFechaV']?></td>
				<td>
					Referencia a Documento F&iacute;sico: <br>
					<b><?php echo $inf_te['InformeTecnicoRefDoc']?>.</b><br> <br>
					Observaci&oacute;n / Resumen:<br>
					<b><?php echo $inf_te['InformeTecnicoObservacion']?>.
				</td>
				<td <?php if (!$st_inf_sr->rowCount()){ echo "bgcolor='#dddddd'";};?> >
					<b><?php echo strtoupper($inf_te['InformeTecnicoRecomendacion'])?> </b>
					<form name='<?php echo $fname?>' method='POST'>
						<input type='hidden' name='idprof' value='<?php echo $row['Profesional_idProfesional']?>'>
						<input type='hidden' name='idpost' value='<?php echo $row['idPostulacion']?>'>
						<input type='hidden' name='res_post' value='<?php echo $inf_te['InformeTecnicoRecomendacion']?>'>
						<input type='hidden' name='us_maneja' value='<?php echo $stipro['TipoProfesional_TipoProfesionalId']?>'>
						<input type='hidden' name='cod_pro' value='<?php echo $inf_te['InformeTecnicoCodPro']?>'>

<?php
					if($inf_te['InformeTecnicoRecomendacion']=='aprobada'){
						echo "C&oacute;digo Registro Propuesto: <b>".$inf_te['InformeTecnicoCodPro']."</b><br>";
					};
					if ($st_inf_sr->rowCount() < 1){
?>
						<br> Ref. Oficio Respuesta: ....
						<br><input type='text' size='20' maxlength='20' name='resp-ref' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
						<br>Resumen:<br>
						<textarea title='Arrastre esq. inf. derecha para agrandar/achicar' rows="3" cols="20" name='obsr' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"></textarea>
<?php
					}else{
						$inf_sr= $st_inf_sr->fetch(PDO::FETCH_ASSOC);
?>
						Referencia a Documento F&iacute;sico: <br>
						<b><?php echo $inf_sr['SolicitudRespuestaRefDoc']?></b><br> <br>
						Observaci&oacute;n / Resumen:<br>
						<b><?php echo $inf_sr['SolicitudRespuestaResumen']?>

<?php
					};
?>
					</form>
				</td>
				<td nowrap align='center'>
<?php
					if ($st_inf_sr->rowCount() < 1){
?>
						<a href="JavaScript:" onClick="if(validate('<?php echo $fname?>')){cher.target='_self';<?php echo $fname?>.action='despachar-post.php';<?php echo $fname?>.submit();};return false;">[Notificar a Solicitante]</a>
<?php
					}else{
?>
						<a href="JavaScript:" onClick="if(confirm('Esta seguro de la informacion ingresada?\nEsta accion no puede ser revertida')){cher.target='_self';<?php echo $fname?>.action='despachar-post.php';<?php echo $fname?>.submit();};return false;">[Notificar a Solicitante]</a>

<?php
					};
?>
				</td>
			</tr>
<?php
				};
			};//FIN POR DESPACHAR

?>
		</table><br><br>
<?php

		$stfac = $db->query("SELECT * FROM Postulacion WHERE PostulacionEstado=1 and PostulacionAsignado=1 and PostulacionVerificado=1 and PostulacionFechaD IS NOT NULL and PostulacionAprobado IS NOT NULL");
?>
	<br><br><br>
	<center><strong><font size='+1'>SOLICITUDES DE REGISTRO DESPACHADAS: </font> </strong></center>
	<table border='1' width ='90%' align='center' cellpadding='5' cellspacing='5' class='seccion1'>
		<tr bgcolor='#ffffff'>
			<tH><B>Solicitante:</b></th>
			<th><b>Fecha Solicitud:</b></th>
			<th><b>Validador Asignado:</b></th>
			<th><b>Fecha Asignaci&oacute;n :</b></th>
			<th><b>Fecha validaci&oacute;n:</b></th>
			<th><b>Informe T&eacute;nico:</b></th>
			<th><b>Respuesta a Solicitud:</b></th>
			<!--<th><b>Acciones:</b></th>-->
		</tr>
<?php
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$st_tipro= $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$row['Profesional_idProfesional']."'");
		$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);
		if ($stipro['TipoProfesional_TipoProfesionalId']==$us_maneja['TipoProfesionalId']){
			$st_val_as = $db->query("SELECT user_username,AccionEnPostulacionFechaAs FROM AccionEnPostulacion WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
			$val_as= $st_val_as->fetch(PDO::FETCH_ASSOC);
			$st_inf_te = $db->query("SELECT * FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
			$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);
			$st_inf_sr = $db->query("SELECT * FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
#			if ($st_inf_te->rowCount()){
#				$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);print_r($inf_te);
#			};					
#			if ($st_inf_sr->rowCount()){
#				$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);
#			};
			$fname='fr_'.$row['idPostulacion'];

?>
		<tr bgcolor='#ffffff'>
			<td><?php echo format_cont_db('idProfesional',$row['Profesional_idProfesional'])?></td>
			<td nowrap><?php echo $row['PostulacionFechaI']?></td>
			<td><?php echo format_cont_db('username',$val_as['user_username'])?></td>
			<td nowrap><?php echo $val_as['AccionEnPostulacionFechaAs']?></td>
			<td nowrap><?php echo $row['PostulacionFechaV']?></td>
			<td>
				Referencia a Documento F&iacute;sico: <br>
				<b><?php echo $inf_te['InformeTecnicoRefDoc']?>...</b><br> <br>
				Observaci&oacute;n / Resumen:<br>
				<b><?php echo $inf_te['InformeTecnicoObservacion']?>....
			</td>
			<td <?php if (!$st_inf_sr->rowCount()){ echo "bgcolor='#dddddd'";};?> >
				<b><?php echo strtoupper($inf_te['InformeTecnicoRecomendacion'])?> </b>
<?php
			if($inf_te['InformeTecnicoRecomendacion']=='aprobada'){
				echo "C&oacute;digo Registro Propuesto: <b>".$inf_te['InformeTecnicoCodPro']."</b><br>";
			};
			$inf_sr= $st_inf_sr->fetch(PDO::FETCH_ASSOC);
?>
				Referencia a Documento F&iacute;sico: <br>
				<b><?php echo $inf_sr['SolicitudRespuestaRefDoc']?></b><br> <br>
				Observaci&oacute;n / Resumen:<br>
				<b><?php echo $inf_sr['SolicitudRespuestaResumen']?>
			</td>
			<!--<td nowrap align='center'>
				<a href="JavaScript:" onClick="if(validate('<?php echo $fname?>')){cher.target='_self';<?php echo $fname?>.action='despachar-post.php';<?php echo $fname?>.submit();};return false;">[Notificar a Solicitante]</a>
			</td>-->
		</tr>
<?php
		};
	};
?>
		</table><br><br></td></tr></table>
 <hr>

<?php
	};
			$stfac = $db->query("SELECT * FROM user WHERE TipoUsuario_idTipoUsuario = 3");
?>
	<br><br><br>
                <center><strong><font size='+1'>Profesionales Solicitantes </font> </strong></center>
                <table border='1' width ='80%' align='center' cellpadding='5' cellspacing='5' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH><B>USUARIO:</b>
								</th>
								<th><b>NOMBRE REAL:</b>
								</th>
								<th><b>CORRREO ELECTR&Oacute;NICO:</b>
								</th>
								<th><b>CORRREO ELECTR&Oacute;NICO 2:</b>
								</th>
							</tr>
<?php
			while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
?>
                        <tr bgcolor='#ffffff'>
			    <td><?php echo $row['username']?>
                            </td>
                            <td><?php echo $row['realname']?>
                            </td>
                             <td><?php echo $row['email']?>
                            </td>
                            <td><?php echo $row['email2']?>
                            </td>
           </tr>

<?php
			};
?>
	</table>
<?php
//echo $sql.'<br>'.$sql_us.'<br>';
exit;


$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
