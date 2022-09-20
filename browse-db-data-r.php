<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		header("Location: index.php");
		exit;
	};

?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
		var url;
		var url_base="http://www.senescyt.gob.ec/web/guest/index.php/consultas/";
	</SCRIPT>
 <HTML>
<BODY>
<div style=" position:absolute;border: 0px; float:left; width:20px; height:20px; " onClick="cher.target='_self';cher.action='browse-db-data-r.php';cher.submit();return false;">
	<a href="JavaScript:" ><img onMouseOver="this.style.height='24px';swap('reloadi.png','reload.png','rld');" onMouseOut="this.style.height='18px'; swap('reload.png','reloadi.png','rld');" name='rld' height='18' src='image/reload.png' alt="Refrescar pantalla" title="Refrescar pantalla"><!--Ayuda --></a>
</div><br>
	<form name="cher" action=" " method="post" >
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
		<input type="hidden" name="prof">
		<input type='hidden' name='basecod' >
		<input type='hidden' name='us_maneja' value="<?php echo $_POST['us_maneja']?>">
        <input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">


<?php
	$fcodigo='';
	$cfcodigo='';
	$fnames='';
	$cfnames='';
	$flugar='';
	$cflugar='';
	$ftelfs='';
	$cftelfs='';
	$fmails='';
	$cfmails='';
	$ftitu='';
	$cftitu='';
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
	if(isset($_POST['flugar']) and $_POST['flugar']){
		if($fnames or $hayf){$cfnames=' AND';}
		$flugar="(RegistroPCiudadr like '%".$_POST['flugar']."%' or RegistroPPaisr like '%".$_POST['flugar']."%' )";
		$hayf++;
	};
	if(isset($_POST['ftelfs']) and $_POST['ftelfs']){
		if($flugar or $hayf){$cflugar=' AND';}
		$ftelfs="(RegistroPTlfFijo like '%".$_POST['ftelfs']."%' or RegistroPTlfMovil like '%".$_POST['ftelfs']."%' )";
		$hayf++;
	};
	if(isset($_POST['fmails']) and $_POST['fmails']){
		if($ftelfs or $hayf){$cftelfs=' AND';}
		$fmails="(RegistroPMail like '%".$_POST['fmails']."%' or RegistroPMail2 like '%".$_POST['fmails']."%' )";
		$hayf++;
	};
#	if(isset($_POST['ftitu']) and $_POST['ftitu']){
#		if($fmails or $hayf){$cfmails=' AND';}
#		$ftitu="(Profesional_idProfesional in (SELECT CONVERT(Profesional_idProfesional using utf8) collate utf8_spanish_ci FROM FAcademica WHERE FAcademicaNTitulo like '%".$_POST['ftitu']."%'))";
#		$hayf++;
#	};
	
	if ($hayf){
		$filtro=" AND ( $fcodigo $cfcodigo $fnames $cfnames $flugar $cflugar $ftelfs $cftelfs $fmails $cfmails $ftitu )";
	};
	//Limito la busqueda
	$TAMANO_PAGINA = 8;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_POST["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	};
		$sql_tot="SELECT count(idRegistroP) as tot FROM RegistroP WHERE RegistroPProfesionalID=".$_POST['us_maneja']." AND RegistroPActivo = 1 and RegistroPSinT = 1 $filtro ORDER BY RegistroPCodigo ASC";
        $stotp_ = $db->query($sql_tot);
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);
		if($stotp['tot']==1 and $pagina > 1){$inicio=0;}
		if ($inicio > $stotp['tot']){$inicio=0;};
				
		$sql_sql="SELECT * FROM RegistroP WHERE RegistroPProfesionalID=".$_POST['us_maneja']." AND RegistroPActivo = 1 and RegistroPSinT = 1 $filtro ORDER BY RegistroPCodigo ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
		$stfac = $db->query($sql_sql);
?>
<center><strong><?php echo format_cont_db('TipoProfesionalId',$_POST['us_maneja']) ?>&nbsp;&nbsp; de Acuerdo a Resoluci&oacute;n: No.5-DE-INPC-2015  del 14 de enero de 2015
<br> REGISTRADOS: <?php echo $stotp['tot'] ?></strong></center>
<table border='1' width ='90%' align='center' cellpadding='4' cellspacing='1' class='seccion2'>
	<tr bgcolor='#ffffff' >
		<th nowrap>C&oacute;digo Registro:</th>
<!--		<th nowrap>Doc Identificaci&oacute;n:</th>-->
		<th nowrap>Apellidos y Nombres:</th>
		<!--<th nowrap>G&eacute;nero:</th>-->
		<!--<th nowrap>Direcci&oacute;n:</th>-->
		<th nowrap>Lugar Residencia:</th>
