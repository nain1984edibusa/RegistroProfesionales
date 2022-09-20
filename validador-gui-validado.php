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
	$file_prefix='cert-post-';
	function exist_doc($id){
		$doc_dir=$_SERVER['DOCUMENT_ROOT'].'/storage/';
		if(file_exists($doc_dir.$id)){return TRUE;}else{return FALSE;}	
	}
	
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
<BODY>
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>	<form name="cher" action=" " method="post" >	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type="hidden" name="ver_dseguro" value='0'>
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
	
#        $stotp_ = $db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesional as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=1)  and (t2.Profesional_idProfesional=t3.idProfesional and t3.TipoProfesional_TipoProfesionalId='".$_POST['us_maneja']."')");
		$stotp_=$db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=1 and AccionEnPostulacionActiva=1) and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja'].")");

        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

	$stfac = $db->query("SELECT t2.PostulacionFechaI, t1.Postulacion_idPostulacion,t2.*, t1.AccionEnPostulacionFechaAs,t2.PostulacionFechaV, timediff(t2.PostulacionFechaV, t1.AccionEnPostulacionFechaAs) as dif1 FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=1 and AccionEnPostulacionActiva=1) and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja'].")");
?>
	<center><img height='30'  src='image/proces2-5.png'></center><br>
		<center><strong>Solicitudes Revisadas: <?php echo $stotp['tot']?></strong></center>
	<table border='1' width ='96%' align='center' cellpadding='5' cellspacing='1' class='seccion2'>
		<tr bgcolor='#ffffff'>
			<tH><B>Solicitante:</b></th>
			<th><b>Fecha y Hora Asignaci&oacute;n:</b></th>
<!--			<th><b>Base de Datos:</b></th>-->
<!--			<th><b>Validaci&oacute;n de Datos:</b></th>-->
			<th><b> Informe T&eacute;cnico:</b></th>
			<th><b>Respuesta a Solicitud :</b></th>
			<th><b>Fecha y Hora despacho:</b></th>
			<th><b>Duraci&oacute;n del Tr&aacute;mite:</b></th>
		</tr>
<?php 
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$post_data = $db->query("SELECT Profesional_idProfesional FROM Profesiones WHERE idProfesiones='".$row['Profesiones_idProfesiones']."'");
		$postd=$post_data->fetch(PDO::FETCH_ASSOC);
		$starea = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones='".$row['Profesiones_idProfesiones']."'");
		$area=$starea->fetch(PDO::FETCH_ASSOC);
		if (TRUE or $area['TipoProfesional_TipoProfesionalId']==$_POST['us_maneja']){
			$stinforme = $db->query("SELECT InformeTecnicoRefDoc,InformeTecnicoObservacion,InformeTecnicoRecomendacion, InformeTecnicoCodPro FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['Postulacion_idPostulacion']);
			$informe=$stinforme->fetch(PDO::FETCH_ASSOC);
			$st_inf_sr = $db->query("SELECT * FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$row['idPostulacion']."");
			if ($st_inf_sr->rowCount()){
				$inf_sr= $st_inf_sr->fetch(PDO::FETCH_ASSOC);
			};

?>	
		<tr bgcolor='#ffffff' align='center'>
			<td nowrap>
				<a class='info'  style="font-size:11px;"  href="Javascript:" onClick="abrir('','verd',(ancho*0.9),alto*0.4,0);cher.idpost.value='<?php echo $row['idPostulacion'] ?>';cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.ver_dseguro.value='0';cher.target='verd';cher.action='validar-datos.php';cher.submit();return false;">
					<b><?php echo format_cont_db('idProfesional',$postd['Profesional_idProfesional'])?></b>
				</a><br><br><?php echo str_replace(' ','<br>',$row['PostulacionFechaI'])?>
			</td>
			<td width='11%'><br><?php echo $row['AccionEnPostulacionFechaAs']?></td>
<!--			<td width='14%'><?php echo format_cont_db('TipoProfesionalId',$area	['TipoProfesional_TipoProfesionalId'])?></td>-->
<?php /* ?>			<td width='14%'> 
				<a class='info' href="Javascript:" onClick="abrir('','val_per',(ancho/(1.5)),alto/2,0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_per';cher.action='validar-personal.php';cher.submit();return false;">[Datos Personales]</a><br>
				<a class='info' href="Javascript:" onClick="abrir('','val_acad',(ancho/(1.2)),(alto/(1.2)),0);cher.prof.value='<?php echo $postd['Profesional_idProfesional']?>';cher.target='val_acad';cher.action='validar-formacion.php';cher.submit();return false;">[Formacion Academica]</a>
			</td><?php */ ?>
			<td width='14%' >
				Memo No: <br>
				<b><?php echo $informe['InformeTecnicoRefDoc']?></b><br> <br>
				Observaciones:<br>
				<b><?php echo $informe['InformeTecnicoObservacion']?>
			</td>
			<td  width='17%' align='center' >
<?php
			$file=$file_prefix.$row['Postulacion_idPostulacion'].'.pdf';
			if (exist_doc($file)){
?>
				<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/storage/<?php echo $file?>" target='new'><img src='image/icon_pdf.gif' height='18' alt="Ver Documento" Title="Ver Documento"></a>
<?php
			};
?>
				<?php echo strtoupper($informe['InformeTecnicoRecomendacion'])?> 
<?php
				if($informe['InformeTecnicoRecomendacion']=='aprobada'){
					echo "<br> C&oacute;digo Registro Propuesto: <b>".$informe['InformeTecnicoCodPro']."</b>";
				};
				if($informe['InformeTecnicoRecomendacion']=='rechazada'){
					echo "<br><br>Oficio Respuesta: <b>".$inf_sr['SolicitudRespuestaRefDoc']."</b>";
					echo "<br><br>Observaciones: <b>".$inf_sr['SolicitudRespuestaResumen']."</b>";
				};
?>
			</td>
			<td width='16%'><?php echo str_replace(' ','<br>',$row['PostulacionFechaV'])?></td>
			<td align='center'><?php echo $row['dif1']?></td>
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
      echo '<a class="info" style="font-size:11px;" href="" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-validado.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a class="info"  style="font-size:11px;" href="" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-validado.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a class="info"  style="font-size:11px;" href="" onClick="cher.target=\'idbv'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-validado.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
}

$db=null;
exit;
?>
