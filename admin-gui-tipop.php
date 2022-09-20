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
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="tpr_">
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
        $stotp_ = $db->query("select count(TipoProfesionalId) as tot from TipoProfesional");
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);
			
        $stfac = $db->query("SELECT * FROM TipoProfesional  LIMIT ".$inicio."," . $TAMANO_PAGINA);

?>
	<table border='0' width ='98%' align='center' cellpadding='5' cellspacing='2' class='seccion'>
		<tr bgcolor='#ffffff'>
			<tH><B>Categor&iacute;a:</b></th>
			<th><b>Perfil:</b></th>
			<th><b>Prefijo C&oacute;digo(s):</b></th>
			<th><b>Contador(es) C&oacute;digo:</b></th>
			<th><b>Acciones:</b></th>
		</tr>
<?php

	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$get_codes_=$db->query("SELECT CodProfesionalPrefijo, CodProfesionalInicio FROM CodProfesional WHERE TipoProfesional_TipoProfesionalId=".$row['TipoProfesionalId']);
		$get_codes_->setFetchMode(PDO::FETCH_ASSOC);
		$get_codes=$get_codes_->fetchAll();

?>
		<tr bgcolor='#ffffff'>
			<td><?php echo $row['TipoProfesionalNombre']?></td>
			<td><?php echo $row['TipoProfesionalPerfil']?></td>
			<td>
<?php
		$i=0;
		foreach($get_codes as $code){
			if ($i >0){echo '<br>';};
			echo $code['CodProfesionalPrefijo'];
			$i++;
		};
?>
			</td>
			<td>
<?php
		$i=0;
		foreach($get_codes as $code){
			if ($i >0){echo '<br>';};
			 echo $code['CodProfesionalInicio'];
			$i++;
			};
?>
			</td>
			<td  align='center'>&nbsp;<a class='info' style="font-size:11px;" href="JavaScript:" onClick="abrir('','edi_tipo',ancho,alto/2,0);cher.tpr_.value='<?php echo $row['TipoProfesionalId']?>';cher.target='edi_tipo';cher.action='edita-tprofesional.php';cher.submit();return false;">Actualizar</a>&nbsp;</td>
		</tr>

<?php
	};
?>
	</table><br>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href="" class="info" onClick="cher.target=\'itipop\';cher.action=\'admin-gui-tipop.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href="" class="info" onClick="cher.target=\'itipop\';cher.action=\'admin-gui-tipo.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href="" class="info" onClick="cher.target=\'itipop\';cher.action=\'admin-gui-tipop.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
}
$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
