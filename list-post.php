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
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	</SCRIPT>

 <HTML>
<BODY>
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='20' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type='hidden' name='basecod' >
         <input type='hidden' name='act_dea' >
		<input type='hidden' name='us_maneja' value="<?php echo $_POST['us_maneja']?>">
        <input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">
        </form>
<?php														//TRATAMIENTO DE LOS PROFESIONALES REGISTRADOS HABILITACION DESHABILITACION
	//Limito la busqueda
	$TAMANO_PAGINA = 10;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_POST["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	};
	$stotp_ = $db->query("SELECT count(t1.idProfesional) as tot FROM Profesional as t1, Profesiones as t2, Postulacion as t3 WHERE  t1.idProfesional=t2.Profesional_idProfesional and (t3.PostulacionEstado=0 and t3.Profesiones_idProfesiones=t2.idProfesiones) and t2.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja']);
	$stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
	$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

	$get_prof_reg = $db->query("SELECT t1.idProfesional,t1.ProfesionalNombres, t1.ProfesionalApellidos, t1.ProfesionalMail,t1.ProfesionalMail2, t2.TipoProfesional_TipoProfesionalId, t1.Nacionalidad_idNacionalidad, t3.PostulacionFechaI FROM Profesional as t1, Profesiones as t2, Postulacion as t3 WHERE  t1.idProfesional=t2.Profesional_idProfesional and (t3.PostulacionEstado=0 and t3.Profesiones_idProfesiones=t2.idProfesiones) and t2.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja']." ORDER BY t3.PostulacionFechaI ASC  LIMIT ".$inicio."," . $TAMANO_PAGINA);
?>
	<center><img height='30' src='image/proces1-5.png'></center><br>
<center><strong>SOLICITUDES EN PROCESO: <?php echo $stotp['tot'] ?> <?php echo format_cont_db('TipoProfesionalId',$_POST['us_maneja'])?></strong></center>
	<table border='1' width ='100%' align='center' cellpadding='5' cellspacing='1' class='seccion2'>
		<tr bgcolor='#ffffff'>
			<tH><B>Documento Identificaci&oacute;n:</b></th>
			<tH><B>Apellidos y Nombres:</b></th>
			<th><b>Correo(s) Electr&oacute;nico(s):</b></th>
			<th><b>Nacionalidad:</b></th>
			<th><b>Fecha y Hora de Ingreso de Solicitud:</b></th>
<!--			<th><b>Tlf. Fijo:</b></th>
			<th><b>Tlf. Movil:</b></th>
			<th><b>Email:</b></th>
			<th><b>Email alt.:</b></th>
			<th><b>Fecha Habilitaci&oacute;n:</b></th>
			<td bgcolor='#fed9a3' align='center'><b>Acciones / Enlaces</b></td>-->
		</tr>
<?php
	while($row = $get_prof_reg->fetch(PDO::FETCH_ASSOC)) {
?>
		<tr bgcolor='#ffffff' align='center'>
			<td><?php echo $row['idProfesional']?></td>
			<td><?php echo $row['ProfesionalApellidos'].' '.$row['ProfesionalNombres']?></td>
			<td><?php echo $row['ProfesionalMail']; if ($row['ProfesionalMail2']!=''){echo ' '.$row['ProfesionalMail2'];};?></td>
			<td><?php echo format_cont_db('idNacionalidad', $row['Nacionalidad_idNacionalidad'])?></td>
			<td><?php echo str_replace(' ','<br>',$row['PostulacionFechaI'])?></td>
<?php /* ?>			<td><?php echo $row['RegistroPTlfFijo']?></td>
			<td><?php echo $row['RegistroPTlfMovil']?></td>
			<td><?php echo $row['RegistroPMail']?></td>
			<td><?php echo $row['RegistroPMail2']?></td>
			<td><?php echo $row['RegistroPFechaRegistro']?></td>
			<td  align='center' bgcolor='#dce5ef' nowrap>
			</td><?php */?>
		</tr>

<?php
	};
?>
</table>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a class="info" href="" onClick="cher.target=\'idbp'.$_POST['us_maneja'].'\';cher.action=\'list-post.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a class="info" href="" onClick="cher.target=\'idbp'.$_POST['us_maneja'].'\';cher.action=\'list-post.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a class="info" href="" onClick="cher.target=\'idbp'.$_POST['us_maneja'].'\';cher.action=\'list-post.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
}
$db=null;
exit;
?>
