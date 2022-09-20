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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
		function validate(){
			var allfaca=0;
			var elem=document.valida.length-1;
			var elec="La solicitud será ACEPTADA";
			var chequed=0;
			var chkinv=0;
			for (var i=0; i <= elem; i++){
				if(document.valida.elements[i].name!='RestSinT'){
					switch (document.valida.elements[i].type){
						case "checkbox":
							chkinv++;
							if(document.valida.elements[i].checked){
								chequed++;
								switch (document.valida.elements[i].name){
								 case "faca":
								 	allfaca=1;
								 break;
								}
							}
						break;
					};
				};
			};
			for (var i=0; i <= elem; i++){
				switch (document.valida.elements[i].type){
					case "hidden":
						if (allfaca){
							if (document.valida.elements[i].name.indexOf("faca_")!=-1){
								document.valida.elements[i].value=1;
							}						
						}
					break;
				};
			};
			if(document.fds.loaded.value==0){
				if (!confirm('Va registrar la validación sin haber realizado la Consulta a DATOSEGURO - INFODIGITAL\nEstá seguro?')){
				 return false;
				}
			};
			if((chequed!=chkinv)|| chkinv==0){
				elec='La solicitud será RECHAZADA'
			}
			if(confirm(elec+'\nVerifique que la información sea correcta, antes de continuar.')){
				return true;
			}else{
				return false;
			}			
		};
	</SCRIPT>
 <HTML>
<BODY onLoad="<?php  if($_POST['ver_dseguro']){?> alert( 'Si el solicitante CUMPLE con los requisitos, active la casilla respectiva ');<?php ;};?>">
	<center><h2>VALIDACI&Oacute;N DE DATOS CON INFODIGITAL</h2></center>
 <form name='valida' method='post' action='validar-datos2.php'>
 	 <input type='hidden' name='idpost' value='<?php echo $_POST['idpost']?>'>
 	 <input type='hidden' name='idprof' value='<?php echo $_POST['prof']?>'>
<?php
	$stper = $db->query("SELECT * FROM Profesional WHERE idProfesional ='".$_POST['prof']."'");
	if ($stper->rowCount()>0){
		$stp= $stper->fetch(PDO::FETCH_ASSOC);
		$docid=$stp['idProfesional'];
?>
		<center><strong><font size='+1'>INFORMACI&Oacute;N PERSONAL</font> </strong></center>
		<table style=" border-color:blue; border-width:1px; border-style:solid;"  width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion'>
			<tr  bgcolor='#ffffff'>
				<td><b>DOCUMENTO IDENTIFICACI&Oacute;N:</b><br><?php echo $stp['idProfesional']?> </td>
				<td><b></font>NOMBRES:</b><br><?php echo $stp['ProfesionalNombres']?></td>
				<td><b></font>APELLIDOS:</b><br><?php echo $stp['ProfesionalApellidos']?></td>
			</tr>
				<tr bgcolor='#ffffff'>
				<td><b>G&Eacute;NERO:</b> <br><?php echo format_cont_db('ProfesionalGenero',$stp['ProfesionalGenero'])?></td>
				<td><b>FECHA NACIMIENTO (aaaa/mm/dd):</b><br><?php echo $stp['ProfesionalFecNacim']?></td>
				<td><b>PA&Iacute;S NACIMIENTO:</b><br><?php echo format_cont_db('idNacionalidad',$stp['Nacionalidad_idNacionalidad'])?></td>
			</tr>
			<tr bgcolor='#ffffff'>
				<td><b>PA&Iacute;S RESIDENCIA:</b><br>	<?php echo format_cont_db('idPaisr',$stp['Ciudadr_Paisr_idPaisr'])?></td>
				<td><b>CIUDAD RESIDENCIA:</b><br><?php echo format_cont_db('idCiudadr',$stp['Ciudadr_idCiudadr'])?></td>
				<td><b>DIRECCI&Oacute;N:</b><br><?php echo $stp['ProfesionalDireccion']?></td>
			</tr>
			<tr bgcolor='#ffffff'>
				<td><b>TELEF&Oacute;NO M&Oacute;VIL:</b><br><?php echo $stp['ProfesionalTlfmovil']?></td>
				<td><b>TELEF&Oacute;NO FIJO:</b><br><?php echo $stp['ProfesionalTlfFijo']?></td>
				<td><b>CORREOS ELETR&Oacute;NICOS:</b><br><?php echo $stp['ProfesionalMail']?><br><?php echo $stp['ProfesionalMail2']?></td>
			</tr>
<?php
	if($_POST['ver_dseguro']){
?>
			<tr bgcolor='#ffffff'>
				<td colspan='3' align='center'>
					<table style=" border-color:red; border-width:3px; border-style:solid;" cellpadding='3' cellspacing='1' class='buton'>
						<tr ><td >
							<input type='checkbox' name='personal' value='1' <?php if($_POST['valdp']){echo 'checked';}?>><b> CUMPLE REQUISITO</b> </td>
					</tr></table>
				</td>
			</tr>
<?php
	}else{
?>
			<tr bgcolor='#ffffff'>
				<td colspan='5' align='center'>
<?php
		echo 'REQUISITO: '.format_cont_db('PostulacioncCumpleInfoP',$_POST['valdp']);
?>
				</td>
			</tr>
<?php
	};
?>
		</table>
<?php
	};
	$stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='".$_POST['prof']."'");
