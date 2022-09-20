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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_dejec.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type='hidden' name='basecod' >
        </form>
<?php include("theader.php")?>
<table align="center" width="95%" border='0' style="border-style:solid; border: 1px solid lightgray;" cellspacing='0'>
	<tr>
		<td colspan='4' align='center' class='literatura'><font size='+1'> SERVICIO DE REGISTRO DE PROFESIONALES </font></td>
		<td nowrap align='center' class='userbox'><font size='-1'> Usuari@:&nbsp;<?php echo $_SESSION['user']?> &nbsp;<img src='image/ic_person.png'></font> </td>
	</tr>
	<tr>
		<td title="Refrescar Contenidos" onClick="cher.target='_self';cher.action='director-gui.php';cher.submit();" class='menubar' align="center" onMouseOver="swap('reloadwi.png','reloadw.png','rld');overTD(this,'#d9dbdd');" onMouseOut="swap('reloadw.png','reloadwi.png','rld');outTD(this,'');" >
			<a href="Javascript:"><img name='rld' height='15' src='image/reloadw.png' alt='refrescar pantalla' title='Refrescar pantalla'><!--Refrescar--></a>
		</td>
		<td nowrap align="center" align='center' class='menubar' title="Manual del Usuario">
<?php /*			<a href="JavaScript:" onClick="abrir('https://docs.google.com/document/d/1w7NmR8Tx6xxbsJJ3eqfIseCf31sKk5AGJIb1ePDh8zo/edit?usp=sharing','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a>*/?>
			<a href="JavaScript:" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME']; ?>/manual/MANUAL-USO-INTERNO.pdf','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a>
		</td>
		<td  align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
			<H1>DESPACHO DE SOLICITUDES DE REGISTRO Y NOTIFICACI&Oacute;N A SOLICITANTES</H1> 
			<!--<center><img style="width: 50%;" src='image/proces3-5.png'></center>-->
		</td>
		<td nowrap align="center" align='center' class='menubar' title="Cambiar Constrase&ntilde;a">
			<a href="JavaScript:" onClick="abrir('','cpw',ancho,alto,0);cher.target='cpw';cher.action='chpwd.php';cher.submit();return false;"><img src="image/https_w_18dp.png">Cambiar Contrase&ntilde;a</a>
		</td>
		<td title="Cerrar Sesi&oacute;n" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.target='_self';cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};" class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" >Salir<img src='image/exit_18dp.png'></a></td>
	</tr>
</table>
<hr>
	<strong>Haga click en <img src='image/downa.png' border='0' height='13'> para desplegar el men&uacute;</strong><br>
<?php
	$sql_us_maneja_ = $db->query("SELECT TipoProfesionalId FROM TipoProfesional " );
	$sql_us_maneja_->setFetchMode(PDO::FETCH_ASSOC);
	if($sql_us_maneja_->rowCount()>1){
		$twidth='66%';
		$tdwidth='33%';
	}else{
		$twidth='33%';
		$tdwidth='33%';
	};
?>
	<TABLE border='0' cellpadding='2' cellspacing='0' width='<?php echo $twidth?>'><tr valign='top'>
