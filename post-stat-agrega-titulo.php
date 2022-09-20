<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
?>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_acad.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" >
	 	var url_base="http://www.senescyt.gob.ec/web/guest/index.php/consultas/";
	 	var url_,fa_1,fa_2,fa_3,fa_4,fa_5,fa_6;
	 	function getc(){
	 		var cont=String(post1.idPaisr.options[post1.idPaisr.selectedIndex].value);
	 		if(cont== "undefined" || cont==''){
	 			alert('Escoja Pais Residencia');
	 		}else{
	 			post1.id_.value=cont;
	 		};
	 	};
	 </SCRIPT>
<HTML>
<BODY >
				<form name="cher" action="homeg.php" method="post" >
				<input type="hidden" name="resol">
				<input type="hidden" name="subsys">
				<input type="hidden" name="tus">
				</form>
<?php include("theader.php")?>

<table align="center" width="100%" border='0' style="border-style:none;" cellspacing='0' bordercolor='#0000ff'>
	<tr>
		<td valign='middle' align='center' colspan='3' class='literatura'><!--<img src='image/regcard.png'>--><font size='+1'><b> NUEVA FORMACI&Oacute;N ACAD&EacuteMICA</b> </font><br>
		</td>
	</tr>
<?php /*?>	<tr>
		<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="cher.action='index.php';cher.submit()"><a href="http://regprof.inpc.gob.ec"><!--<img src='image/home.png'>-->INICIO</a></td>
		<td class='menubar' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="return _submit('cher','browse-db-gui.php');return false;"><a href="Javascript:" onClick="return _submit('cher','browse-db-gui.php');return false;"><!--<img src='image/browse.png'>-->Base de Datos Profesionales Autorizados</a></td>
		<td class='menubar'align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick="cher.tus.value='0';return _submit('cher','log-im.php');"><a href="Javascript:" onClick="cher.tus.value='0';return _submit('cher','log-im.php');"><!--<img src='image/login.png'>-->Ingresar al Servicio</a></td>
	</tr><?php*/?>
</table>
	<hr>

<!--	<center><img style="width: 40%;" src='image/proces1.png'></center><br>-->
	<form name="post1" action="" method="post" onSubmit="" >
				<input type="hidden" name="id_">
				<input type="hidden" name="id_ciu">
				<input type="hidden" name="ciu_co">
				<input type="hidden" name="docid" value='<?php echo $_SESSION['user']?>'>
				<input type="hidden" name="subsys">
				<input type="hidden" name="is_post" value='1'>
	<table border='0' cellspacing='1' align='center' width='90%'>
		<tr>
			<td colspan='3'  align='center'><br>
				<table style="  border-width:0px; border-style:solid;" cellpadding='3' cellspacing='1' class='buton' >
					<tr ><td >
					<a href='Javascript:' onClick="if(!check_ci(post1.docid.value,false,1)){if(finfod.vis.value==0){expandit2('infod',1);finfod.vis.value=1;if(finfod.loaded.value==0){finfod.submit();};finfod.loaded.value=1;return false;}else{expandit2('infod',0);finfod.vis.value=0};return false;}else{post1.docid.focus();};return false;">
						<img style='border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff;background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;' src='image/vdatoseguro.png'>
					</a>
				</td></tr></table>
			<DIV id='infod' style="DISPLAY:none; head: ;" ><br>
				<iframe name='iinfod' frameborder='0'  height='405' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
			</div><script>expandit2('infod',0)</script>			
			</td>
		</tr>
		<tr>
			<td align='center' class='seccion2'>
				<strong> <font size='+1'>INFORMACI&Oacute;N ACAD&Eacute;MICA </font></strong><br>
				<div style="text-align:justify;"><strong> Nota: ingrese s&oacute;lo los t&iacute;tulos afines a esta postulaci&oacute;n.
				</strong></div>
				 <table border='0' width ='100%' cellpadding='5' >
					<tr><td  align='center' bgcolor='#ffffff'  colspan='3'><b>T&Iacute;TULO  ACAD&Eacute;MICO 1</b></td></tr>
					<tr bgcolor='#d3ddfc'>
						<input type='hidden' name='fa1' value='1'  >
						<td width='25%'>
						<b>NIVEL:</b><BR>
							<SELECT NAME="NivelT" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
								<!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
								<OPTION selected value="3">Tercer Nivel</OPTION>
								<OPTION  value="4">Cuarto Nivel</OPTION>
							</SELECT>
						</td>
						<td width='35%'>
						<b><!--<font color='black' size='+1'>*</font>-->T&Iacute;TULO ACAD&Eacute;MICO:</b><BR> <input type="text" name="ntitulo" value="" size="50" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td width='40%'>
						<b><!--<font color='black' size='+1'>*</font>-->INSTITUCI&OacuteN DE EDUCACI&Oacute;N SUPERIOR:</b><br> <input type="text" name="ninstitucion" value="" size="60" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
					</tr>
					<tr bgcolor='#d3ddfc'>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->FECHA GRADO  (aaaa/mm/dd):</b><br> <input type="text" name="ftitulo" value="" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br> <input type="text" name="codigo" value="" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td></td>
					</tr>
					<tr><td align='center' bgcolor='#ffffff' colspan='3'><b>T&Iacute;TULO  ACAD&Eacute;MICO 2</b></td></tr>
					<tr bgcolor='#d3ddfc'>
						<td>
						<b>NIVEL:</b><br> 
							<SELECT NAME="NivelT2" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
								<!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
								<OPTION selected value="3">Tercer Nivel</OPTION>
								<OPTION  value="4">Cuarto Nivel</OPTION>
							</SELECT>
						</td>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->T&Iacute;TULO ACAD&Eacute;MICO:</b><br> <input type="text" name="ntitulo2" value="" size="50" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->INSTITUCI&OacuteN DE EDUCACI&Oacute;N SUPERIOR:</b><br> <input type="text" name="ninstitucion2" value="" size="60" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
					</tr>
					<tr bgcolor='#d3ddfc'>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->FECHA GRADO  (aaaa/mm/dd):</b><br> <input type="text" name="ftitulo2" value="" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td>
						<b><!--<font color='black' size='+1'>*</font>-->N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br> <input type="text" name="codigo2" value="" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
						</td>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan='3' align='left'>		<br><strong> Si desconoce alguna informaci&oacute;n acad&eacute;mica consultar aqu&iacute;: <a name='sen' style='font-size:12px' class='info' href="Javascript:" onClick="if(post1.docid.value!=''){url_=url_base+post1.docid.value;abrir(url_,'sene',ancho/1.5,alto/1.5,0)}else{alert('Especifique Doc Identificacion');};">SENESCYT</a></strong></center>
<br></td>
		</tr>
		<tr>
			<td colspan='3' align='center'>
				<input class='buton' type="button" name="send" value="Aceptar" onFocus="" onBlur="" onClick="if(validate()){post1.target='_self';post1.action='post-stat-agrega-titulo2.php';post1.submit();}">
			</td>
		</tr>
	</table>
	</form>
	<form id="finfod" target='iinfod' action="ver-infodigital.php" method="post">
		<input type='hidden' name='vis' value='0'>
		<input type='hidden' name='loaded' value='0'>
		<input type='hidden' name='docid' value="<?php echo $_SESSION['user']?>">
		<input type="hidden" name="is_post" value='1'>
	</form>
</BODY>
</HTML>
