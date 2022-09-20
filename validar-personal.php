<?php
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
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js">
         </SCRIPT>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js">
         </SCRIPT>
 <HTML>
<?php
        $stper = $db->query("SELECT * FROM Profesional WHERE idProfesional ='".$_POST['prof']."'");
	//$stpro = $db->query("SELECT * FROM Profesional WHERE idProfesional ='0602908170'");	
	if ($stper->rowCount()>0){
	   $stp= $stper->fetch(PDO::FETCH_ASSOC);
?>
		<center><strong><font size='+1'><A href='JavaScript:'>CONSULTA INFODIGITAL</a></font> </strong></center>
		<center><strong><font size='+1'>DATOS DE IDENTIFICACI&Oacute;N PERSONAL</font> </strong></center>
		<table border='0' width ='80%' align='center' cellpadding='5' cellspacing='5' class='seccion'>
		       <tr  bgcolor='#ffffff'>
		       	    <td><b>DOCUMENTO IDENTIFICACION:</b><br><?php echo $stp['idProfesional']?> 
			    </td>
			    <td><b></font>NOMBRES:</b><br><?php echo $stp['ProfesionalNombres']?>
			    </td>
			    <td><b></font>APELLIDOS:</b><br><?php echo $stp['ProfesionalApellidos']?>
			    </td>
		       </tr>
		       <tr bgcolor='#ffffff'>
			    <td><b>G&eacute;nero: <br>
			    </td>
			    <td><b>FECHA NACIMIENTO (aaaa/mm/dd):</b><br><?php echo $stp['ProfesionalFecNacim']?>
			    </td>
			    <td><b>PAIS NACIMIENTO:</b><br>
			    	<?php echo format_cont_db('idNacionalidad',$stp['Nacionalidad_idNacionalidad'])?>
			    </td>
			</tr>
			<tr bgcolor='#ffffff'>
			    <td><b>PAIS RESIDENCIA:</b><br> 
			    	<?php echo format_cont_db('idPaisr',$stp['Ciudadr_Paisr_idPaisr'])?>
				</td>
				<td><b>CIUDAD RESIDENCIA:</b><br>
					<?php echo format_cont_db('idCiudadr',$stp['Ciudadr_idCiudadr'])?>
				</td>
                            <td><b>DIRECCI&Oacute;N:</b><br><?php echo $stp['ProfesionalDireccion']?>
                            </td>
                        </tr>
                        <tr bgcolor='#ffffff'>
                           <td><b>TELEFONO MOVIL:</b><br><?php echo $stp['ProfesionalTlfmovil']?>
                            </td>
                            <td><b>TELEFONO FIJO:</b><br><?php echo $stp['ProfesionalTlfFijo']?>
                            </td>
                            <td><b>CORREOS ELETRONICOS:</b><br><?php echo $stp['ProfesionalMail']?><br><?php echo $stp['ProfesionalMail2']?>
                            </td>
                        </tr>
		</table>
<?php
	};

//echo $sql.'<br>'.$sql_us.'<br>';
exit;


$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