<?php
	$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	foreach($_sql_us_maneja as $us_maneja) {
	$usm=$us_maneja['TipoProfesionalId'];

	$spxdesp = $db->query("SELECT count(t1.idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2  WHERE (t1.PostulacionEstado=0 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL and t1.PostulacionAprobado IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$usm."')");
	$pxdesp=$spxdesp->fetch(PDO::FETCH_ASSOC);
	$xdeb='';
	if ($pxdesp['tot']>0){
		$xdeb="<img src='image/ball_r.gif'>";
	};

	$sdesp = $db->query("SELECT count(t1.idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionEstado=1 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL and t1.PostulacionAprobado IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$usm."')");
	$desp=$sdesp->fetch(PDO::FETCH_ASSOC);

	$sregis = $db->query("SELECT count(RegistroPCodigo) as tot FROM RegistroP WHERE RegistroPProfesionalID=".$usm." ORDER BY RegistroPCodigo ASC ");
	$regis=$sregis->fetch(PDO::FETCH_ASSOC);

	$ssoli = $db->query("SELECT count(t1.idProfesional) as tot FROM Profesional as t1, Profesiones as t2, Postulacion as t3 WHERE  t1.idProfesional=t2.Profesional_idProfesional and (t3.PostulacionEstado=0 and t3.Profesiones_idProfesiones=t2.idProfesiones) and t2.TipoProfesional_TipoProfesionalId=".$usm);
	$soli=$ssoli->fetch(PDO::FETCH_ASSOC);


?>
	<td class='cajita' width='<?php echo $tdwidth?>' align='center' ><!--DIV PRINCIPAL AREA-->
			<a href="JavaScript:" onClick="if(db<?php echo $usm;?>.vis.value==0){expandit2('ddb<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_<?php echo $usm;?>');db<?php echo $usm;?>.vis.value=1;}else{expandit2('ddb<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_<?php echo $usm;?>');db<?php echo $usm;?>.vis.value=0};return false;">
				<img name='xp_<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
				<?php echo format_cont_db('TipoProfesionalId',$usm); ?>&nbsp;<?php echo $xdeb;?>&nbsp;</a>
		<DIV id='ddb<?php echo $usm;?>' style="DISPLAY:none; head: ;" >
			<TABLE border='0' cellpadding='4' align='left'><tr>
				<td class='menuitem' onClick="if(dbx<?php echo $usm;?>.vis.value==0){expandit2('ddbx<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=1;op_act('td-dbx<?php echo $usm;?>','#FFFF99','bold');document.getElementById('dbx<?php echo $usm;?>').submit();return false;}else{expandit2('ddbx<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');op_act('td-dbx<?php echo $usm;?>','#ffffff','bold');dbx<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;			<!--DIV POR DESPACHAR-->
					<a href="JavaScript:"  id="td-dbx<?php echo $usm;?>">
						<img name='xp_dbx<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						Solicitudes por Despachar: <?php echo $pxdesp['tot']?> &nbsp;<?php echo $xdeb;?>&nbsp;</a>
				</td></tr>
<!--			</table>  
			<TABLE border='0' cellpadding='4'><tr><td>&</td>-->
				<td class='menuitem' onClick="if(dbd<?php echo $usm;?>.vis.value==0){expandit2('ddbd<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbd<?php echo $usm;?>');dbd<?php echo $usm;?>.vis.value=1;op_act('td-dbd<?php echo $usm;?>','#FFFF99','bold');document.getElementById('dbd<?php echo $usm;?>').submit();return false;}else{expandit2('ddbd<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbd<?php echo $usm;?>');op_act('td-dbd<?php echo $usm;?>','#ffffff','bold');dbd<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;			<!--DIV DESPACHADAS-->
					<a href="JavaScript:" id="td-dbd<?php echo $usm;?>">
						<img name='xp_dbd<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						&nbsp;Solicitudes Despachadas: <?php echo $desp['tot']?> &nbsp;</a>
				</td></tr>
<!--			</table>  
		<TABLE border='0' cellpadding='4'><tr><td></td>-->
				<td  class='menuitem' onClick="if(dbr<?php echo $usm;?>.vis.value==0){expandit2('ddbr<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbr<?php echo $usm;?>');dbr<?php echo $usm;?>.vis.value=1;op_act('td-dbr<?php echo $usm;?>','#FFFF99','bold');document.getElementById('dbr<?php echo $usm;?>').submit();return false;}else{expandit2('ddbr<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbr<?php echo $usm;?>');op_act('td-dbr<?php echo $usm;?>','#ffffff','bold');dbr<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;			<!--DIV PROFESIONALES REGISTRADOS-->
					<a href="JavaScript:" id="td-dbr<?php echo $usm;?>">
						<img name='xp_dbr<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						&nbsp;Profesionales registrados: <?php echo $regis['tot']?> &nbsp;</a>
				</td></tr>
<!--			</table>  
			<TABLE border='0' cellpadding='4'><tr><td></td>-->
				<td class='menuitem' onClick="if(dbp<?php echo $usm;?>.vis.value==0){expandit2('ddbp<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbp<?php echo $usm;?>');dbp<?php echo $usm;?>.vis.value=1;op_act('td-dbp<?php echo $usm;?>','#FFFF99','bold');document.getElementById('dbp<?php echo $usm;?>').submit();return false;}else{expandit2('ddbp<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbp<?php echo $usm;?>');op_act('td-dbp<?php echo $usm;?>','#ffffff','bold');dbp<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;			<!--DIV PROFESIONALES SOLICITANTES-->
					<a href="JavaScript:" id="td-dbp<?php echo $usm;?>">
						<img name='xp_dbp<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						&nbsp;Solicitudes en Proceso: <?php echo $soli['tot']?> &nbsp;</a>
				</td></tr>
			</table> 
<?php /*
?>
			<TABLE border='0' cellpadding='4'><tr><td></td>
				<td class='menuitem' onClick="if(dbmi<?php echo $usm;?>.vis.value==0){expandit2('ddbmi<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbmi<?php echo $usm;?>');dbmi<?php echo $usm;?>.vis.value=1;document.getElementById('dbmi<?php echo $usm;?>').submit();return false;}else{expandit2('ddbmi<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbmi<?php echo $usm;?>');dbmi<?php echo $usm;?>.vis.value=0};return false;">&nbsp;&nbsp;&nbsp;			<!--DIV PROCESO MIGRACION-->
					<a href="JavaScript:">
						<img name='xp_dbmi<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
						&nbsp;[Actualizaci&oacute;n Datos Proceso Migraci&oacute;n:]&nbsp;</a>
				</td></tr>
			</table> 
<?php
*/
?>
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
	$sql_us_maneja = $db->query("SELECT TipoProfesionalId FROM TipoProfesional " );
	foreach($_sql_us_maneja as $us_maneja) {
		$usm=$us_maneja['TipoProfesionalId'];
?>
			<DIV id='ddbx<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbx<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbx<?php echo $usm;?>" target='idbx<?php echo $usm;?>' action="director-gui-xdespachar.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbx<?php echo $usm;?>",0) </script>				<!--DIV POR DESPACHAR-->
			<DIV id='ddbd<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbd<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbd<?php echo $usm;?>" target='idbd<?php echo $usm;?>' action="director-gui-despachado.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbd<?php echo $usm;?>",0) </script>			<!--DIV ASIGNADAS-->
			<DIV id='ddbr<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbr<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbr<?php echo $usm;?>" target='idbr<?php echo $usm;?>' action="verificador-gui-registrado.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
				</form>
			</div><script>expandit2("ddbr<?php echo $usm;?>",0) </script>			<!--DIV PROFESIONALES REGISTRADOS-->
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
<?php /*
?>
			<DIV id='ddbmi<?php echo $usm;?>' style="DISPLAY:none; head: ;" ><br>
				<iframe name='idbmi<?php echo $usm;?>' frameborder='0'  height='600' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbmi<?php echo $usm;?>" target='idbmi<?php echo $usm;?>' action="list-migracion.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
				</form>
			</div>			<!--DIV PROCESO MIGRACION-->
<?php

*/
?>

<?php
	};
?>
<br>
<?php
	include ('footer.php');

$db=null;
exit;
?>
