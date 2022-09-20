<?php
	$es_hijo=1;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	require('maneja-archivos.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_posted.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" >
	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	 	var url_,fa_1,fa_2,fa_3,fa_4,fa_5,fa_6;
	 	function getc(){
	 		var cont=String(post1.idPaisr.options[post1.idPaisr.selectedIndex].value);
	 		if(cont== "undefined" || cont==''){
	 			alert('Escoja Pais Residencia');
	 		}else{
	 			post1.id_.value=cont;
	 		};
	 	};
	 	function _edit(estado){
	 		var con=1,ccon='';
	 		post1.ciu_co.value=document.post1.idPaisr.options[document.post1.idPaisr.selectedIndex].value;
	 		if (typeof post1.fa1!='undefined'){if(post1.fa1.value==1){con=1;};};
	 		if (typeof post1.fa2!='undefined'){if(post1.fa2.value==1){con=2;};};
	 		if (typeof post1.fa3!='undefined'){if(post1.fa3.value==1){con=3;};};
	 		if (typeof post1.fa4!='undefined'){if(post1.fa4.value==1){con=4;};};
	 		if (typeof post1.fa5!='undefined'){if(post1.fa5.value==1){con=5;};};
	 		expandit2('dname',estado);
	 		expandit2('dlname',estado);
	 		expandit2('dfnac',estado);
	 		expandit2('dpaisr',estado);
	 		expandit2('dciudadr',estado);
	 		expandit2('ddirec',estado);
	 		expandit2('dtmovil',estado);
	 		expandit2('dtfijo',estado);
	 		expandit2('dmails',estado);
//	 		expandit2('addtit',estado);
	 		for (var j=1; j<= con; j++){
				if(j>1){ccon=j;};
				expandit2('dnit'+ccon,estado);
		 		expandit2('dnti'+ccon,estado);
		 		expandit2('dnin'+ccon,estado);
		 		expandit2('dfti'+ccon,estado);
		 		expandit2('dcod'+ccon,estado);
			};
			expandit2('edit',estado)
			expandit2('noedit',!estado)
	 	};
	 </SCRIPT>
<HTML>
<?php
#	$no_query=0;
#	$_stat_pos = $db->query("SELECT * FROM Postulacion WHERE Profesiones_idProfesiones ='".$_POST['posts']."' and PostulacionFechaF is NULL");
#	if ($_stat_pos->rowCount()==0){
#		$_stat_pos = $db->query("SELECT * FROM Postulacion WHERE Profesiones_idProfesiones ='".$_POST['posts']."' and PostulacionFechaF is not NULL");
#		$no_query++;
#	};
#	$stpos= $_stat_pos->fetch(PDO::FETCH_ASSOC);
	$imgsrc='';
#	$edit_soli=0;
	$imgsrc='proces0';$edit_soli=1;
#	if ($stpos['PostulacionAsignado']==1 and $stpos['PostulacionFechaV']==NULL){$imgsrc='proces2';};
#	if ($stpos['PostulacionAsignado']==1 and $stpos['PostulacionFechaV']!=NULL and $stpos['PostulacionVerificado']==1){$imgsrc='proces2-5';};
#	if ($stpos['PostulacionVerificado']==1 and $stpos['PostulacionFechaD']!=NULL and $stpos['PostulacionAprobado']==NULL){$imgsrc='proces3';};
#	if ($stpos['PostulacionVerificado']==1 and $stpos['PostulacionFechaD']!=NULL and $stpos['PostulacionAprobado']!=NULL){$imgsrc='proces3';};
#	if ($stpos['PostulacionAprobado']==1 and $stpos['PostulacionFechaD']!=NULL and $stpos['PostulacionAprobado']!=NULL){$imgsrc='proces3-5';};
#	if ($stpos['PostulacionEstado']==1 and $stpos['PostulacionFechaF']!=NULL and $stpos['PostulacionAprobado']=='aprobada'){$imgsrc='proces4';/*$edit_soli=1;*/};
#	if ($stpos['PostulacionEstado']==1 and $stpos['PostulacionFechaF']!=NULL and $stpos['PostulacionAprobado']=='rechazada'){$imgsrc='proces4r';/*$edit_soli=1;*/};
?>
<BODY onload="_edit(1);resiz('<?php echo $_POST['ifid']?>')">
	<form name="cher" action=" " method="post" >
		<input type="hidden" name="ifid" value="<?php echo $_POST['ifid']?>">
		<input type="hidden" name="edit_soli" value="<?php echo $_POST['edit_soli']?>">
		<input type='hidden' name='fifid' value="<?php echo $_POST['fifid'];?>">
		<input type="hidden" name="topico">
		<input type="hidden" name="posts" value="<?php echo $_POST['posts']?>">
		<input type="hidden" name="profes" value="<?php echo $_POST['profes']?>">
		<input type="hidden" name="prof_" value="<?php echo $_SESSION['user']?>">
		<input type="hidden" name="cod" value="">
		<input type="hidden" name="prim_upd" value="1">
		
		
	</form>
	<form name="post1" action=" " method="post" >
		<input type="hidden" name="edit_soli" value="<?php echo $_POST['edit_soli']?>">
		<input type='hidden' name='posts' value="<?php echo $_POST['posts'];?>"> <?php //la profesion ?>
		<input type='hidden' name='profes' value="<?php echo $_POST['profes'];?>"> <?php //tipo profesional ?>
		<input type='hidden' name='ifid' value="<?php echo $_POST['ifid'];?>">
		<input type='hidden' name='fifid' value="<?php echo $_POST['fifid'];?>">
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
		<input type="hidden" name="ciu_co">
		<input type="hidden" name="id_">
		<input type="hidden" name="id_ciu">
		<input type="hidden" name="prim_upd" value="1">
		

	<table align="center" width="100%" border='0' style="border-style:none;" cellspacing='4' ><!--onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"-->
		<tr >
<!--		<td rowspan='2' class='menubar' width='7%' align="center"  onClick="post1.action='post_stat.php';post1.submit()"><a href="Javascript:"><!--<img src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'><br><b>Refrescar</b></a></td>-->
			<td align="center"  valign='top'>
				<a href="JavaScript:" onClick= "abrir('','help',ancho*0.9,alto*0.85,0);cher.target='help';cher.topico.value='poststat';cher.action='ayuda-gui.php';cher.submit();cher.target='_self';return false;"><img onMouseOver="this.style.height='24px'" onMouseOut="this.style.height='18px'" src='image/helpb.png'><!--Ayuda --></a><br><br>
				<a href="JavaScript:" onClick="cher.target='_self';cher.action='post_migra.php';cher.submit();return false;"><img onMouseOver="swap('reloadi.png','reload.png','rld');" onMouseOut="swap('reload.png','reloadi.png','rld');" name='rld' height='20' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'><!--Ayuda --></a>
			</td>
			<td rowspan='2' align="center" onMouseOver="overTD(this,'#d7ebf9');" onMouseOut="outTD(this,'');" >
				<H1> ESTADO DE LA SOLICITUD DE REGISTRO</H1>
<?php /* ?>				<table border='0' cellspacing='1' cellpadding='2' class='seccion'>
					<tr align='center'>
						<td><b>Fecha Postulaci&oacute;n:</b></td>
						<td><b>Estado:</b></td>
						<!--<td><b>Proceso de Validaci&oacute;n:</b></td>
						<td><b>Proceso de Verificaci&oacute;n de Validaci&oacute;n</b></td>-->
						<td><b>Aprobaci&oacute;n / Rechazo a Solicitud:</b></td>
						<td><b>Fecha Respuesta:</b></td>
<?php
			if ($stpos['PostulacionAprobado']=='rechazada'){
				echo "<td><b>Oficio:</b></td>";
			};

?>
					</tr>
					<tr bgcolor='#fffff' align='center'>
						<td><?php echo $stpos['PostulacionFechaI']?></td>
						<td> <?php echo format_cont_db('PostulacionEstado',$stpos['PostulacionEstado'])?></td>
<?php
			($stpos['PostulacionAprobado']=='aprobada')?$bg='#b0e6a7':$bg='#f1a09c';
			($stpos['PostulacionAprobado']=='aprobada')?$doc='Certificaci&oacute;n':$doc='Respuesta';
?>
						<td bgcolor='<?php echo $bg?>'> <?php echo format_cont_db('PostulacionAprobado',$stpos['PostulacionAprobado'])?></td>
						<td> <?php echo $stpos['PostulacionFechaF']?></td>
<?php
			$file=$file_prefix.$stpos['idPostulacion'].'.pdf';
			if (exist_doc($file) and $stpos['PostulacionFechaF']!=NULL){
?>
				<td><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/storage/<?php echo $file?>" target='new'><img src='image/icon_pdf.gif' height='18' alt="Ver Documento" Title="Ver Documento"></a>&nbsp;&nbsp;Oficio <?php echo $doc?></td>
<?php
			};
?>
					</tr>
				</table><br><?php */?>
				<center><img height='30' src='image/<?php echo $imgsrc?>.png'> </center>
			</td>
		</tr>
	</table>
	<hr>
<?php
	$p_actualizo=0;
	$primer_update=0;
	$qregp=$db->query("SELECT RegistroPActivo FROM RegistroP WHERE Profesional_idProfesional='".$_SESSION['user']."'");
	if ($qregp->rowCount()>0){
		$regp= $qregp->fetch(PDO::FETCH_ASSOC);
		$reg_act=$regp['RegistroPActivo'];
	};

	$stpro= $db->query("SELECT * FROM Profesional WHERE idProfesional ='".$_SESSION['user']."'");
	if ($stpro->rowCount()>0){
		$stp= $stpro->fetch(PDO::FETCH_ASSOC);
			$p_actualizo=$stp['ProfesionalActualizo'];
			$last_actu=$stp['ProfesionalLastActu'];
#			if($stpos['PostulacionAprobado']=='aprobada' AND $stpos['PostulacionFechaF']!=NULL){
#				$st_g_cod=$db->query("SELECT RegistroPCodigo FROM RegistroP WHERE Profesional_idProfesional='".$stp['idProfesional']."'");
#				$get_cod=$st_g_cod->fetch(PDO::FETCH_ASSOC);
#				$area_etiqueta=" ";
#			}else{
#				$area_etiqueta="Solicita registro como:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";
#			};
/*
?>
		<table style=" border-color:blue; border-width:1px; border-style:solid;" width ='80%' align='center'  cellspacing='1' class='seccion'>
			<tr  bgcolor='#ffffff' align='center'>
				<td nowrap width='50%'><b><?php echo $area_etiqueta.format_cont_db('TipoProfesionalId',$_POST['profes'])?></b></td>
<?php
			if($stpos['PostulacionAprobado']=='aprobada' AND $stpos['PostulacionFechaF']!=NULL){
				echo '<td width="50%"><b> C&Oacute;DIGO DE REGISTRO:&nbsp;&nbsp;&nbsp; '.$get_cod['RegistroPCodigo'].'</b> </td>';
				echo '<td><a href="JavaScript:" onClick="cher.cod.value=\''.$get_cod['RegistroPCodigo'].'\'; cher.target=\'pr\';cher.action=\'print-cert.php\';cher.submit();"> <img src="image/print_black_48dp.png"></a> </td>';
			};
?>
			</tr>
		</table><br>
<?php */ ?>
		<center><strong><font size='+1'>INFORMACI&Oacute;N PERSONAL</font> </strong></center>
		<table style="background-color:blue; border-color:blue; border-width:1px; border-style:solid;" width ='90%' align='center' cellpadding='3' cellspacing='1' class='seccion'>
			<tr  bgcolor='#ffffff' >
				<td><b>DOCUMENTO IDENTIFICACI&Oacute;N:</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['idProfesional']?>
					<INPUT type='hidden' name='idProf' value='<?php echo $stp['idProfesional']?>'>
				</td>
				<td><b></font>NOMBRES:</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalNombres']?><br>
					<div id='dname' style="DISPLAY:none; ">
						<input type="text" name="name" value="<?php echo $stp['ProfesionalNombres']?>" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
					</div><script>expandit2('dname',0)</script>
				</td>
				<td><b></font>APELLIDOS:</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalApellidos']?><br>
					<div id='dlname' style="DISPLAY:none; ">
						<input type="text" name="lname" value="<?php echo $stp['ProfesionalApellidos']?>" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
					</div><script>expandit2('dlname',0)</script>
				</td>
			</tr>
			<tr bgcolor='#ffffff'>
				<!--<td><b>G&eacute;nero:</b> &nbsp;&nbsp;&nbsp;<?php echo format_cont_db('ProfesionalGenero',$stp['ProfesionalGenero'])?><br></td>-->
				<td colspan='2'><b>FECHA NACIMIENTO :</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalFecNacim']?>
					<div id='dfnac' style="DISPLAY:none; ">
						<input type="text" name="fnac" value="<?php echo str_replace('-','/',$stp['ProfesionalFecNacim'])?>" size="11" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" >
					</div><script>expandit2('dfnac',0)</script>
				</td>
				<td><b>PA&Iacute;S NACIMIENTO:</b>&nbsp;&nbsp;&nbsp;<?php echo format_cont_db('idNacionalidad',$stp['Nacionalidad_idNacionalidad'])?></td>
			</tr>
			<tr bgcolor='#ffffff'>
				<td><b>PA&Iacute;S RESIDENCIA:</b>&nbsp;&nbsp;&nbsp;<?php echo format_cont_db('idPaisr',$stp['Ciudadr_Paisr_idPaisr'])?><br>
					<div id='dpaisr' style="DISPLAY:none; ">
						<?php load_of_db('idPaisr',$stp['Ciudadr_Paisr_idPaisr'])?>
					</div><script>expandit2('dpaisr',0)</script>
				</td>
				<td><b>CIUDAD RESIDENCIA:</b>&nbsp;&nbsp;&nbsp;<?php echo format_cont_db('idCiudadr',$stp['Ciudadr_idCiudadr'])?><br>
					<div id='dciudadr' style="DISPLAY:none; ">
						<input type="text" disabled name="ciudadr" value="<?php echo format_cont_db('idCiudadr',$stp['Ciudadr_idCiudadr'])?>" size="20" maxlength="45" onClick="">
						<a class='info' name='sen' href="Javascript:  " onClick="getc();abrir('','get_c',ancho/3,alto/3,0);post1.ciu_co.value='<?php echo $stp['Ciudadr_idCiudadr'];?>';post1.target='get_c';post1.action='get_c.php';post1.submit();post1.target='_self';return false;"><img src='image/downa.png'><!--Actualizar--></a></b>
				<script>post1.id_ciu.value='<?php echo $stp['Ciudadr_idCiudadr']?>'</script>
					</div><script>expandit2('dciudadr',0)</script>
				</td>
				<td><b>DIRECCI&Oacute;N:</b><br><?php echo $stp['ProfesionalDireccion']?><br>
					<div id='ddirec' style="DISPLAY:none; ">
						<input type="text" name="direc" value="<?php echo $stp['ProfesionalDireccion']?>" size="40" maxlength="200" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
					</div><script>expandit2('ddirec',0)</script>
				</td>
			</tr>
			<tr bgcolor='#ffffff'>
				<td><b>TEL&Eacute;FONO M&Oacute;VIL:</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalTlfmovil']?><br>
					<div id='dtmovil' style="DISPLAY:none; ">
						<input type="text" name="tmovil" value="<?php echo $stp['ProfesionalTlfmovil']?>" size="13" maxlength="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
					</div><script>expandit2('dtmovil',0)</script>
				</td>
				<td><b>TEL&Eacute;FONO FIJO:</b>&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalTlfFijo']?><br>
					<div id='dtfijo' style="DISPLAY:none; ">
						<input type="text" name="tfijo" value="<?php echo $stp['ProfesionalTlfFijo']?>" size="13" maxlength="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" >
					</div><script>expandit2('dtfijo',0)</script>
				</td>
				<td><b>CORREOS ELECTR&Oacute;NICOS:</b><br>Principal:&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalMail']?><br>
					Alternativo:&nbsp;&nbsp;&nbsp;<?php echo $stp['ProfesionalMail2']?><br>
					<div id='dmails' style="DISPLAY:none; ">
						<input type="text" name="email" value="<?php echo $stp['ProfesionalMail']?>" size="30" maxlength="100" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
						<input type="text" name="email2" value="<?php echo $stp['ProfesionalMail2']?>" size="30" maxlength="100" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" >
					</div><script>expandit2('dmails',0)</script>
				</td>
			</tr>
		</table><br>
<?php
	};
	$i=1;
	$cont='';
	$facont='';
	$stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='".$_SESSION['user']."'");
?>
	<br>
	<center><strong><font size='+1'>INFORMACI&Oacute;N ACAD&Eacute;MICA</font> </strong></center>

			<p align='center'>
					<a name='sen' style='font-size:12px' class='info' href="Javascript:" onClick="abrir('http://www.senescyt.gob.ec/web/guest/index.php/consultas/<?php echo $_SESSION['user']?>','sene',ancho/1.5,alto,0);">
						<img height="50" title="Consulte sus datos en SENESCYT" alt="Consulte sus datos en SENESCYT" style="border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff; background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;" src='image/logo-senescyt.png'>
					</a></p>		
					 <p align='center'><strong> Nota: ingrese s&oacute;lo los t&iacute;tulos afines, sean de 3 o 4 nivel, use el enlace a SENESCYT para consultar. 
				</strong></p>
	<table style="background-color:blue; border-color:blue; border-width:1px; border-style:solid;" width ='90%' align='center' cellpadding='3' cellspacing='1' class='seccion'>
<?php
	
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$facont=$i;
		if($i>1){$cont=$i;};
		if($row['FAcademicaTituloUsado']){$used_color='#aae4aa';}else{$used_color='#ffffff';}
?>
		<tr bgcolor='#ffffff'>
<!--			<td width='1%'>
			<div style=" border: 0px solid black; float:left; width:10px; font-size:px; background-color:<?php echo $used_color?>;">&nbsp;</div>
			</td>-->
			<td><b>NIVEL T&Iacute;TULO:</b><br><?php echo format_cont_db('FAcademicaNivel',$row['FAcademicaNivel'])?>
				<input type='hidden' name='fa<?php echo $facont;?>' value='1'>
				<input type='hidden' name='idFa<?php echo $cont;?>' value='<?php echo $row['idFAcademica']?>'>
					<div id='dnit<?php echo $cont;?>' style="DISPLAY:none; ">
							<SELECT NAME="NivelT<?php echo $cont;?>" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
								<OPTION <?php if($row['FAcademicaNivel']==3){ echo 'selected';}; ?> value="3">Tercer Nivel</OPTION>
								<OPTION <?php if($row['FAcademicaNivel']==4){ echo 'selected';}; ?> value="4">Cuarto Nivel</OPTION>
							</SELECT>
					</div><script>expandit2('dnit<?php echo $cont;?>',0)</script>  
			</td>
			<td><b>NOMBRE T&Iacute;TULO:</b><br><?php echo $row['FAcademicaNTitulo']?><br>
				<div id='dnti<?php echo $cont;?>' style="DISPLAY:none; ">
					<input type="text" name="ntitulo<?php echo $cont;?>" value="<?php echo str_replace('especificar','',$row['FAcademicaNTitulo'])?>" size="50" maxlength='255' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
				</div><script>expandit2('dnti<?php echo $cont;?>',0)</script>
			</td>
			<td><b>INSTITUCI&Oacute;N:</b><br><?php echo $row['FAcademicaInstitucion']?><br>
				<div id='dnin<?php echo $cont;?>' style="DISPLAY:none; ">
					<input type="text" name="ninstitucion<?php echo $cont;?>" value="<?php echo str_replace('especificar','',$row['FAcademicaInstitucion'])?>" size="50" maxlength='255' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
				</div><script>expandit2('dnin<?php echo $cont;?>',0)</script>
			</td>
			<td><b>FECHA GRADUACI&Oacute;N:</b><br><?php echo str_replace('-','/',$row['FAcademicaFecGrado'])?><br>
				<div id='dfti<?php echo $cont;?>' style="DISPLAY:none; ">
					<input type="text" name="ftitulo<?php echo $cont;?>" value="<?php echo str_replace('-','/',str_replace('0000-00-00','',$row['FAcademicaFecGrado']))?>" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" >
				</div><script>expandit2('dfti<?php echo $cont;?>',0)</script>
			</td>
			<td><b>N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br><?php echo $row['FAcademicaCSenescyt']?><br>
				<div id='dcod<?php echo $cont;?>' style="DISPLAY:none; ">
					<input type="text" name="codigo<?php echo $cont;?>" value="<?php echo eregi_replace("[1-9]{1}-actualice-".$stp['idProfesional'],'',$row['FAcademicaCSenescyt'])?>" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" >
				</div><script>expandit2('dcod<?php echo $cont;?>',0)</script>
			</td>
		</tr>
<?php
	$i++;
	};