?>
	<br><br>
	<center><strong><font size='+1'>INFORMACI&Oacute;N ACAD&Eacute;MICA</font> </strong></center>
	<table style=" border-color:blue; border-width:1px; border-style:solid;" width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion'>
<?php
	$countit=0;
	$countit_sinespecificar=0;
	$countit_blancos=0;
	$otrotitulo=1;
	$afin='afín';
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
	$countit++;
	$row['FAcademicaNTitulo']=str_replace('especificar','',$row['FAcademicaNTitulo']);
	$row['FAcademicaInstitucion']=str_replace('especificar','',$row['FAcademicaInstitucion']);
	$row['FAcademicaFecGrado']=str_replace('0000-00-00','',$row['FAcademicaFecGrado']);
	$row['FAcademicaCSenescyt']=str_replace($_POST['us_maneja'].'-actualice-'.$docid,'',$row['FAcademicaCSenescyt']);
	if($row['FAcademicaNTitulo']=='' and $row['FAcademicaInstitucion']=='' and $row['FAcademicaFecGrado']=='' and $row['FAcademicaCSenescyt']==''){$countit_blancos++;$row['FAcademicaNivel']='';};
#	if($row['FAcademicaNTitulo']=='especificar' and $row['FAcademicaInstitucion']=='especificar' and $row['FAcademicaFecGrado']=='0000-00-00' and $row['FAcademicaCSenescyt']==$_POST['us_maneja'].'-actualice-'.$docid){$countit_sinespecificar++;$row['FAcademicaNivel']='';};
	if($row['FAcademicaTituloUsado']){$used_color='#aae4aa';$used_color='#ffffff';}else{$used_color='#ffffff';}
	
?>
		<tr bgcolor='<?php echo $used_color?>'>
			<td><b>NIVEL T&Iacute;TULO:</b><br><?php echo format_cont_db('FAcademicaNivel',$row['FAcademicaNivel'])?></td>
			<td><b>NOMBRE T&Iacute;TULO:</b><br><?php echo $row['FAcademicaNTitulo']?></td>
			<td><b>INSTITUCI&Oacute;N:</b><br><?php echo $row['FAcademicaInstitucion']?></td>
			 <td><b>FECHA GRADUACI&Oacute;N:</b><br><?php echo $row['FAcademicaFecGrado']?></td>
			<td><b>N&Uacute;MERO DE  REGISTRO EN SENESCYT:</b><br><?php echo $row['FAcademicaCSenescyt']?></td>
				<input type='hidden' name='faca_<?php echo $row['idFAcademica']?>' value='0'>
		</tr>
<?php
	};
	if ($_POST['us_maneja']==2){
?>
			<tr bgcolor='#ffffff'>
<?php
	}
?>
<?php
	if(!$countit or $countit_blancos or $countit_sinespecificar){
		$otrotitulo=0;
		$afin='';
?>
				<td colspan='4' align='left'>
					En razón de la ausencia de información académica o a los valores 'sin especificar', se presume que es un registro antiguo en proceso de migración<br>
					Considere la opción de ubicarlo en la base de datos de restauradores, activando la casilla 'Pre-registrado sin título'
				</td>
<?php		
	};
	if ($_POST['us_maneja']==2){
		if($_POST['ver_dseguro']){
?>
				<td class='buton' align='center' <?php if ($otrotitulo){echo "colspan='5'";};?>><input type='checkbox' name='RestSinT' value='1' <?php if($_POST['RestSinT']){echo 'checked';}?>><b>Pre-registrado sin título <?php echo $afin;?></b></td>
			</tr>
<?php
		};
	}
	if($_POST['ver_dseguro']){
?>

			<tr bgcolor='#ffffff'>
				<td colspan='5' align='center'>
					<table style=" border-color:#ff0000; border-width:3px; border-style:solid;" cellpadding='3' cellspacing='1' class='buton' >
						<tr ><td >
							<input type='checkbox' name='faca' value='1' <?php if($_POST['valacad']){echo 'checked';}?>><b>CUMPLE REQUISITO</b></td>
					</tr></table>
				</td>
			</tr>
<?php
	}else{
?>
			<tr bgcolor='#ffffff'>
				<td colspan='5' align='center'>
<?php
		echo 'REQUISITO: '.format_cont_db('PostulacionCumpleInfoA',$_POST['valacad']);
?>
				</td>
			</tr>
<?php
	};
