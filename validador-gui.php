<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_valid.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
 	 	var url;
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	</SCRIPT>

 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
		<input type="hidden" name="prof">
	</form>

<?php include("theader.php")?>
<table align="center" width="95%" border='0' style="border-style:solid; border: 1px solid lightgray;" cellspacing='0' >
	<tr>
		<td colspan='4' align='center' class='literatura'><font size='+1'> SERVICIO DE REGISTRO DE PROFESIONALES</font></td>
		<td nowrap align='center' class='userbox'><font size='-1'> Usuari@:&nbsp;<?php echo $_SESSION['user']?> &nbsp;<img src='image/ic_person.png'></font> </td>
	</tr>
	<tr>
		<td  title="Refrescar Contenidos" onClick="cher.target='_self';cher.action='validador-gui.php';cher.submit();" class='menubar' align="center" onMouseOver="swap('reloadwi.png','reloadw.png','rld');overTD(this,'#d9dbdd');" onMouseOut="swap('reloadw.png','reloadwi.png','rld');outTD(this,'');">
			<a href="Javascript:"><img name='rld' height='20' src='image/reloadw.png' alt='refrescar pantalla' title='Refrescar pantalla'><!--Refrescar--></a>
		</td>
		<td align="center" align='center' class='menubar' title="Manual del Usuario">
<?php /*			<a href="JavaScript:" onClick="abrir('https://docs.google.com/document/d/1w7NmR8Tx6xxbsJJ3eqfIseCf31sKk5AGJIb1ePDh8zo/edit?usp=sharing','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a>*/?>
			<a href="JavaScript:" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME'];?>/manual/MANUAL-USO-INTERNO.pdf','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a>
		</td>
		<td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
			<H1>  Usuario T&eacute;cnico: <?php echo format_cont_db('username',$_SESSION['user']) ?>  <!-- VALIDACION DE SOLICITUDES DE REGISTRO--> </H1> 
		<!--<center><img style="width: 50%;" src='image/proces2.png'></center>-->
		</td>
		<td align="center" align='center' class='menubar'  title="Cambiar Constrase&ntilde;a">
			<a href="JavaScript:" onClick="abrir('','cpw',ancho,alto,0);cher.target='cpw';cher.action='chpwd.php';cher.submit();return false;"><img src="image/https_w_18dp.png">Cambiar Contrase&ntilde;a</a>
		</td>
		<td  title="Cerrar Sesi&oacute;n" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.target='_self';cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};" class='menubar' width='15%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" >Salir<img src='image/exit_18dp.png'></a></td>
	</tr>
</table>
<hr>
	<strong>Haga click en <img src='image/downa.png' border='0' height='13'> para desplegar el men&uacute;</strong><br>
<?php
	$sql_us_maneja_ = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$_SESSION['user']."'" );
	$sql_us_maneja_->setFetchMode(PDO::FETCH_ASSOC);
	if($sql_us_maneja_->rowCount()>1){
		$twidth='66%';
		$tdwidth='33%';
	}else{
		$twidth='33%';
		$tdwidth='33%';
	};

?>
<TABLE border='0' cellpadding='2' cellspacing='0' width='<?php echo $twidth?>'>
	<tr valign='top'>
<?php
	$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	foreach($_sql_us_maneja as $us_maneja) {
		$usm=$us_maneja['TipoProfesional_TipoProfesionalId'];

        $sxval = $db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=0 and AccionEnPostulacionActiva=1 ) and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId=".$usm.")");
        $xval=$sxval->fetch(PDO::FETCH_ASSOC);
		$xasb='';
		if ($xval['tot']>0){
			$xasb="<img src='image/ball_r.gif' alt='Acciones Pendientes!!'>";
		};

        $syaval = $db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=1 and AccionEnPostulacionActiva=1 )  and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId='".$usm."')");
        $yaval=$syaval->fetch(PDO::FETCH_ASSOC);


        $sregis_ = $db->query("SELECT count(RegistroPCodigo) as tot FROM RegistroP WHERE RegistroPProfesionalID=".$usm." ORDER BY RegistroPCodigo ASC ");
        $regis=$sregis_->fetch(PDO::FETCH_ASSOC);

