<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
?>
	<script src="java/aes.js">/* AES JavaScript implementation */</script>
	<script src="java/aes-ctr.js">/* AES Counter Mode implementation */</script>
	<script src="java/base64.js">/* Base64 encoding */</script>
	<script src="java/utf8.js">/* UTF-8 encoding */</script>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"> </SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"> </SCRIPT>

	 <SCRIPT LANGUAGE="JavaScript1.2"  charset="ISO-8859-1">
	 var seed;
	function valid(){
		if ((post1._us_.value=="")){
			alert("Falta el USUARIO");
			document.post1._us_.focus();
		     	return false;
		}else{
			if ((post1._pwn_.value=='' || post1._pwnn_.value=='')|| (post1._pwn_.value!=post1._pwnn_.value) ){
			   alert('La <?php echo utf8_decode('confirmación')?> no coincide, o uno de los dos campos esta <?php echo utf8_decode('vacío')?>');
			   return false;
			};
			if (post1._pwn_.value.length < 8 || post1._pwnn_.value.length < 8 ){
			   alert('La <?php echo utf8_decode('contraseña')?> debe tener al menos 8 caracteres');
			   return false;
			};
			post1.xx.value = Aes.Ctr.encrypt(post1._us_.value, String(seed), 256);
			post1.tt.value = Aes.Ctr.encrypt(post1.token.value, String(seed), 256);
			post1.aa.value = Aes.Ctr.encrypt(post1._pwn_.value, String(seed), 256);
			post1.bb.value = Aes.Ctr.encrypt(post1._pwnn_.value, String(seed), 256);
			post1.x.value = seed;
			post1._us_.value='';
			post1._pwn_.value='';
			post1._pwnn_.value='';
			post1.token.value='';
			return true;
		}
	}
	 </SCRIPT>
<HTML>
<BODY onLoad="seed=Math.random();">
<a name='begin'></a>	
<?php include("theader.php")?>

<table align="center" width="100%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
  <tr>
      <td align="center" align='center' class='literatura' colspan='4'><B> <font size='+1'>REGISTRO DE PROFESIONALES - RESTABLECIMIENTO DE CONTRASE&Ntilde;A Y ACTUALIZACI&Oacute;N DE DATOS</font></B>
			</td>
  </tr>
</table>
		<hr>
	<form name="post1" action="" method="post" onSubmit="" >
				<input type="hidden" name="x">
				<input type="hidden" name="xx">
				<input type='hidden' name='yy'>
				<input type='hidden' name='tt'>
				<input type='hidden' name='aa'>
				<input type='hidden' name='bb'>
				<input type='hidden' name='token' value='<?php echo $_GET['token']?>'>
                <table cellpadding='4' border='0' align='center'><tr><td class='literatura' >
              Su usuario es el n&uacute;mero de documento de identificaci&oacute;n (c&eacute;dula o pasaporte)
                 </td></tr></table>
 
		<table  class='seccion' border='0' bgcolor='#ffffff' cellspacing='3' align='center' width='40%'>
			<tr valign='middle'>
				<th colspan='4' >
				   <h1> <img src='image/logini.png' > CAMBIAR CONTRASE&Ntilde;A</h1>					
				</th>
			</tr>
			<tr>
			<tr >
							<td ><h1>USUARIO:</h1></td>
							<td ><input type="text" name="_us_" title='Diferencia entre mayusculas - minusculas'></td>
						</tr>
						<tr>
			</tr>
						<tr  bgcolor='#ffffff' align='center'>
							<td nowrap><h1>NUEVA CONTRASE&Ntilde;A:</h1><input type="password" name="_pwn_" title='Mezcle Maysuculas, minusculas, numeros. Al menos 8 caracteres'></td>
							<td nowrap><h1>NUEVA CONTRASE&Ntilde;A (confirmaci&oacute;n):</h1><input type="password" name="_pwnn_"title='Mezcle Maysuculas, minusculas, numeros. Al menos 8 caracteres'></td>
			</tr>
			<tr>
				<td  align='center' colspan='4'>
					<input type="button" class='buton' name="send" value="ACEPTAR" onFocus="" onBlur="" onClick="if(valid()){document.post1.action='comp-migr2.php';document.post1.submit();}">
				</td>
			</tr>
		</table>
	</form><br><br><br>
		<!--<table class='literatura2' align='center' width='60%' border='0'>
		       <tr><td >
		       	   <font size='+1'><b>Estimado(a):</b> mientras no complete este proceso, su solicitud de ingreso a la base de datos no ingresar&aacute; al proceso de registro</font>
		</td></tr>
		</table><br>-->
		<table class='literatura' align='center' width='60%' border='0'>
		       <tr><td >
		       	   Para mayor seguridad en la contrase&ntilde;a &eacute;sta debe tener al menos 8 caracteres; use may&uacute;sculas, min&uacute;sculas y n&uacute;meros
		</td></tr>
		</table>

</BODY>
</HTML>
