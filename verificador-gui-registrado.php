<?php
	$es_hijo=1;
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
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/index.php/consultas/";
	</SCRIPT>

 <HTML>
<BODY>
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type="hidden" name="ver_dseguro">
         <input type="hidden" name="idpost">
         <input type='hidden' name='basecod' >
         <input type='hidden' name='act_dea' >
		<input type='hidden' name='us_maneja' value="<?php echo $_POST['us_maneja']?>" >
         <input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">
<?php														//TRATAMIENTO DE LOS PROFESIONALES REGISTRADOS HABILITACION DESHABILITACION
	$fcodigo='';
	$cfcodigo='';
	$fnames='';
	$cfnames='';
	$fgenero='';
	$cfgenero='';
	$flugar='';
	$cflugar='';
	$ftelfs='';
	$cftelfs='';
	$fmails='';
	$cfmails='';
	$ftitu='';
	$cftitu='';
	$fhabil='';
	$hayf=0;
	$filtro='';
	if(isset($_POST['fcodigo']) and $_POST['fcodigo']){
		$fcodigo="RegistroPCodigo like '%".$_POST['fcodigo']."%'";
		$hayf++;
	};
	if(isset($_POST['fnames']) and $_POST['fnames']){
		if($hayf){$cfcodigo=' AND';}
		$fnames="(RegistroPApellidos like '%".$_POST['fnames']."%' or RegistroPNombres like '%".$_POST['fnames']."%' )";
		$hayf++;
	};
	if(isset($_POST['fgenero']) and $_POST['fgenero']){
		if($fnames or $hayf){$cfnames=' AND';}
		$fgenero="RegistroPGenero like '%".$_POST['fgenero']."%'";
		$hayf++;
	};
	if(isset($_POST['flugar']) and $_POST['flugar']){
		if($fgenero or $hayf){$cfgenero=' AND';}
		$flugar="(RegistroPCiudadr like '%".$_POST['flugar']."%' or RegistroPPaisr like '%".$_POST['flugar']."%' )";
		$hayf++;
	};
	if(isset($_POST['ftitu']) and $_POST['ftitu']){
		if($flugar or $hayf){$cflugar=' AND';}
		$ftitu="(Profesional_idProfesional in (SELECT CONVERT(Profesional_idProfesional using utf8) collate utf8_spanish_ci FROM FAcademica WHERE FAcademicaNTitulo like '%".$_POST['ftitu']."%'))";
		$hayf++;
	};
	if(isset($_POST['ftelfs']) and $_POST['ftelfs']){
		if($ftitu or $hayf){$cftitu=' AND';}
		$ftelfs="(RegistroPTlfFijo like '%".$_POST['ftelfs']."%' or RegistroPTlfMovil like '%".$_POST['ftelfs']."%' )";
		$hayf++;
	};
	if(isset($_POST['fmails']) and $_POST['fmails']){
		if($ftelfs or $hayf){$cftelfs=' AND';}
		$fmails="(RegistroPMail like '%".$_POST['fmails']."%' or RegistroPMail2 like '%".$_POST['fmails']."%' )";
		$hayf++;
	};
	if(isset($_POST['fhabil']) and $_POST['fhabil']){
		if($fmails or $hayf){$cfmails=' AND';}
		$fhabil="RegistroPFechaRegistro like '%".$_POST['fhabil']."%'";
		$hayf++;
	};
	
	if ($hayf){
		$filtro=" AND ( $fcodigo $cfcodigo $fnames $cfnames $fgenero $cfgenero $flugar $cflugar $ftitu $cftitu $ftelfs $cftelfs $fmails $cfmails $fhabil )";
	};
	//Limito la busqueda
	$TAMANO_PAGINA =10;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_POST["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	};
		$sql_tot="SELECT count(RegistroPCodigo) as tot FROM RegistroP WHERE RegistroPProfesionalID=".$_POST['us_maneja']." $filtro ORDER BY RegistroPCodigo ASC ";
        $stotp_ = $db->query($sql_tot);
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);

		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);
	$sql_sql="SELECT * FROM RegistroP WHERE RegistroPProfesionalID=".$_POST['us_maneja']." $filtro ORDER BY RegistroPCodigo ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
	$get_prof_reg = $db->query($sql_sql);
?>
	<center><img height='30' src='image/proces4.png'></center>
		<center><strong>Profesionales Registrados: <?php echo $stotp['tot']?></strong></center>
	<table border='1' width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion2'>
		<tr bgcolor='#ffffff'>
			<tH><B>C&oacute;digo de Registro:</b></th>
			<tH><B>Apellidos y Nombres:</b></th>
			<th><b>G&eacute;nero:</b></th>
			<th><b>Direcci&oacute;n:</b></th>
			<th><b>Lugar Residencia:</b></th>
			<th><b>T&iacute;tulos:</b></th>			
			<th><b>Tel&eacute;fono(s):</b></th>
			<th><b>Email(s):</b></th>
			<th><b>Fecha Habilitaci&oacute;n:</b></th>
<?php
		if($_SESSION['tuser']!=2){
?>
			<td bgcolor='#fed9a3' align='center'><b>Acciones / Enlaces</b></td>
<?php
		};
