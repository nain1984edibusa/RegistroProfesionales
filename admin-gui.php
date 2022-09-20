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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="usr_">
        </form>
<?php include("theader.php")?>
<table align="center" width="100%" border='0' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
	<tr>
		<td colspan='3' align='center' class='literatura'><font size='+1'> SERVICIO DE REGISTRO DE PROFESIONALES INPC - ADMINISTRACI&Oacute;N APLICATIVO</font></td>
		<td colspan='2' nowrap align='center' class='userbox'><font size='-1'> Usuari@:&nbsp;<?php echo $_SESSION['user']?> &nbsp;</font><img src='image/ic_person.png'> </td>
	</tr>
		<tr>
			<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="cher.target='_self';cher.action='admin-gui.php';cher.submit();">
				<a href="Javascript:"><img name='rld' height='15' src='image/reloadw.png' alt='refrescar pantalla' title='Refrescar pantalla'><!--Refrescar--></a>
			</td>
			<td nowrap align="center" align='center' class='menubar' title="Manual del Usuario" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME']; ?>/manual/MANUAL-ADMINISTRADOR.pdf','help',ancho,alto,0);return false;">
				<a href="JavaScript:" ><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a>
			</td>
			<td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><br>
				<table border='0' width='50%' cellspacing='1'  class='menubar'>
					<tr bgcolor='#ffffff' align='center' >
						<td><b>Administraci&oacute;n Usuarios:</b></td>
						<td><b>Administraci&oacute;n de Par&aacute;metros:</b></td>
					</tr>
					<tr bgcolor='#ffffff'  align='center'>
						<td>&nbsp;<b><a class='info' href="Javascript:" onClick="abrir('','new_usr',ancho,alto/2,0);cher.target='new_usr'; cher.subsys.value='new';cher.action='users-gui.php';cher.submit();">Nuevo Usuario</a></b> 
						</td>
						<td><b><a class='info' href="Javascript:" onClick="abrir('','new_tipo',ancho,alto/2,0);cher.target='new_tipo';cher.action='tipop-gui.php';cher.submit();">Nueva Categor&iacute;a Profesional</a></b></td>
					</tr>
				</table><br>
			</td>
			<td align="center" align='center' class='menubar'  title="Cambiar Constrase&ntilde;a">
				<a href="JavaScript:" onClick="abrir('','cpw',ancho,alto,0);cher.target='cpw';cher.action='chpwd.php';cher.submit();return false;"><img src="image/https_w_18dp.png">Contrase&ntilde;a</a>
			</td>
			<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.target='_self';cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};">
				<a href="Javascript:" >Salir<img src='image/exit_18dp.png'></a>
			</td>
		</tr>
</table>
<hr>
<table border='0' width='30%'><tr> <td width='30%' class='cajita' onClick="if(ftipop.vis.value==0){swap('upa.png','downa.png','xp_cp');expandit2('ditipop',1);ftipop.vis.value=1;document.getElementById('ftipop').submit();}else{swap('upa.png','downa.png','xp_cp');expandit2('ditipop',0);ftipop.vis.value=0};return false;"><b><a href="JavaScript:" ><img name="xp_cp" src="image/downa.png" border='0' height="13" >&nbsp;Editar Categor&iacute;as Profesionales</a>&nbsp; </b></td></tr></table>
<DIV id='ditipop' style="DISPLAY:none; head: ;" >
	<iframe name='itipop' frameborder='0'  height='205' width='100%' src="">
	  <p>Your browser does not support iframes.</p>
	</iframe>
	<form id="ftipop" target='itipop' action="admin-gui-tipop.php" method="post">
		<input type='hidden' name='vis' value='0'>
		<input type='hidden' name='pagina' value="0">
	</form>
</div><script>expandit2('ditipop',0)</script>
<table border='0' width='30%'><tr> <td width='30%' class='cajita' onClick="if(iuser.vis.value==0){swap('upa.png','downa.png','xp_us');expandit2('diusers',1);iuser.vis.value=1;document.getElementById('iuser').submit();}else{swap('upa.png','downa.png','xp_us');expandit2('diusers',0);iuser.vis.value=0};return false;"><b><a href="JavaScript:" ><img name="xp_us" src="image/downa.png" border='0' height="13" >&nbsp;Editar Usuarios INPC</a>&nbsp; </b></td></tr></table>
<DIV id='diusers' style="DISPLAY:none; head: ;" >
	<iframe name='iusers' frameborder='0'  height='405' width='100%' src="">
	  <p>Your browser does not support iframes.</p>
	</iframe>
	<form id="iuser" target='iusers' action="admin-gui-users.php" method="post">
		<input type='hidden' name='vis' value='0'>
		<input type='hidden' name='pagina' value="0">
	</form>	
</div><script>expandit2('diusers',0)</script>
<table border='0' width='30%'><tr> <td width='30%' class='cajita' onClick="if(iuserp.vis.value==0){swap('upa.png','downa.png','xp_usp');expandit2('diusersp',1);iuserp.vis.value=1;document.getElementById('iuserp').submit();}else{swap('upa.png','downa.png','xp_usp');expandit2('diusersp',0);iuserp.vis.value=0};return false;"><b><a href="JavaScript:"><img name="xp_usp" src="image/downa.png" border='0' height="13" >&nbsp;Editar Profesionales Solicitantes&nbsp;</a> </b></td></tr></table>
<DIV id='diusersp' style="DISPLAY:none; head: ;" >
	<iframe name='iusersp' frameborder='0'  height='405' width='100%' src="">
	  <p>Your browser does not support iframes.</p>
	</iframe>
	<form id="iuserp" target='iusersp' action="admin-gui-userp.php" method="post">
		<input type='hidden' name='vis' value='0'>
		<input type='hidden' name='pagina' value="0">
	</form>	
</div><script>expandit2('diusersp',0)</script>
<br><br>

<?php
	include ('footer.php');
$db=null;
exit;
?>
