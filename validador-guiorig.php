<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_valid.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
 	 	var url;
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	</SCRIPT>

 <HTML>
<?php
	$sql_us_maneja = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$_SESSION['user']."'" );	
?>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type='hidden' name='basecod' >
         <input type='hidden' name='act_dea' >
         <input type='hidden' name='us_maneja'>
        </form>
<b><table border='0' width='89%' align='center' background='image/web2014.png'>
	  	     <tr valign='top' class='menu_'>
                        <td width='80%' align='center'><font size='+1'><div class='cajita'> SERVICIO DE REGISTRO DE PROFESIONALES INPC </div> </font>
                        </td>
                        <td width='20%' align='right'><div class='literatura2'><br> Sesion Usuari@:&nbsp;&nbsp;<?php echo $_SESSION['user']?> &nbsp;<br></div> 
                        </td>
                </tr>
        </table> </b><HR>
<table align="center" width="100%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
                <tr>
                        <td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="Javascript:"><font size='+1'>INICIO</font></a>
                        </td>
                        <td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
                        <H1>VALIDACION DE SOLICITUDES DE REGISTRO </H1> 
                        <table border='0' cellspacing='4' cellpadding='3' class='menubar'>
<!--                        	<tr bgcolor='#ffffff'>
                        		<td><b>Administraci&oacute;n Usuarios:</b></td>
                        		<td><b>Administraci&oacute;n de Par&aacute;metros:</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        	</tr>-->
                        	<tr bgcolor='#ffffff'>
                        		<td>&nbsp;<b><a href="Javascript:" onClick="cher.target='_self';cher.action='validador-gui.php';cher.submit();">[Refresca listado]</a></b></td>
<!--                        		<td><b>Administraci&oacute;n de Par&aacute;metros:</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>
                        		<td><b>--</b></td>-->
                        	</tr>
                        </table><br><br>
    			 		</td>
                    	<td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.target='_self';cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};"><font size='+1'>Salir</font></a>
                        </td>
                </tr>
                </table>


<?php
	   while($us_maneja = $sql_us_maneja->fetch(PDO::FETCH_ASSOC)) {
			$st_base_cod = $db->query("SELECT TipoProfesionalPrefijoCodigo FROM TipoProfesional WHERE TipoProfesionalId=".$us_maneja['TipoProfesional_TipoProfesionalId'] );	
			$basecod= $st_base_cod->fetch(PDO::FETCH_ASSOC);

			$stfac = $db->query("SELECT t1.Postulacion_idPostulacion, t1.AccionEnPostulacionFechaAs  FROM AccionEnPostulacion as t1, Postulacion as t2 WHERE t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=0 ");
        //$stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='0602908170'");
?>
	<br><br><br><TABLE border='1'   width='100%'><tr><td>
                <table border='0' class='cajita'><tr><td> <strong>BASE DE DATOS: <?php echo format_cont_db('TipoProfesionalId',$us_maneja['TipoProfesional_TipoProfesionalId']) ?></strong></td></tr></table>  <br>
                <center><strong><font size='+1'>Solicitudes por Validar</font> </strong></center>
                <table border='1' width ='96%' align='center' cellpadding='5' cellspacing='5' class='seccion1'>
							<tr bgcolor='#ffffff'>
								<tH><B>Solicitante:</b>
								</th>
								<th width><b>Fecha Asignaci&oacute;n:</b>
								</th>
								<th><b>Base de Datos:</b>
								</th>
								<th><b>Verificacion de Datos:</b>
								</th>
								<th><b> Informe T&eacute;cnico:</b>
								</th>
								<th><b>Respuesta a Solicitud Recomendada :</b>
								</th>
								<th width='15%'><b>Acciones:</b>
								</th>
							</tr>
<?php
			while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
				$post_data = $db->query("SELECT Profesional_idProfesional FROM Postulacion WHERE idPostulacion='".$row['Postulacion_idPostulacion']."'");
				$postd=$post_data->fetch(PDO::FETCH_ASSOC);
				$starea = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$postd['Profesional_idProfesional']."'");
				$area=$starea->fetch(PDO::FETCH_ASSOC);
				if ($area['TipoProfesional_TipoProfesionalId']==$us_maneja['TipoProfesional_TipoProfesionalId']){
					$fname='fr_'.$row['Postulacion_idPostulacion'];
?>	
                        <tr bgcolor='#ffffff'>
							<td width='14%'><?php echo format_cont_db('idProfesional',$postd['Profesional_idProfesional'])?>
                            </td>
                            <td width='11%'><?php echo $row['AccionEnPostulacionFechaAs']?>
                            </td>
                            <td width='14%'><?php echo format_cont_db('TipoProfesionalId',$area	['TipoProfesional_TipoProfesionalId'])?>
                            </td>
                             <td width='14%'> 
                            	<a href="Javascript:" onClick="abrir('','val_per',(ancho/(1.5)),alto/2,0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_per';cher.action='validar-personal.php';cher.submit();return false;">[Datos Personales]</a><br>
                            	<a href="Javascript:" onClick="abrir('','val_acad',(ancho/(1.2)),(alto/(1.2)),0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_acad';cher.action='validar-formacion.php';cher.submit();return false;">[Formacion Academica]</a>
                            </td>
                            <td  width='14%' bgcolor='#dddddd'><form name='<?php echo $fname?>' method='POST'>
                            	<input type='hidden' name='idpost' value='<?php echo $row['Postulacion_idPostulacion']?>'>
                            	<input type='hidden' name='us_maneja' value='<?php echo $area['TipoProfesional_TipoProfesionalId']?>'>
                            	Ref. Documento Informe Tecnico: <br>
                            	<input type='text' size='30' maxlength='50' name='doc-ref' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"><br>
                            	Resumen:<br>
                            	<textarea title='Arrastre esq. inf. derecha para agrandar/achicar' rows="3" cols="20" name='obs' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
								</textarea>
                            </td>
                            <td  width='17%' valign='top'  bgcolor='#dddddd' > 
 								<SELECT title='Escoger Aceptada o Rechazada' NAME="recomendacion" size="1"  onFocus="set_bgcolor(this,'#99ffff')" onBlur="set_bgcolor(this,'');" onChange="switch(this.options[this.selectedIndex].value){case 'aprobada': <?php echo $fname?>.cod_pro.value='<?php echo $basecod['TipoProfesionalPrefijoCodigo']?>';expandit2('codl',1);expandit2('respuesta',1);<?php echo $fname?>.cod_pro.focus(); break; case '0':expandit2('codl',0);expandit2('respuesta',0);<?php echo $fname?>.cod_pro.value='';break; case 'rechazada': expandit2('codl',0);expandit2('respuesta',1);<?php echo $fname?>.cod_pro.value='';break; };">
 									<OPTION  value="0"> </OPTION>
									<OPTION  value="aprobada">Aprobada</OPTION>
									<OPTION  value="rechazada">Rechazada</OPTION>
        						</SELECT><br>        						
								<DIV id='codl' style="DISPLAY: none; head: " >
									<br>Codigo Profesional: <input type='text' size='10' maxlength='20' name='cod_pro' value='<?php echo $basecod['TipoProfesionalPrefijoCodigo']?>' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
								</div>
								<DIV id='respuesta' style="DISPLAY: none; head: " >
									<br> Ref. Oficio Respuesta: 
									<br><input type='text' size='20' maxlength='20' name='resp-ref' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
                            	 <br>Resumen:<br>
                            	<textarea title='Arrastre esq. inf. derecha para agrandar/achicar' rows="3" cols="20" name='obsr' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
								</textarea>
								</div>
								</form>
                            </td>
                            <td  width='16%' align='center'>&nbsp;<a href="JavaScript:" onClick="cher.basecod.value='<?php echo $basecod['TipoProfesionalPrefijoCodigo']?>';if(validate('<?php echo $fname?>')){<?php echo $fname?>.action='validar-post.php';<?php echo $fname?>.submit();};return false;">[Remitir a Verificador ]</a>&nbsp;
			    	 
                            </td>
           </tr>

<?php
				};
			};
