<?php
	$es_hijo=1;
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
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_verif.js"></SCRIPT>
 <HTML>
<BODY onload="">
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.target='_self';cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type="hidden" name="ver_dseguro">
         <input type="hidden" name="idpost">
         <input type="hidden" name="valacad">
         <input type="hidden" name="valdp">
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
#        $stotp_ = $db->query("SELECT count(idPostulacion) as tot FROM Postulacion as t1, Profesional as t2 WHERE (t1.PostulacionEstado=0 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=0 and t1.PostulacionAprobado IS NULL) and (t1.Profesional_idProfesional=t2.idProfesional and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."')");
        $stotp_ = $db->query("SELECT count(t1.idPostulacion) as tot FROM Postulacion as t1, Profesiones as t2 WHERE (t1.PostulacionEstado=0 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=0 and t1.PostulacionAprobado IS NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."')");
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

#	$stfac = $db->query("SELECT * FROM Postulacion WHERE PostulacionEstado=0 and PostulacionAsignado=1 and PostulacionVerificado=0 and PostulacionAprobado IS NULL LIMIT ".$inicio."," . $TAMANO_PAGINA);
	$sql="SELECT t1.* FROM Postulacion as t1, Profesiones as t2  WHERE  (t1.PostulacionEstado=0 and t1.PostulacionAsignado=1 and t1.PostulacionVerificado=0 and t1.PostulacionAprobado IS NULL) and (t1.Profesiones_idProfesiones=t2.idProfesiones and t2.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."') LIMIT ".$inicio."," . $TAMANO_PAGINA;
	$stfac = $db->query($sql);
?>
	<center><img height='30'  src='image/proces2.png'></center>
		<center><strong>Solicitudes Asignadas: <?php echo $stotp['tot']?></strong></center>
		<table border='1' width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion1'>
			<tr bgcolor='#ffffff'>
				<tH><B>Solicitante:</b></th>
				<th><b>Fecha y Hora Solicitud:</b></th>
				<th><b>Estado Tr&aacute;mite:</b></th>
				<th><b>T&eacute;cnico Asignado:</b></th>
				<th><b>Fecha y Hora Asignaci&oacute;n:</b></th>
				<th><b>Tiempo Transcurrido:</b></th>
<!--				<th><b>Respuesta a Solicitud:</b></th>
				<th><b>Acciones:</b></th>-->
			</tr>
<?php
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
#		$st_tipro= $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$row['Profesional_idProfesional']."'");
#		$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);	
#		if ($stipro['TipoProfesional_TipoProfesionalId']==$_POST['us_maneja']){
			$st_tipro= $db->query("SELECT Profesional_idProfesional FROM Profesiones WHERE idProfesiones=".$row['Profesiones_idProfesiones']."");
			$stipro= $st_tipro->fetch(PDO::FETCH_ASSOC);	

			$st_get_validador=$db->query("SELECT user_username,AccionEnPostulacionFechaAs, timediff(AccionEnPostulacionFechaAs,'".$row['PostulacionFechaI']."') as dif1 FROM AccionEnPostulacion WHERE AccionEnPostulacionAccion=4 and AccionEnPostulacionActiva=1 and Postulacion_idPostulacion=".$row['idPostulacion']);
			$get_validador=$st_get_validador->fetch(PDO::FETCH_ASSOC);
			$st_get_prev_validador=$db->query("SELECT user_username,AccionEnPostulacionFechaAs  FROM AccionEnPostulacion WHERE AccionEnPostulacionAccion=4 and AccionEnPostulacionActiva=0 and Postulacion_idPostulacion=".$row['idPostulacion']);
			if ($st_get_prev_validador->rowCount()){
				$get_prev_validador=$st_get_prev_validador->fetchAll();
			}


#			$st_get_validador=$db->query("SELECT user_username,AccionEnPostulacionFechaAs, timediff(AccionEnPostulacionFechaAs,'".$row['PostulacionFechaI']."') as dif1 FROM AccionEnPostulacion WHERE AccionEnPostulacionAccion=4 and Postulacion_idPostulacion=".$row['idPostulacion']);
#			$get_validador=$st_get_validador->fetch(PDO::FETCH_ASSOC);
?>
			<tr bgcolor='#ffffff' align='center'>
				<td>
					<a class='info'  style="font-size:11px;"  href="Javascript:" onClick="abrir('','verd',(ancho*0.9),alto*0.5,0);cher.prof.value='<?php echo $stipro['Profesional_idProfesional']?>';cher.valdp.value='<?php echo $row['PostulacioncCumpleInfoP']?>';cher.valacad.value='<?php echo $row['PostulacionCumpleInfoA']?>';cher.ver_dseguro.value='0';cher.target='verd';cher.action='validar-datos.php';cher.submit();return false;">
						<?php echo format_cont_db('idProfesional',$stipro['Profesional_idProfesional'])?>
					</a>
				</td>						
				<td nowrap><?php echo str_replace(' ','<br>',$row['PostulacionFechaI'])?></td>
				<td><?php echo format_cont_db('PostulacionEstado',$row['PostulacionEstado'])?></td>
				<td><center><?php if(isset($get_prev_validador)){foreach($get_prev_validador as $pvalidador){echo "Asignado a:".format_cont_db('username',$pvalidador['user_username'])."<br>".str_replace(' ','<br>',$pvalidador['AccionEnPostulacionFechaAs'])." <br><br> ";};};?> Asignado a:  <?php echo format_cont_db('username',$get_validador['user_username'])?> </center></td>
				<td><?php echo str_replace(' ','<br>',$get_validador['AccionEnPostulacionFechaAs'])?></td>
				<td align='center'><?php echo $get_validador['dif1']?></td>
<!--				<td><?php echo format_cont_db('PostulacionVerificado',$row['PostulacionVerificado'])?></td>
				<td><?php echo format_cont_db('PostulacionAprobado',$row['PostulacionAprobado'])?></td>
				<td  align='center'></td>-->
			</tr>

<?php
#		};
	};//fin ya asignadas

?>
		</table><br>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href="" style="font-size:11px;" class="info" onClick="cher.target=\'idba'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-asignado.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href="" style="font-size:11px;" class="info" onClick="cher.target=\'idba'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-asignado.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href="" style="font-size:11px;" class="info" onClick="cher.target=\'idba'.$_POST['us_maneja'].'\';cher.action=\'verificador-gui-asignado.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
};
$db=null;
exit;
?>
