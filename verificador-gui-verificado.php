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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_verif.js"></SCRIPT>
 <HTML>
<BODY onload="">
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
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
	//query("SELECT count(t1.idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones  and t2.TipoProfesional_TipoProfesionalId='".$usm."')")
	$stotp_ = $db->query("SELECT count(idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."')");
	$stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
	$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

	$stfac = $db->query("SELECT t1.*, timediff(PostulacionFechaD, PostulacionFechaV) as dif3, timediff(PostulacionFechaF, PostulacionFechaD) as dif4, timediff(PostulacionFechaF, PostulacionFechaI) as dif5  FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionAsignado=1 and t1.PostulacionVerificado=1 and t1.PostulacionFechaD IS NOT NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."') ORDER BY t1.PostulacionFechaV DESC LIMIT ".$inicio."," . $TAMANO_PAGINA);
?>
	<center><img height='30' src='image/proces3-5.png'></center>
		<center><strong><br>Solicitudes Validadas: <?php echo $stotp['tot']?><br></strong></center>
		<table border='1' width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion2'>
			<tr bgcolor='#ffffff'>
				<tH><B>Solicitud:<!--</b></th>
				<th><b>Fecha y Hora Solicitud:--></b></th>
				<th><b>T&eacute;cnico Asignado:</b><!--</th>
				<th><b>Fecha y Hora Asignaci&oacute;n:</b>--></th>
<!--				<th><b>Fecha y Hora Revisi&oacute;n:</b></th>-->
				<th><b>Informe T&eacute;nico:</b></th>
				<th><b>Respuesta a Solicitud:</b></th>
				<th><b>Fecha y Hora Validaci&oacute;n:</b></th>
				<th><b>Fecha y Hora  Notificaci&oacute;n a Solicitante:</b></th>
			</tr>
<?php  
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$st_tipro= $db->query("SELECT Profesional_idProfesional, TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones='".$row['Profesiones_idProfesiones']."'");
		$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);
		if ($stipro['TipoProfesional_TipoProfesionalId']==$_POST['us_maneja']){

			$st_val_as = $db->query("SELECT user_username,AccionEnPostulacionFechaAs, timediff(AccionEnPostulacionFechaAs,'".$row['PostulacionFechaI']."') as dif1, timediff('".$row['PostulacionFechaV']."',AccionEnPostulacionFechaAs) as dif2  FROM AccionEnPostulacion WHERE Postulacion_idPostulacion=".$row['idPostulacion']." and AccionEnPostulacionAccion=4 and AccionEnPostulacionActiva=1");
			$val_as= $st_val_as->fetch(PDO::FETCH_ASSOC);
			$sql_prev_validr="SELECT user_username,AccionEnPostulacionFechaAs FROM AccionEnPostulacion WHERE AccionEnPostulacionAccion=4 and AccionEnPostulacionActiva=0 and Postulacion_idPostulacion=".$row['idPostulacion'];
			$st_get_prev_validador=$db->query($sql_prev_validr);
			if ($st_get_prev_validador->rowCount()>0){			
				$get_prev_validador=$st_get_prev_validador->fetchAll();				
			}

			$st_inf_te = $db->query("SELECT * FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
			$inf_te= $st_inf_te->fetch(PDO::FETCH_ASSOC);
			$st_inf_sr = $db->query("SELECT * FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
			if ($st_inf_sr->rowCount()){
				$inf_sr= $st_inf_sr->fetch(PDO::FETCH_ASSOC);
			};
?>
			<tr bgcolor='#ffffff' align='center' >
				<td ><?php echo format_cont_db('idProfesional',$stipro['Profesional_idProfesional'])?><!--</td>
				<td >--><br><br><?php echo str_replace(' ','<br>',$row['PostulacionFechaI'])?></td>
				<td><?php if(isset($get_prev_validador)){foreach($get_prev_validador as $pvalidador){echo "Asignado a:".format_cont_db('username',$pvalidador['user_username'])."<br>".str_replace(' ','<br>',$pvalidador['AccionEnPostulacionFechaAs'])." <br><br>   ";};};?> Asignado a: <?php echo format_cont_db('username',$val_as['user_username'])?>
				<br><?php echo str_replace(' ','<br>',$val_as['AccionEnPostulacionFechaAs'])?><br><br>Tiempo transcurrido: <?php echo $val_as['dif1']?></td>
<!--				<td ><?php echo str_replace(' ','<br>',$row['PostulacionFechaV'])?><br><br>Tiempo transcurrido: <?php echo $val_as['dif2']?></td>-->
				<td>
					Documento Referencia: <br>
					<b><?php echo $inf_te['InformeTecnicoRefDoc']?></b><br> <br>
					Observaciones:<br>
					<b><?php echo $inf_te['InformeTecnicoObservacion']?></b>
<br><br><?php echo str_replace(' ','<br>',$row['PostulacionFechaV'])?><br><br>Tiempo transcurrido: <?php echo $val_as['dif2']?>
				</td>
				<td <?php if (!$st_inf_sr->rowCount()){ echo "bgcolor='#dddddd'";};?> >
<?php
			$file=$file_prefix.$row['idPostulacion'].'.pdf';
			$flink='';
			if (exist_doc($file)){
				$flink="<a href='http://". $_SERVER['SERVER_NAME']."/storage/". $file." target='new'><img src='image/icon_pdf.gif' height='18' alt='Ver Documento' Title='Ver Documento'></a>" ;
			};
?>
					<b><?php echo strtoupper($inf_te['InformeTecnicoRecomendacion'])?> </b>
<?php
			if($inf_te['InformeTecnicoRecomendacion']=='aprobada'){
					echo "<br><br>C&oacute;digo Registro: <b><br>".$inf_te['InformeTecnicoCodPro']."</b>";
			};

			if ($st_inf_sr->rowCount()){
				if($inf_te['InformeTecnicoRecomendacion']=='rechazada'){
					echo "<br><br>Oficio Respuesta: <b><br>".$inf_sr['SolicitudRespuestaRefDoc']."</b><br>".$flink;
					echo "<br><br>Observaciones:<b><br>".$inf_sr['SolicitudRespuestaResumen']."</b>";
				};
			};
?>
				</td>
				<td>	<?php echo str_replace(' ','<br>',$row['PostulacionFechaD'])?><br><br>Tiempo transcurrido: <?php echo $row['dif3']?>
				</td>
				<td>	<?php echo str_replace(' ','<br>',$row['PostulacionFechaF'])?><br><br>Tiempo transcurrido: <?php echo $row['dif4']?><br><br><font color='blue'><b>Tiempo total de tr&aacute;mite: <?php echo $row['dif5']?></b></font>
				</td>
				<!--<td class='menubar' nowrap align='center'><a href="JavaScript:" onClick="if(validate('<?php echo $fname?>')){cher.target='_self';<?php echo $fname?>.action='verificar-post.php';<?php echo $fname?>.submit();};return false;">[Remitir a D. Ejecutiva]</a></td>-->
			</tr>
<?php
		};
	};//fin validadas y verificadas
?>
		</table><br><br>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href=""  class="info" style="font-size:11px;" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-verificado.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href=""  class="info" style="font-size:11px;" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-verificado.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href=""  class="info" style="font-size:11px;" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-verificado.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
};
$db=null;
exit;
?>