?>
	</table>

<br>
<?php
			$stfac = $db->query("SELECT t1.Postulacion_idPostulacion, t1.AccionEnPostulacionFechaAs,t2.PostulacionFechaV FROM AccionEnPostulacion as t1, Postulacion as t2 WHERE t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=1 ");
?>
	<br><br><br>
                <center><strong><font size='+1'>Solicitudes Validadas</font> </strong></center>
                <table border='1' width ='96%' align='center' cellpadding='5' cellspacing='5' class='seccion2'>
							<tr bgcolor='#ffffff'>
								<tH><B>Solicitante:</b>
								</th>
								<th><b>Fecha Asignaci&oacute;n:</b>
								</th>
								<th><b>Base de Datos:</b>
								</th>
								<th><b>Verificacion de Datos:</b>
								</th>
								<th><b> Informe T&eacute;cnico:</b>
								</th>
								<th><b>Respuesta a Solicitud :</b>
								</th>
								<th><b>Verificador Notificado :</b>
								</th>
							</tr>
<?php 
			while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
				$post_data = $db->query("SELECT Profesional_idProfesional FROM Postulacion WHERE idPostulacion='".$row['Postulacion_idPostulacion']."'");
				$postd=$post_data->fetch(PDO::FETCH_ASSOC);
				$starea = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$postd['Profesional_idProfesional']."'");
				$area=$starea->fetch(PDO::FETCH_ASSOC);
				if ($area['TipoProfesional_TipoProfesionalId']==$us_maneja['TipoProfesional_TipoProfesionalId']){
					$stinforme = $db->query("SELECT InformeTecnicoRefDoc,InformeTecnicoObservacion,InformeTecnicoRecomendacion, InformeTecnicoCodPro FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['Postulacion_idPostulacion']);
					$informe=$stinforme->fetch(PDO::FETCH_ASSOC);
?>	
                        <tr bgcolor='#ffffff'>
									<td width='14%'><?php echo format_cont_db('idProfesional',$postd['Profesional_idProfesional'])?>
                            </td>
                            <td width='11%'><?php echo $row['AccionEnPostulacionFechaAs']?>
                            </td>
                            <td width='14%'><?php echo format_cont_db('TipoProfesionalId',$area	['TipoProfesional_TipoProfesionalId'])?>
                            </td>
                             <td width='14%'> 
                            	<a href="Javascript:" onClick="abrir('','val_per',(ancho/(1.5)),alto/2,0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_per';cher.action='validar-personal.php';cher.submit();return false;">[Datos Personales]</a><br>
                            	<a href="Javascript:" onClick="abrir('','val_acad',(ancho/(1.2)),(alto/(1.2)),0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_acad';cher.action='validar-formacion.php';cher.submit();return false;">[Formacion Academica]</a>

                            </td>
                            <td width='14%' >
                            	Referencia a Documento F&iacute;sico: <br>
                            	<b><?php echo $informe['InformeTecnicoRefDoc']?></b><br> <br>
                            	Observaci&oacute;n / Resumen:<br>
                            	<b><?php echo $informe['InformeTecnicoObservacion']?>
                            </td>
                            <td  width='17%' align='center' >
                            	<?php echo strtoupper($informe['InformeTecnicoRecomendacion'])?> 
<?php
						if($informe['InformeTecnicoRecomendacion']=='aprobada'){
							echo "<br> C&oacute;digo Registro Propuesto: <b>".$informe['InformeTecnicoCodPro']."</b>";
						};
?>
                            </td>
                            <td width='16%'>
                            	<?php echo $row['PostulacionFechaV']?>
                            </td>
           </tr>
<?php
				};
			};