#		$ssoli = $db->query("SELECT count(t1.idProfesional) as tot FROM Profesional as t1, Postulacion as t2 WHERE  t1.idProfesional=t2.Profesional_idProfesional and t2.PostulacionEstado=0 and t1.TipoProfesional_TipoProfesionalId=".$usm);
		$ssoli = $db->query("SELECT count(t1.idProfesional) as tot FROM Profesional as t1, Profesiones as t2, Postulacion as t3 WHERE  t1.idProfesional=t2.Profesional_idProfesional and (t3.PostulacionEstado=0 and t3.Profesiones_idProfesiones=t2.idProfesiones) and t2.TipoProfesional_TipoProfesionalId=".$usm);
		$soli=$ssoli->fetch(PDO::FETCH_ASSOC);

#        $smigra = $db->query("SELECT count(idProfesional) as tot FROM Profesional WHERE ProfesionalActualizo=0 and TipoProfesional_TipoProfesionalId=".$usm);
#        $migra=$smigra->fetch(PDO::FETCH_ASSOC);

?>
		<td class='cajita' width="<?php echo $tdwidth ?>" align='center'>
			<a href="JavaScript:" onClick="if(db<?php echo $usm;?>.vis.value==0){expandit2('ddb<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_<?php echo $usm;?>');db<?php echo $usm;?>.vis.value=1;}else{expandit2('ddb<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_<?php echo $usm;?>');db<?php echo $usm;?>.vis.value=0};return false;">
				<img name='xp_<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
				<?php echo format_cont_db('TipoProfesionalId',$usm) ?>&nbsp;<?php echo $xasb;?></a>
			<DIV id='ddb<?php echo $usm;?>' style="DISPLAY:none; head: ;" >
				<TABLE border='0' cellpadding='4' cellspacing='0' align='left'><tr>
					<td class='menuitem' onClick="if(dbx<?php echo $usm;?>.vis.value==0){op_act('td-dbx<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbx<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=1;document.getElementById('dbx<?php echo $usm;?>').submit();return false;}else{op_act('td-dbx<?php echo $usm;?>','#ffffff','bold');expandit2('ddbx<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;
						<a id='td-dbx<?php echo $usm;?>' href="JavaScript:" >
							<img name='xp_dbx<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						Solicitudes por Revisar: <?php echo $xval['tot']?>&nbsp;<?php echo $xasb;?></a>
					</td></tr>
<!--				</table>
				<TABLE border='0' cellpadding='4'><tr><td>&nbsp;&nbsp;&nbsp;</td>-->
					<tr><td class='menuitem' onClick="if(dbv<?php echo $usm;?>.vis.value==0){op_act('td-dbv<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbv<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbv<?php echo $usm;?>');dbv<?php echo $usm;?>.vis.value=1;document.getElementById('dbv<?php echo $usm;?>').submit();return false;}else{op_act('td-dbv<?php echo $usm;?>','#ffffff','bold');expandit2('ddbv<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbv<?php echo $usm;?>');dbv<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;
						<a id='td-dbv<?php echo $usm;?>' href="JavaScript:" >
							<img name='xp_dbv<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
							&nbsp;Solicitudes Revisadas: <?php echo $yaval['tot']?> &nbsp;</a>
					</td></tr>
<!--				</table>
				<TABLE border='0' cellpadding='4'><tr><td>&nbsp;&nbsp;&nbsp;</td>-->
					<tr><td class='menuitem' onClick="if(dbr<?php echo $usm;?>.vis.value==0){op_act('td-dbr<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbr<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbr<?php echo $usm;?>');dbr<?php echo $usm;?>.vis.value=1;document.getElementById('dbr<?php echo $usm;?>').submit();return false;}else{op_act('td-dbr<?php echo $usm;?>','#ffffff','bold');expandit2('ddbr<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbr<?php echo $usm;?>');dbr<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;
						<a id='td-dbr<?php echo $usm;?>' href="JavaScript:" >
							<img name='xp_dbr<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
							&nbsp;Profesionales Registrados: <?php echo $regis['tot']?> &nbsp;</a>
					</td></tr>