?>
<?php  ?>		<TR bgcolor='#ffffff'>
			<td colspan='6' align='center'>
				<?php /* ?><div id='addtit' style="DISPLAY: none;"><input class='buton' type="button" name="addti" value="Agregar T&iacute;tulo(s)" onClick="abrir('','add_ti',ancho*0.9,alto*0.75,0);post1.target='add_ti';post1.action='post-stat-agrega-titulo.php';post1.submit();post1.target='_self';return false;"></div><script>expandit2('addtit',0)</script><?php */ ?>
			</td>
		</tr>
	</table><br>
<?php
	if(!$p_actualizo or ($_POST['edit_soli'])){
?>
		<center>
		<div id='noedit' style="DISPLAY:;"><input class='buton' type="button" name="edit" value="Editar datos" onFocus="" onBlur="" onClick="_edit(1);resiz('<?php echo $_POST['ifid']?>')"></div>
		<div id='edit' style="DISPLAY: none; "> 
			<input class='buton' type="button" name="send" value="Actualizar" onClick="if(validate()){post1.target='_self';post1.action='post2-edit.php';post1.submit();}">
			<input class='buton' type="button" name="cancel" value="Cancelar cambios"  onClick="post1.reset();_edit(0);resiz('<?php echo $_POST['ifid']?>')">
		</div><script>expandit2('edit',0)</script>
	</center>
<?php
	};
?>
<!--	<b>Leyenda:</b><br>
	<div style=" border: 0px solid black; float:left; width:10px; font-size:px; background-color:#aae4aa;">&nbsp;</div> &nbsp;&nbsp;&nbsp;Datos usado en otra solicitud-->
</form>
<?php
	if($last_actu=='0000-00-00 00:00:00' and !$reg_act){  //el registro esta inactivo, se debe actualiza desde la migracion
?>
		<script>post1.prim_upd.value='1';</script>
<?php
	};
?>
<?php
$db=null;
exit;
?>
