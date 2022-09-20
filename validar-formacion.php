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
	 <SCRIPT LANGUAGE="JavaScript1.2" >
	 	var url_base="http://www.senescyt.gob.ec/web/guest/certificacion-de-titulos?inicial=1&buscarPorCedula=";
	 </SCRIPT>
 <HTML>
 <body>
<?php
        $stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='".$_POST['prof']."'");
        //$stfac = $db->query("SELECT * FROM FAcademica WHERE Profesional_idProfesional ='0602908170'");
?>
					<br><br>
                <center><strong><font size='+1'>FORMACI&Oacute;N ACAD&Eacute;MICA</font> </strong>
                </center>
                <table border='0' width ='80%' align='center' cellpadding='5' cellspacing='5' class='seccion'>
<?php
        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
?>
                        <tr bgcolor='#ffffff'>
                           <td><b>NIVEL T&Iacute;TULO:</b><br><?php echo format_cont_db('FAcademicaNivel',$row['FAcademicaNivel'])?>
                            </td>
                            <td><b>NOMBRE T&Iacute;TULO:</b><br><?php echo $row['FAcademicaNTitulo']?>
                            </td>
                            <td><b>INSTITUCI&Oacute;N:</b><br><?php echo $row['FAcademicaInstitucion']?>
                            </td>
                             <td><b>FECHA GRADUACI&Oacute;N:</b><br><?php echo $row['FAcademicaFecGrado']?>
                            </td>
                            <td><b>CODIGO REGISTRO SENESCYT:</b><br><?php echo $row['FAcademicaCSenescyt']?>
                            </td>
           </tr>

<?php
	};

?>
	</table><br><br>
		<center> <strong> INFORMACION ACADEMICA SENECYT</strong> </center>

<iframe height='300' width='100%' src="http://www.senescyt.gob.ec/web/guest/index.php/consultas/<?php echo $_POST['prof']?>">
  <p>Your browser does not support iframes.</p>
</iframe>

<?php

//echo $sql.'<br>'.$sql_us.'<br>';
exit;


$db=null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
</body>
</html>