<!--				</table> 
				<TABLE border='0' cellpadding='4'><tr><td>&nbsp;&nbsp;&nbsp;</td>-->
					<tr><td class='menuitem' onClick="if(dbp<?php echo $usm;?>.vis.value==0){op_act('td-dbp<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbp<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbp<?php echo $usm;?>');dbp<?php echo $usm;?>.vis.value=1;document.getElementById('dbp<?php echo $usm;?>').submit();return false;}else{op_act('td-dbp<?php echo $usm;?>','#ffffff','bold');expandit2('ddbp<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbp<?php echo $usm;?>');dbp<?php echo $usm;?>.vis.value=0};return false;">			<!--DIV PROFESIONALES SOLICITANTES-->&nbsp;&nbsp;&nbsp;
						<a id='td-dbp<?php echo $usm;?>' href="JavaScript:" >
							<img name='xp_dbp<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
							&nbsp;Solicitudes en Proceso: <?php echo $soli['tot']?> &nbsp;</a>
					</td></tr>
<!--				</table> 

				<TABLE border='0' cellpadding='4'><tr><td>&nbsp;&nbsp;&nbsp;</td>-->
<?php /*?>					<tr><td class='menuitem' onClick="if(dbmi<?php echo $usm;?>.vis.value==0){op_act('td-dbmi<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbmi<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbmi<?php echo $usm;?>');dbmi<?php echo $usm;?>.vis.value=1;document.getElementById('dbmi<?php echo $usm;?>').submit();return false;}else{op_act('td-dbmi<?php echo $usm;?>','#ffffff','bold');expandit2('ddbmi<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbmi<?php echo $usm;?>');dbmi<?php echo $usm;?>.vis.value=0};return false;">			<!--DIV PROCESO MIGRACION-->&nbsp;&nbsp;&nbsp;
						<a id='td-dbmi<?php echo $usm;?>' href="JavaScript:">
							<img name='xp_dbmi<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
							&nbsp;Actualizaci&oacute;n Datos Proceso Migraci&oacute;n: <?php echo $migra['tot']?> &nbsp;</a>
					</td></tr><?php */?>
				</table> 
				<form id="db<?php echo $usm;?>">
					<input type='hidden' name='vis' value='0'>
				</form>
			</div><script>expandit2("ddb<?php echo $usm;?>",0) </script>
		</td>
<?php
	};
?>
	</tr>
</table>
<?php

#	$sql_us_maneja = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$_SESSION['user']."'" );
	foreach($_sql_us_maneja as $us_maneja) {
		$usm=$us_maneja['TipoProfesional_TipoProfesionalId'];
?>
			<DIV id='ddbx<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbx<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbx<?php echo $usm;?>" target='idbx<?php echo $usm;?>' action="validador-gui-xvalidar.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbx<?php echo $usm;?>",0) </script>
			<DIV id='ddbv<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbv<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbv<?php echo $usm;?>" target='idbv<?php echo $usm;?>' action="validador-gui-validado.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbv<?php echo $usm;?>",0) </script>
			<DIV id='ddbr<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbr<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbr<?php echo $usm;?>" target='idbr<?php echo $usm;?>' action="verificador-gui-registrado.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbr<?php echo $usm;?>",0) </script>
			<DIV id='ddbp<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbp<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbp<?php echo $usm;?>" target='idbp<?php echo $usm;?>' action="list-post.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbp<?php echo $usm;?>",0) </script>			<!--DIV PROFESIONALES SOLICITANTES-->
<?php /*?>
			<DIV id='ddbmi<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbmi<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbmi<?php echo $usm;?>" target='idbmi<?php echo $usm;?>' action="list-migracion.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div>			<!--DIV PROCESO MIGRACION--><?php */?>
<br>
<?php
	};
	include ('footer.php');

	$db=null;
exit;
?>