<!--		<th nowrap>Pa&iacute;s Residencia:</th>-->
<!--		<th nowrap>Tlf. Fijo:</th>-->
		<th nowrap >Tel&eacute;fono(s):</th>
		<th nowrap>Email(s):</th>
<!--		<th nowrap>T&iacute;tulos:</th>-->

<!--		<th nowrap>Fecha Habilitaci&oacute;n:</th>-->
	</tr>
	<tr  align='left'>
		<td>
			<input type="text" name="fcodigo" value="<?php if(isset($_POST['fcodigo'])){echo $_POST['fcodigo'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fnames" value="<?php if(isset($_POST['fnames'])){echo $_POST['fnames'];}?>" size="18" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="flugar" value="<?php if(isset($_POST['flugar'])){echo $_POST['flugar'];}?>" size="12" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="ftelfs" value="<?php if(isset($_POST['ftelfs'])){echo $_POST['ftelfs'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
		<td>
			<input type="text" name="fmails" value="<?php if(isset($_POST['fmails'])){echo $_POST['fmails'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
		</td>
	</tr>
	<tr><td colspan='7' align='center'><B><a class='elipse' href="Javascript:" onClick="cher.target='_self';cher.action='browse-db-data-r.php';cher.submit();return false">&nbsp;Filtrar&nbsp;</a>
<?php
						if($hayf){
?>
								<a class='elipse' href='JavaScript:' onClick="cher.ftelfs.value='';cher.flugar.value='';/*cher.ftitu.value='';*/cher.fmails.value='';cher.fnames.value='';cher.fcodigo.value='';cher.target='_self';cher.action='browse-db-data-r.php';cher.submit();return false">&nbsp;Quitar filtro&nbsp;</a> 
<?php
						
						}
?>
 </b></td> </tr>
<?php
		while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
#		$get_tit= $db->query("SELECT FAcademicaNTitulo FROM FAcademica WHERE Profesional_idProfesional='".$row['Profesional_idProfesional']."'");
?>
	<tr bgcolor='#ffffff'>
		<td><?php echo $row['RegistroPCodigo']?></td>
<!--		<td><?php echo $row['Profesional_idProfesional']?></td>-->
		<td nowrap><?php echo mb_strtoupper($row['RegistroPApellidos'].' '.$row['RegistroPNombres'])?></td>
		<!--<td><?php echo $row['RegistroPGenero']?></td>-->
		<!--<td><?php echo $row['RegistroPDireccion']?></td>-->
		<td align='center'><?php echo $row['RegistroPCiudadr']?><!--</td>--><br>
		<!--<td>--><?php echo $row['RegistroPPaisr']?></td>
<!--		<td><?php echo $row['RegistroPTlfFijo']?></td>-->
		<td><?php echo str_replace('no especifica','',$row['RegistroPTlfFijo']); if($row['RegistroPTlfMovil']!=''){ echo '<br>'.str_replace('no especifica','',$row['RegistroPTlfMovil']);};?></td>
		<td><?php echo str_replace('no especifica','',$row['RegistroPMail']); if($row['RegistroPMail2']!=''){ echo '<br>'.str_replace('no especifica','',$row['RegistroPMail2']);};?></td>
<!--		<td><?php echo $row['RegistroPMail2']?></td>-->
<!--		<td><?php echo $row['RegistroPFechaRegistro']?></td>-->
<?php /*			<td nowrap>

		$i=0;
			while($tit = $get_tit->fetch(PDO::FETCH_ASSOC)) {
				if ($i >0){echo '<br><br>';};?>
				<a title="Consultar en SENESCYT" class='info' style="font-size:11px;" href="JavaScript:" onClick="url_=url_base+'<?php echo $row['Profesional_idProfesional']?>';abrir(url_,'sene',ancho/1.5,alto,0);return false;"><?php echo $tit['FAcademicaNTitulo'];?></a>
<?php				$i++;
			}; 
?>
			</td><?php */?>
		<!--<td  align='center' class='menubar' nowrap>
		&nbsp;</a>&nbsp;
		</td>-->
	</tr>

<?php
		};

?>
	</table>
	</form>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a class="info" href="" onClick="cher.target=\'idbx3\';cher.action=\'browse-db-data-r.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a class="info" href="" onClick="cher.target=\'idbx3\';cher.action=\'browse-db-data-r.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href="" onClick="cher.target=\'idbx3\';cher.action=\'browse-db-data-r.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
};

$db=null;
exit;
?>
