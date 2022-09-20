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
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_dejec.js"></SCRIPT>
 <HTML>
<BODY>
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>	<form name="cher" action=" " method="post" >	<form name="cher" action=" " method="post" >	<form name="cher" action=" " method="post" >
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
		<input type="hidden" name="prof">
         <input type="hidden" name="ver_dseguro">
         <input type="hidden" name="idpost">
		<input type='hidden' name='basecod' >
		<input type='hidden' name='us_maneja' value="<?php echo $_POST['us_maneja']?>" >
		<input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">
	</form>
<?php
	//Limito la busqueda
	$TAMANO_PAGINA = 5;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_POST["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	};
	$stotp_ = $db->query("SELECT count(idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2  WHERE (t1.PostulacionEstado=1 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL and t1.PostulacionAprobado IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."')" );
	$stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
	$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

	$stfac = $db->query("SELECT t1.*, timediff(PostulacionFechaF, PostulacionFechaI) as dift FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionEstado=1 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL and t1.PostulacionAprobado IS NOT NULL ) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja'].") LIMIT ".$inicio."," . $TAMANO_PAGINA);
?>
	<center><img height='30'  src='image/proces4.png'></center>
<center><strong>SOLICITUDES DESPACHADAS: <?php echo $stotp['tot'] ?></strong></center>
<table border='1' width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion1'>
	<tr bgcolor='#ffffff'>
		<tH><B>Solicitante:</b><!--</th>
		<th><b>Fecha Solicitud:</b>--></th>
		<th><b>T&eacute;cnico Asignado:</b><!--</th>
		<th><b>Fecha Asignaci&oacute;n :</b>--></th>
<!--		<th><b>Fecha Revisi&oacute;n:</b></th>
		<th><b>Fecha Validaci&oacute;n:</b></th>-->
		<th><b>Informe T&eacute;nico:</b></th>
		<th><b>Respuesta a Solicitud:</b></th>
		<th><b>Fecha Despacho:<br>Tiempo empleado:</b></th>
		<!--<th><b>Acciones:</b></th>-->
	</tr>
<?php
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$st_tipro= $db->query("SELECT Profesional_idProfesional, TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones='".$row['Profesiones_idProfesiones']."'");	
		$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);
		if ($stipro['TipoProfesional_TipoProfesionalId']==$_POST['us_maneja']){
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
		<tr bgcolor='#ffffff' align='center'>
			<td>
				<a class='info'  style="font-size:11px;"  href="Javascript:" onClick="abrir('','verd',(ancho*0.9),alto*0.4,0);cher.idpost.value='<?php echo $row['idPostulacion'] ?>';cher.prof.value='<?php echo $stipro['Profesional_idProfesional']?>';cher.ver_dseguro.value='0';cher.target='verd';cher.action='validar-datos.php';cher.submit();return false;">
					<b><?php echo format_cont_db('idProfesional',$stipro['Profesional_idProfesional'])?></b>
				</a>
			<!--</td>
			<td nowrap>--><br><br><?php echo str_replace(' ','<br>',$row['PostulacionFechaI'])?></td>
			<td><?php echo format_cont_db('username',$val_as['user_username'])?><!--</td>
			<td nowrap>--><br><br><?php echo str_replace(' ','<br>',$val_as['AccionEnPostulacionFechaAs'])?></td>
<!--			<td nowrap><?php echo str_replace(' ','<br>',$row['PostulacionFechaV'])?></td>
			<td nowrap><?php echo str_replace(' ','<br>',$row['PostulacionFechaD'])?></td>-->
			<td>
				Referencia : <br>
				<b><?php echo $inf_te['InformeTecnicoRefDoc']?></b><br> <br>
				Observaciones:<br>
				<b><?php echo $inf_te['InformeTecnicoObservacion']?>
			</td>
			<td <?php if (!$st_inf_sr->rowCount()){ echo "bgcolor='#dddddd'";};?> >
<?php
			$file=$file_prefix.$row['idPostulacion'].'.pdf';
			if (exist_doc($file)){
?>
				<b><!--<?php echo $file?>--></b> <a href="http://<?php echo $_SERVER['SERVER_NAME']?>/storage/<?php echo $file?>" target='new'><img src='image/icon_pdf.gif' height='18' alt="Ver Documento" Title="Ver Documento"></a>
<?php
			};
?>
				<b><?php echo strtoupper($inf_te['InformeTecnicoRecomendacion'])?> </b><br>
<?php
			if($inf_te['InformeTecnicoRecomendacion']=='aprobada'){
				echo "C&oacute;digo Registro: <b>".$inf_te['InformeTecnicoCodPro']."</b><br><br>";
			};
			$inf_sr= $st_inf_sr->fetch(PDO::FETCH_ASSOC);
			if($inf_te['InformeTecnicoRecomendacion']=='rechazada'){
?>
				Referencia: <br>
				<b><?php echo $inf_sr['SolicitudRespuestaRefDoc']?></b><br> <br>
				Observaciones:<br>
				<b><?php echo $inf_sr['SolicitudRespuestaResumen']?>
<?php
				};
?>
			</td>
			<td nowrap align='center'><?php echo str_replace(' ','<br>',$row['PostulacionFechaF'])."<br><br><font color='blue'><b>Tiempo total de tr&aacute;mite:".$row['dift'].'</font>'?></td>
			<!--<td nowrap align='center'>
				<a href="JavaScript:" onClick="if(validate('<?php echo $fname?>')){cher.target='_self';<?php echo $fname?>.action='despachar-post.php';<?php echo $fname?>.submit();};return false;">[Notificar a Solicitante]</a>
			</td>-->
		</tr>
<?php
			};
		};
?>
	</table>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a class="info" href="" onClick="cher.target=\'idbd'.$_POST['us_maneja'].'\';cher.action=\'director-gui-despachado.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a class="info"  href="" onClick="cher.target=\'idbd'.$_POST['us_maneja'].'\';cher.action=\'director-gui-despachado.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a  class="info" href="" onClick="cher.target=\'idbd'.$_POST['us_maneja'].'\';cher.action=\'director-gui-despachado.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
};

$db=null;
exit;
?>