?>
	</table><br>
<!--	<b>Leyenda:</b><br>
	<div style=" border: 1px solid black; float:left; width:10px; font-size:px; background-color:#aae4aa;">&nbsp;</div> &nbsp;&nbsp;&nbsp;Datos usado en otra solicitud-->
<?php
	if($_POST['ver_dseguro']){
?>
	<br><center><INPUT onClick="if (validate()){valida.submit();}{return false;}" class='buton' type='submit' name='ok' value='REGISTRAR VALIDACIÓN' size='10'></center> <br><br>
<?php
	};
?>	
	</form>
<?php
	if($_POST['ver_dseguro']){
?>
	<center>
		<!--<img height='50' src='image/logo-RegistroCivil.png'>&nbsp;&nbsp;-->
		<table width="138" border='0' cellpadding='6' cellspacing='1' style="  border-width:0px; border-style:solid;"  >
			<tr ><td class='buton' ><a class='info' href='Javascript:' onClick="if(finfod.vis.value==0){expandit2('infod',1);expandit2('infos',1);finfos.vis.value=1;finfod.vis.value=1;if(finfod.loaded.value==0){finfod.submit();};finfod.loaded.value=1;location='#final';return false;}else{expandit2('infos',0);expandit2('infod',0);finfod.vis.value=0};return false;">
					<img border='3' alt="Validar Datos con Infodigital" style="border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff; background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;" src='image/vdatoseguro.png'></a>
			   </td>
			   <td>&nbsp;&nbsp;&nbsp;</td>
<?php /*?>			   <td class='buton'>
					<a class='info' style="font-size:11px;"  href='Javascript:' onClick="if(finfos.vis.value==0){expandit2('infos',1);finfos.vis.value=1;}else{expandit2('infos',0);finfos.vis.value=0};return false;"> 
						<img border='3'  height="50" title="Consulte sus datos en SENESCYT" alt="Consulte sus datos en SENESCYT" style="border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff; background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;" src='image/logo-senescyt.png'>
					</a>
			   </td><?php */?>
			</tr>
<?php /*?>			<tr>
			   <td colspan='3'>Utilice el enlace con la SENESCYT para verificar datos en caso <br>de que el acceso a DatoSeguro no muestre resultados completos</td>
			</tr><?php */?>
			</table>
					
		<!--&nbsp;&nbsp;<img height='50' src='image/logo-senescyt.png'>-->
	 </center>
			<DIV id='infod' style="DISPLAY:none; head: ;" ><br>
	<center><h1>VERIFICACI&Oacute;N DE DATOS</h1></center>
				<iframe name='iinfod' frameborder='0'  height='425' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form name='fds' id="finfod" target='iinfod' action="ver-infodigital.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='loaded' value='0'>
					<input type='hidden' name='docid' value="<?php echo $docid;?>">
				</form>
			</div><script>expandit2('infod',0)</script>			
	<br>
<?php
	};
?>
			<DIV id='infos' style="DISPLAY:none; head: ;" ><br>
<center>DESPL&Aacute;SECE<?php echo $docid?> HACIA ABAJO PARA VER LA INFORMACI&Oacute;N ACAD&Eacute;MICA</center>
				<iframe name='iinfos' frameborder='0'  height='475' width='100%' src="https://www.senescyt.gob.ec/consulta-titulos-web/faces/vista/consulta/consulta.xhtml;jsessionid=VFZSYRTJBKEbujtyHSKaUMBx.d28f0bce-6f01-372b-b0a2-648dc7d61c7b<?php echo $docid?>">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="finfos" target='iinfos' action="" method="post">
					<input type='hidden' name='loaded' value='0'>
					<input type='hidden' name='vis' value='0'>
				</form>
			</div><script>expandit2('infos',0)</script>
			<a name='final'>

<?php	
$db=null;
exit;
?>