?>
		</tr>
	<tr  align='left'>
		<td>
			<input type="text" name="fcodigo" value="<?php if(isset($_POST['fcodigo'])){echo $_POST['fcodigo'];}?>" size="10" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fnames" value="<?php if(isset($_POST['fnames'])){echo $_POST['fnames'];}?>" size="12" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fgenero" value="<?php if(isset($_POST['fgenero'])){echo $_POST['fgenero'];}?>" size="3" maxlength="3" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td width='40%'>
		</td>
		<td>
			<input type="text" name="flugar" value="<?php if(isset($_POST['flugar'])){echo $_POST['flugar'];}?>" size="9" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="ftitu" value="<?php if(isset($_POST['ftitu'])){echo $_POST['ftitu'];}?>" size="25" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>		
		<td>
			<input type="text" name="ftelfs" value="<?php if(isset($_POST['ftelfs'])){echo $_POST['ftelfs'];}?>" size="10" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fmails" value="<?php if(isset($_POST['fmails'])){echo $_POST['fmails'];}?>" size="10" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fhabil" value="<?php if(isset($_POST['fhabil'])){echo $_POST['fhabil'];}?>" size="10" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
	</tr>
	<tr ><td colspan='10' align='center'><B><a class='elipse' href="Javascript:" onClick="cher.target='_self';cher.action='verificador-gui-registrado.php';cher.submit();return false">&nbsp;Filtrar&nbsp;</a>
<?php
						if($hayf){
?>
								<a class='elipse' href='JavaScript:' onClick="cher.ftelfs.value='';cher.fhabil.value='';cher.fgenero.value='';cher.flugar.value='';cher.ftitu.value='';cher.fmails.value='';cher.fnames.value='';cher.fcodigo.value='';cher.target='_self';cher.action='verificador-gui-registrado.php';cher.submit();return false">&nbsp;Quitar filtro&nbsp;</a> 
<?php
						
						}
?>
 </b></td> </tr>
         </form>

<?php
	while($row = $get_prof_reg->fetch(PDO::FETCH_ASSOC)) {
		$get_tit= $db->query("SELECT FAcademicaNTitulo FROM FAcademica WHERE Profesional_idProfesional='".$row['Profesional_idProfesional']."'");
?>
		<tr bgcolor='#ffffff'>
			<td nowrap><?php echo $row['RegistroPCodigo']?></td>
			<td nowrap>
				<a class='info'  style="font-size:11px;"  href="Javascript:" onClick="abrir('','verd',(ancho*0.9),alto*0.5,0);cher.prof.value='<?php echo $row['Profesional_idProfesional']?>';cher.ver_dseguro.value='0';cher.target='verd';cher.action='validar-datos.php';cher.submit();return false;">
					<b><?php echo $row['RegistroPApellidos'].'<br> '.$row['RegistroPNombres']?></b>
				</a>
			</td>
<?php
	$genero=($row['RegistroPGenero']=='Femenino')?'Fem':'Mas';
?>
			<td align='center'><?php echo $genero?></td>
			<td width='40%'><?php echo $row['RegistroPDireccion']?></td>
			<td align='center'><?php echo $row['RegistroPCiudadr']?><br><?php echo $row['RegistroPPaisr']?></td>
			<td width='40%'>
<?php
		$i=0;
			while($tit = $get_tit->fetch(PDO::FETCH_ASSOC)) {
				if ($i >0){echo '<br><br>';};
				echo $tit['FAcademicaNTitulo'];
				$i++;
			};
?>
			</td>
			<td nowrap><?php echo str_replace('/','<br>',str_replace('no especifica','',$row['RegistroPTlfFijo'])); if($row['RegistroPTlfMovil']!=''){ echo '<br>'.str_replace('/','<br>',str_replace('no especifica','',$row['RegistroPTlfMovil']));};?></td>
			<td><?php echo $row['RegistroPMail']; if($row['RegistroPMail2']!=''){ echo '<br>'.str_replace('no especifica','',$row['RegistroPMail2']);};?></td>
			<td align='center'><?php echo str_replace(' ','<br>',$row['RegistroPFechaRegistro'])?></td>
<?php
		if($_SESSION['tuser']!=2){

?>
			<td  align='center' class='menubar' nowrap>
<!--				&nbsp;<a style="font-size: 11px;" href="JavaScript:" onClick="url_=url_base+'<?php echo $row['Profesional_idProfesional']?>';abrir(url_,'sene',ancho/1.5,alto/1.5,0);return false;">R Senescyt</a>&nbsp;<br>-->
<?php
			$get_actu=$db->query("SELECT ProfesionalActualizo, ProfesionalLastActu FROM Profesional WHERE idProfesional='".$row['Profesional_idProfesional']."'");
			$actu=$get_actu->fetch(PDO::FETCH_ASSOC);

			if($actu['ProfesionalActualizo'] and $actu['ProfesionalLastActu']!='0000-00-00 00:00:00' ){
				if($row['RegistroPActivo']==1){
					$lab='Desactivar';
					$act=0;
				}else{
					$lab='Activar';
					$act=1;
				};
?>
				<a style="font-size: 11px;" href="JavaScript:" onClick="if (confirm('Completamente Seguro de <?php echo $lab?> al Profesional seleccionado?')){cher.us_maneja.value='<?php echo $_POST['us_maneja']?>';cher.prof.value='<?php echo $row['Profesional_idProfesional']?>';cher.act_dea.value=<?php echo $act?>;cher.action='activ-deactiv-post.php';cher.submit();};return false;"><?php echo $lab?></a>
<?php
			};
?>				
			</td>
<?php
		};
?>
		</tr>

<?php
	};
?>
</table>
<?php
if ($total_paginas > 1) {

	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href="" style="font-size: 11px;" class="info" onClick="cher.target=\'idbr'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-registrado.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href="" style="font-size: 11px;" class="info" onClick="cher.target=\'idbr'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-registrado.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href="" style="font-size: 11px;" class="info" onClick="cher.target=\'idbr'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-registrado.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
}
$db=null;
?>
<a name='ancl' id="ancla">&nbsp;</a>
</body>
</html>