?>
	</table><br><br>
<br>
<?php														//TRATAMIENTO DE LOS PROFESIONALES REGISTRADOS HABILITACION DESHABILITACION
		$get_prof_reg = $db->query("SELECT * FROM RegistroP WHERE RegistroPProfesionalID=".$us_maneja['TipoProfesional_TipoProfesionalId']." ORDER BY RegistroPCodigo ASC ");
?>
	<br><br><br>
                <center><strong><font size='+1'>PROFESIONALES REGISTRADOS</font> </strong></center>
                <table border='1' width ='90%' align='center' cellpadding='5' cellspacing='5' class='seccion2'>
							<tr bgcolor='#ffffff'>
								<tH><B>C&oacute;digo de Registro:</b>
								</th>
								<tH><B>Apellidos:</b>
								</th>
								<th><b>Nombres:</b>
								</th>
								<th><b>G&eacute;nero:</b>
								</th>
								<th><b>Direcci&oacute;n:</b>
								</th>
								<th><b>Ciudad Res.:</b>
								</th>
								<th><b>Pa&iacute;s Res.:</b>
								</th>
								<th><b>Tlf. Fijo:</b>
								</th>
								<th><b>Tlf. Movil:</b>
								</th>
								<th><b>Email:</b>
								</th>
								<th><b>Email alt.:</b>
								</th>
								<th><b>Fecha Habilitaci&oacute;n:</b>
								</th>
								<td bgcolor='#fed9a3' align='center'><b>Acciones / Enlaces</b>
								</td>
							</tr>
<?php
			while($row = $get_prof_reg->fetch(PDO::FETCH_ASSOC)) {
?>
                        <tr bgcolor='#ffffff'>
									<td><?php echo $row['RegistroPCodigo']?></td>
									<td><?php echo $row['RegistroPApellidos']?></td>
									<td><?php echo $row['RegistroPNombres']?></td>
									<td><?php echo $row['RegistroPGenero']?></td>
									<td><?php echo $row['RegistroPDireccion']?></td>
									<td><?php echo $row['RegistroPCiudadr']?></td>
									<td><?php echo $row['RegistroPPaisr']?></td>
									<td><?php echo $row['RegistroPTlfFijo']?></td>
									<td><?php echo $row['RegistroPTlfMovil']?></td>
									<td><?php echo $row['RegistroPMail']?></td>
									<td><?php echo $row['RegistroPMail2']?></td>
									<td><?php echo $row['RegistroPFechaRegistro']?></td>
									<td  align='center' bgcolor='#dce5ef'>
										&nbsp;<a href="JavaScript:" onClick="url_=url_base+'<?php echo $row['Profesional_idProfesional']?>';abrir(url_,'sene',ancho/1.5,alto/1.5,0);return false;">[R Senescyt]</a>&nbsp;<br>
<?php
				if($row['RegistroPActivo']==1){
					$lab='Desactivar';
					$act=0;
				}else{
					$lab='Activar';
					$act=1;
				};
?>
										<a href="JavaScript:" onClick="if (confirm('Completamente Seguro de <?php echo $lab?> al Profesional seleccionado?')){cher.us_maneja.value='<?php echo $us_maneja['TipoProfesional_TipoProfesionalId']?>';cher.prof.value='<?php echo $row['Profesional_idProfesional']?>';cher.act_dea.value=<?php echo $act?>;cher.action='activ-deactiv-post.php';cher.submit();};return false;">[<?php echo $lab?>]</a>
									</td>
           </tr>

<?php
			};

?>
	</table>
<br><br>	
	</td></tr></table>

<?php
	};
$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
