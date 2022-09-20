<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');

	if($_SERVER['REQUEST_METHOD']!='POST' and !isset($_POST['id_'])){
	  //header("Location: http://regprof.inpc.gob.ec/");
	  header ("Location: http://".$_SERVER['SERVER_NAME']);
	};
	$dbcon = mysqli_connect($db_host,$db_user,$db_pass,$db_name);  // mysql_connect() with variables defined at the start of Database class 
	//mysqli_select_db($dbcon,$db_name)or die(mysqli_error());

?>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js">
	 </SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js">
	 </SCRIPT>
<HTML>
<BODY language=JavaScript onLoad="cr.ciudadr.focus()">
<a name='begin'></a>	
<b><table border='0' width='90%' align='center' ><tr valign='bottom'><!--<td width='30%'><img height='50' border="0" src="image/LogoINPC2014-last.jpg"</td>--><td align='center'><font size='+2'>ESCOJA CIUDAD DE RESIDENCIA</font></td></tr></table> </b><HR>

	<form name="cr" action="" method="post" >
				<input type="hidden" name="resol">
				<input type="hidden" name="subsys">
			<tr><td colspan='3'><br><br> </td></tr>
		<table border='0' cellspacing='2' align='center' width='100%'>
			<tr>
				<td>
					<table border='0' align='center'>
						<tr>
							<td align='center'>
							<b>CIUDAD DE RESIDENCIA:</b> <br>
		<SELECT NAME="ciudadr" size="1"  <?php echo put_bgcolor()?> onChange="/*window.parent.opener.post1.ciudadr.value=this.options[this.selectedIndex].text;window.parent.opener.post1.ciu_co.value='<?php echo $_POST['id_']?>';window.parent.opener.post1.id_ciu.value=this.options[this.selectedIndex].value;window.close()*/">
<?php
		$i=0;
		$content=$_POST['id_'];
        	$sql="SELECT idCiudadr,CiudadrNombre FROM Ciudadr WHERE Paisr_idPaisr='".$_POST['id_']."' ORDER BY CiudadrNombre"; 
        	 $res=mysqli_query($dbcon,$sql) or die(mysqli_error());
        	if (mysqli_num_rows($res)>0){
	        	while ($row = mysqli_fetch_array ($res)){
		       		if ($content==""){
							if ($i==0){
								$sel="selected";
								$i++;
							};
?>
						<OPTION <?php echo $sel?> value="<?php echo $row['idCiudadr']?>"><?php echo ucwords($row['CiudadrNombre'])?></OPTION>
<?php
						$sel="";
                   }else{
							$sel="";
							if ($_POST['ciu_co']==$row['idCiudadr']){$sel="selected";};
?>
                        <OPTION <?php echo $sel?> value="<?php echo $row['idCiudadr']?>"><?php echo ucwords($row['CiudadrNombre'])?></OPTION>
<?php
                    };
                };
        	};
?>
        	</SELECT>

							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan='3' align='center'>
					<input type="button" name="send" value="ACEPTAR" class='buton' onClick="window.parent.opener.post1.ciudadr.value=cr.ciudadr.options[cr.ciudadr.selectedIndex].text;window.parent.opener.post1.ciu_co.value='<?php echo $_POST['id_']?>';window.parent.opener.post1.id_ciu.value=cr.ciudadr.options[cr.ciudadr.selectedIndex].value;window.close()">
				</td>
			</tr>
		</table>
	</form>
</BODY>
</HTML>
