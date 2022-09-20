<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	require_once ('session.php');

	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js">
         </SCRIPT>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js">
         </SCRIPT>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js">
         </SCRIPT>
 <HTML>
<?php
	$_stat_pos = $db->query("SELECT * FROM Postulacion WHERE Profesional_idProfesional ='".$_SESSION['user']."'");	
	   $stpos= $_stat_pos->fetch(PDO::FETCH_ASSOC);
?>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="usr_">
        </form>
<b><table border='0' width='89%' align='center' background='image/web2014.png'>
	  	     <tr valign='top' class='menu_'>
                        <td width='80%' align='center'><font size='+1'><div class='cajita'> Administraci&oacute;n </div> </font>
                        </td>
                        <td width='20' align='right'><div class='literatura2'><br> Sesion Usuario:<?php echo $_SESSION['user']?> <img src='image/ic_person.png'>&nbsp;</div> </font>
                        </td>
                </tr>
        </table> </b><HR>
<table align="center" width="100%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
                <tr>
                        <td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="Javascript:"><font size='+1'>INICIO</font></a>
                        </td>
                        <td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
                        <H1>ADMINSITRACION APLICATIVO [RPC-INPC]</H1> 
                        <table border='0' cellspacing='4'  class='menubar'>
                        	<tr bgcolor='#ffffff'>
                        		<td><b>Administraci&oacute;n Usuarios:</b></td>
                        		<td><b>Administraci&oacute;n de Par&aacute;metros:</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        	</tr>
                        	<tr bgcolor='#ffffff'>
                        		<td>&nbsp;<b><a href="Javascript:" onClick="abrir('','new_usr',ancho,alto/2,0);cher.target='new_usr'; cher.subsys.value='new';cher.action='users-gui.php';cher.submit();">[Nuevo Usuario]</a></b> 
                        		<b><a href="Javascript:" onClick="cher.target='_self';cher.action='admin-gui.php';cher.submit();">[Refresca listado]</a></b>
                        		</td>
                        		<td><b><a href="Javascript:" onClick="cher.target='_self';cher.action='admin-gui.php';cher.submit();">[C&oacute;digos Profesional]</a></b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        	</tr>
                        </table><br><br>
    			 		</td>
                    	<td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};"><font size='+1'>Salir</font></a>
                        </td>
                </tr>
                </table>
                <hr>

<?php
        $stfac = $db->query("SELECT * FROM user WHERE TipoUsuario_idTipoUsuario <> 3");
        //$stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='0602908170'");
?>
	<br><br><br>
                <center><strong><font size='+1'>Usuarios [INPC-RPC]</font> </strong></center>
                <table border='1' width ='90%' align='center' cellpadding='5' cellspacing='5' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH><B>USUARIO:</b>
								</th>
								<th><b>NOMBRE REAL:</b>
								</th>
								<th><b>TIPO USUARIO:</b>
								</th>
								<th><b>CORRREO(S) ELECTR&Oacute;NICO(S):</b>
								</th>
								<th><b>ATIENDE SOLICITUDES DE:</b>
								</th>
								<th><b>ESTADO:</b>
								</th>
								<th><b>Acciones:</b>
								</th>
							</tr>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
        	if($row['TipoUsuario_idTipoUsuario']!=1){
				$stpr = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$row['username']."'");
        		$fname='fr_'.$row['username'];
        	};

?>
                        <tr bgcolor='#ffffff'>
									<td><?php echo $row['username']?>
                            </td>
                            <td><?php echo $row['realname']?>
                            </td>
                            <td><?php echo format_cont_db('idTipoUsuario',$row['TipoUsuario_idTipoUsuario'])?>
                            </td>
                             <td><?php echo $row['email']?><br><?php echo $row['email2']?>
                            </td>
                            <td>
<?php
			if($row['TipoUsuario_idTipoUsuario']!=1){
				while($tiprof = $stpr->fetch(PDO::FETCH_ASSOC)){
					echo '-'.format_cont_db('TipoProfesionalId',$tiprof['TipoProfesional_TipoProfesionalId']).'<br>';
				};

				if ($row['TipoUsuario_idTipoUsuario']==5 or $row['TipoUsuario_idTipoUsuario']==4 /*and $stpr->rowCount()==0*/){
?>
	<a href="JavaScript:" onClick="if(<?php echo $fname?>.vis.value==0){expandit2('<?php echo $fname?>l',1);<?php echo $fname?>.vis.value=1;}else{expandit2('<?php echo $fname?>l',0);<?php echo $fname?>.vis.value=0};return false;">[+]</a>
								<DIV id='<?php echo $fname?>l' style="DISPLAY: none; head: ;background-color:#cccccc; " >
								<form name='<?php echo $fname?>' method='POST'><center> 
									<input type='hidden' name='vis' value='0'>
									<input type='hidden' name='usrn_' value='<?php echo $row['username']?>'>
									<?php load_of_db('TipoProfesionalId','')?><br>
									<input type="button" name="send" value="Agregar" onFocus="" onBlur="" onClick="if(confirm('Esta Seguro?')){<?php echo $fname?>.action='asigna-profesional.php';<?php echo $fname?>.submit();}">
								</center></form></div>
<?php
				}
			};
?>                             
                            </td>
                             <td><?php echo format_cont_db('userEstado',$row['userEstado']) ?>
                            </td>
                            <td  align='center'>&nbsp;<a href="JavaScript:" onClick="abrir('','edi_usr',ancho,alto/2,0);cher.usr_.value='<?php echo $row['username']?>';cher.target='edi_usr';cher.action='edita-usuario.php';cher.submit();return false;">[Actualizar]</a>&nbsp;
                            </td>
           </tr>

<?php
	};

?>
	</table>
<br><br> <hr>

<?php
        $stfac = $db->query("SELECT * FROM user WHERE TipoUsuario_idTipoUsuario = 3");
?>
	<br><br><br>
                <center><strong><font size='+1'>Profesionales Registrados/Postulantes [INPC-RPC]</font> </strong></center>
                <table border='1' width ='80%' align='center' cellpadding='5' cellspacing='5' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH><B>USUARIO:</b>
								</th>
								<th><b>NOMBRE REAL:</b>
								</th>
								<th><b>CORRREO(S) ELECTR&Oacute;NICO(S):</b>
								</th>
								<th><b>SOLICITA REGISTRO COMO:</b>
								</th>
							</tr>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
			$stpr = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional ='".$row['username']."'");
			$tiprof = $stpr->fetch(PDO::FETCH_ASSOC);
?>
                        <tr bgcolor='#ffffff'>
			    <td><?php echo $row['username']?>
                            </td>
                            <td><?php echo $row['realname']?>
                            </td>
                             <td><?php echo $row['email']?><br><?php echo $row['email2']?>
                            </td>
                            <td><?php echo format_cont_db('TipoProfesionalId',$tiprof['TipoProfesional_TipoProfesionalId'])?>
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
