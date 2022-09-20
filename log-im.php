<?php  
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	//require('class/mysql_crud.php');
	require('class/mysql_table.php');
	require('css/css-func.inc.php');

	if($_SERVER['REQUEST_METHOD']=='POST'){
		$keyes=array_keys($_POST);
		$values=array_values($_POST);
	}else{
#		header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
#		exit;
	};
?>
	<script src="java/aes.js">/* AES JavaScript implementation */</script>
	<script src="java/aes-ctr.js">/* AES Counter Mode implementation */</script>
	<script src="java/base64.js">/* Base64 encoding */</script>
	<script src="java/utf8.js">/* UTF-8 encoding */</script>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>

	 <SCRIPT LANGUAGE="JavaScript1.2"  charset="ISO-8859-1" >
	 var seed;
	function validl(){
		if ((flost.us_.value=="nombre usuario")||(flost.mail.value=="email"||check_mail('email',flost.mail.value,0))){
			alert("Falta nombre de usuario o email, por favor VERIFIQUE los datos")
		     	return false;
		}else{
			return true;
		}
	}
	function valid(){
		if ((post1._us_.value=="")||(post1._pw_.value=="")){
			alert("Falta el USUARIO o la <?php echo utf8_decode('CONTRASEÑA')?>")
		     	return false;
		}else{
			post1.xx.value = Aes.Ctr.encrypt(post1._us_.value, String(seed), 256);
			post1.yy.value = Aes.Ctr.encrypt(post1._pw_.value, String(seed), 256);
			post1.x.value = seed;
			post1._us_.value='';
			post1._pw_.value='';
			return true;
		}
	}
	 </SCRIPT>
<HTML>
<BODY onLoad="seed=Math.random();post1._us_.focus()">
<a name='begin'></a>	
<form name="cher" action=" " method="post" >
				<input type="hidden" name="tus">
				<input type="hidden" name="subsys">
				<input type="hidden" name="lpw" value='0'>				
				</form>
<?php include("theader.php")?>

<table align="center" width="95%" border='0' style="border-style:solid; border: 1px solid lightgray;" cellspacing='0' bordercolor='#0000ff'>
  <tr valign='middle'>
      <td align="center" align='center' class='literatura' colspan='4'><B><!--<img height='100%' src='image/login.png'>--> <font size='+1'> REGISTRO DE PROFESIONALES - INGRESO USUARIO REGISTRADO</font></B>
			</td>
  </tr>
        	<tr>
			<td class='menubar'align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"  onClick="cher.action='index.php';cher.submit()"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>"><!--<img src='image/home.png'>-->INICIO</a>
			</td>
			<!--<td class='menubar'  align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="return _submit('cher','post1.php');"><a href="Javascript:" onClick="return _submit('cher','post1.php');"><img src='image/regcard.png'>Solicitar Registro en la Base de Datos</a>-->
			</td>
			<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="return _submit('cher','browse-db-gui.php');return false;"><a href="Javascript:" onClick="return _submit('cher','browse-db-gui.php');"><!--<img  src='image/browse.png'>-->Base de Datos Profesionales </a>
			</td>
<!--			<td class='menubar'align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" onClick="return false;"><font size='+1'>Ingresar</font></a>
			</td>-->
		</tr></table>
		<hr>
	</table>
	<form name="post1" action="" method="post" onSubmit="" >
				<input type="hidden" name="x">
				<input type='hidden' name='tus' value='<?php  if(isset($_POST['tus'])){ echo $_POST['tus'];};?>'>
				<input type="hidden" name="xx">
				<input type='hidden' name='yy'>
	<div id='tipl' style='DISPLAY:;'>
		<table cellpadding='4' border='0' align='center'><tr><td class='literatura' >
						Su usuario es el n&uacute;mero de documento de identificaci&oacute;n (c&eacute;dula o pasaporte). 
					<!--<li><b>Funcionario :</b> Su usuario es el que le fu&eacute; proporcionado por el Administrador del Servicio </li>-->
		</td></tr></table>
	</div><br>
		<table  class='seccionl' border='0' cellspacing='5' align='center' width='40%'>
			<tr>
				<th colspan='3'>
<?php
	if(isset($_POST['tus']) and $_POST['tus']==3){
		$lab=': PROFESIONAL SOLICITANTE';
	}else{
		$lab='';
	};
?>
				   <h1> INICIAR SESI&Oacute;N <?php echo $lab?></h1>
				</th>
			</tr>
			<tr >
				<td rowspan='2'>
					<!--<img height='50%' src='image/login.png'>-->
				</td>
							<td><h1><font >USUARIO:</font></h1></td>
							<td><input type="text" name="_us_" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"></td>
						</tr>
						<tr>
							<td><h1><font >CONTRASE&Ntilde;A:</font> </h1></td>
							<td><input type="password" name="_pw_" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"></td>
			</tr>
			<tr>
				<td  align='center' colspan='2' class='elipse' onClick="if(valid()){document.post1.action='check_l.php';document.post1.submit();};return false;">
					<a  href="JavaScript:" >INGRESAR</a>
				</td>
				<td  align='center' class='elipseb' style="background-color:white;"  onClick="if(cher.lpw.value==0){expandit2('lostmp',1);cher.lpw.value=1;}else{expandit2('lostmp',0);cher.lpw.value=0;}">
					<a class='info' href="JavaScript:" >Olvid&eacute; mi Contrase&ntilde;a</a>
				</td>
			</tr>
		</table>
	</form>
<br>
	<DIV id='lostmp' style="visibility: hidden;  background-color:#616974; color: #FFFFFF; text-align:center; margin-right:26%;  margin-left:26%; border-radius: 14px; -moz-border-radius: 14px;" align='center'>
		<h2>Restablecer Contrase&ntilde;a</h2>
			Le enviaremos instrucciones para que pueda restablecer tu contrase&ntilde;a <br><br>
		<form name="flost" action="lostp.php" method="post" >
			<input onFocus="if(this.value=='email'){this.value=''}" onBlur="if(this.value==''){this.value='email'}" style="font-color:gray;border-radius: 14px; -moz-border-radius: 14px;" type='text' name='mail' size='30' value='email'>
			<input onFocus="if(this.value=='nombre usuario'){this.value=''}" onBlur="if(this.value==''){this.value='nombre usuario'}" style="font-color:gray; border-radius: 14px; -moz-border-radius: 14px;" type='text' name='us_' size='30' value='nombre usuario'><br><br>
			<input class='buton' style="font-size:14px; border-radius: 14px; -moz-border-radius: 14px;" onClick="if(validl()){document.flost.submit();};return false;" type='submit' name='send' value="Enviar">
			<input class='buton' style="font-size:14px; border-radius: 14px; -moz-border-radius: 14px;" onClick="expandit2('lostmp',0);cher.lpw.value=0;" type='reset' name='cancel' value="cancelar">
		</form>
	</div><script>expandit2('lostmp',0)</script>

<?php include("footer.php");?>

</BODY>
</HTML>
