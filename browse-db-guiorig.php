<?php
#	require_once ('session.php');
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
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
 	 <SCRIPT LANGUAGE="JavaScript1.2">
 	 	var url;
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	 </SCRIPT>
 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type='hidden' name='basecod' >
        </form>
<b><table border='0' width='90%' align='center' background='image/web2014.png' style='background-repeat:no-repeat;'>
	  	     <tr valign='top' class='menu_'>
                        <td ><br>
                        </td>
                </tr>
        </table> </b><HR>
<table align="center" width="100%" border='0' style="border-style:none;" cellspacing='2' bordercolor='#0000ff'>
	  	     <tr >
                        <td colspan='4' align='center'><font size='+1'><div class='literatura'> SERVICIO DE REGISTRO DE PROFESIONALES INPC </div> </font>
                        <!--<div class='literatura2'><br> Usuario P&uacute;blico &nbsp;<br></div>-->
                        </td>
                </tr>
                  <tr>
                        <td class='menubar' width='10%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>" onClick=""><font size='+1'>INICIO</font></a>
                        </td>
                        <td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="return _submit('cher','post1.php');"><a href="JavaScript:" ><font size='+1'>Solicitar Certificaci&oacute;n de Registro</font></a>
                        </td>
                        <td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
                        <h1>BASE DE DATOS DE DATOS PROFESIONALES REGISTRADOS </h1>
                        <table border='0' cellspacing='4' cellpadding='3' class='menubar'>
                        	<tr bgcolor='#ffffff'>
                        		<td>&nbsp;<b><a href="Javascript:" onClick="cher.target='_self';cher.action='browse-db-gui.php';cher.submit();">[Refresca listado]</a></b></td>
                        	</tr>
                        </table><br>
    			 		</td>
                    	<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="cher.submit();return _submit('cher','log-im.php');"><font size='+1'>Ingresar al Servicio</font></a>
                        </td>
                </tr>
                </table><br>
                <hr>

<?php
	$sql_us_maneja = $db->query("SELECT TipoProfesionalId FROM TipoProfesional" );
	while($us_maneja = $sql_us_maneja->fetch(PDO::FETCH_ASSOC)) {
		$stfac = $db->query("SELECT * FROM RegistroP WHERE RegistroPProfesionalID=".$us_maneja['TipoProfesionalId']." AND RegistroPActivo = 1 ORDER BY RegistroPApellidos ASC");
?>
	<br><br><br><TABLE border='0' width='100%'><tr><td>
                <table border='0' class='cajita'><tr><td><strong>BASE DE DATOS: <?php echo format_cont_db('TipoProfesionalId',$us_maneja['TipoProfesionalId']) ?> </strong> </td> </tr></table>
                <br><center><strong><font size='+1'>PROFESIONALES REGISTRADOS</font> </strong></center>
                <table border='0' width ='90%' align='center' cellpadding='5' cellspacing='2' class='seccion2'>
					<tr bgcolor='#ffffff' >
						<th nowrap>C&oacute;digo de Registro:</th>
						<th nowrap>Doc Identificaci&oacute;n:</th>
						<th nowrap>Apellidos:</th>
						<th nowrap>Nombres:</th>
						<!--<th nowrap>G&eacute;nero:</th>-->
						<!--<th nowrap>Direcci&oacute;n:</th>-->
						<th nowrap>Ciudad Res.:</th>
						<th nowrap>Pa&iacute;s Res.:</th>
						<th nowrap>Tlf. Fijo:</th>
						<th nowrap>Tlf. Movil:</th>
						<th nowrap>Email:</th>
						<th nowrap>Email alt.:</th>
						<th nowrap>Fecha Habilitaci&oacute;n:</th>
					</tr>
<?php
			while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
?>
					<tr bgcolor='#ffffff'>
						<td><?php echo $row['RegistroPCodigo']?></td>
						<td><?php echo $row['Profesional_idProfesional']?></td>
						<td><?php echo $row['RegistroPApellidos']?></td>
						<td><?php echo $row['RegistroPNombres']?></td>
						<!--<td><?php echo $row['RegistroPGenero']?></td>-->
						<!--<td><?php echo $row['RegistroPDireccion']?></td>-->
						<td><?php echo $row['RegistroPCiudadr']?></td>
						<td><?php echo $row['RegistroPPaisr']?></td>
						<td><?php echo $row['RegistroPTlfFijo']?></td>
						<td><?php echo $row['RegistroPTlfMovil']?></td>
						<td><?php echo $row['RegistroPMail']?></td>
						<td><?php echo $row['RegistroPMail2']?></td>
						<td><?php echo $row['RegistroPFechaRegistro']?></td>
						<td  align='center' bgcolor='#dce5ef' nowrap>
						&nbsp;<a href="JavaScript:" onClick="url_=url_base+'<?php echo $row['Profesional_idProfesional']?>';abrir(url_,'sene',ancho/1.5,alto/1.5,0);return false;">[R Senescyt]</a>&nbsp;
						</td>
					</tr>

<?php
			};

?>
	</table>
<?php
?>
		<br><br></td></tr></table><br>

<?php
	};

$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
