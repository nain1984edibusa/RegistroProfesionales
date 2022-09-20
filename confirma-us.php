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

	 <SCRIPT LANGUAGE="JavaScript1.2" >
	 var seed;
	function valid(){
		if ((post1._us_.value=="")||(post1._pw_.value=="")){
			alert("Falta el LOGIN o el PASSWORD, por favor !!VERIFIQUE!!")
		     	return false;
		}else{
			if ((post1._pwn_.value=='' || post1._pwnn_.value=='')|| (post1._pwn_.value!=post1._pwnn_.value) ){
			   alert('La confirmacion no coincide, o uno de los dos campos esta vacio\nVerificque por favor');
			   return false;
			};
                        post1.xx.value = Aes.Ctr.encrypt(post1._us_.value, String(seed), 256);
			post1.yy.value = Aes.Ctr.encrypt(post1._pw_.value, String(seed), 256);
			post1.tt.value = Aes.Ctr.encrypt(post1.token.value, String(seed), 256);
			post1.aa.value = Aes.Ctr.encrypt(post1._pwn_.value, String(seed), 256);
			post1.bb.value = Aes.Ctr.encrypt(post1._pwnn_.value, String(seed), 256);
                        post1.x.value = seed;
			post1._us_.value='';
			post1._pw_.value='';
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
<b><table border='0' width='100%' align='center' style="background-attachment: fixed;background-repeat:no-repeat;"" background='image/web2014.png'>
		<tr valign='top' class='menu_'>
			<td align='center'><!--<font size='+2'><div class='cajita'> SERVICIO DE REGISTRO  DE PROFESIONALES INPC </div> </font>-->
			</td>
		</tr>
	</table>
 </b><HR>

<table align="center" width="100%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
        	<tr>
			<td class='menubar'align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>"><font size='+1'>INICIO</font></a>
			</td>
			<!--<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="return false;"><font size='+1'>Postular Registro Primera Vez</font></a>
			</td>-->
			<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="return false;"><font size='+1'>Explorar Base de Datos</font></a>
			</td>
			<td class='menubar'align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="return false;"><font size='+1'>Ingresar</font></a>
			</td>
		</tr></table>
		<hr>
	<form name="post1" action="" method="post" onSubmit="" >
				<input type="hidden" name="x">
				<input type="hidden" name="xx">
				<input type='hidden' name='yy'>
				<input type='hidden' name='tt'>
				<input type='hidden' name='aa'>
				<input type='hidden' name='bb'>
				<input type='hidden' name='token' value='<?php echo $_GET['token']?>'>

		<table  class='seccion' border='0' cellspacing='5' align='center' width='40%'>
			<tr>
				<th colspan='4'>
				   <h1> INGRESO AL SERVICIO (CREDENCIALES TEMPORALES)</h1>
				</th>
			</tr>
			<tr>
							<td COLSPAN='2'><h1>USUARIO:</h1></td>
							<td colspan='2'><input type="text" name="_us_"></td>
						</tr>
						<tr nowrap>
							<td colspan='2'><h1>CONTRASE&Ntilde;A TEMPORAL:</h1></td>
							<td colspan='2'><input type="password" name="_pw_"></td>
			</tr>
						<tr  bgcolor='#ffffff'>
							<td nowrap><h1>NUEVA CONTRASE&Ntilde;A:</h1></td>
							<td nowrap><input type="password" name="_pwn_"></td>
							<td nowrap><h1>NUEVA CONTRASE&Ntilde;A (confirmaci&oacute;n):</h1></td>
							<td nowwrap><input type="password" name="_pwnn_"></td>
			</tr>
			<tr>
				<td  align='center' colspan='4'>
					<input type="button" name="send" value="INGRESAR" onFocus="" onBlur="" onClick="if(valid()){document.post1.action='check_l.php';document.post1.submit();}">
				</td>
			</tr>
		</table>
	</form><br><br><br>
		<table class='literatura2' align='center' width='60%' border='0'>
		       <tr><td >
		       	   <font size='+1'><b>Estimado:</b> mientras no complete este proceso, su solicitud de ingreso a la base de datos no ingresar&aacute; al proceso de registro</font>
		</td></tr>
		</table>
</BODY>
</HTML>
