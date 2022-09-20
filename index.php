<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require('class/format_db_content.php');

?>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
<BODY >
				<form name="cher" action=" " method="post" >
				<input type="hidden" name="tus">
				<input type="hidden" name="subsys">
				<input type="hidden" name="topico">
				<input type='hidden' name='TPI'>
				<input type="hidden" name="vibl" value='0'>
<a name='begin'></a>
<?php include("theader.php")?>
<table align="center" width="95%" border='0' cellspacing='0' style="border-style:solid; border: 1px solid lightgray;"  >
  <tr>
      <td align="center" align='center' class='literatura' colspan='6'><font size='+1'><b><!-- SERVICIO DE--> REGISTRO Y CONSULTA DE PROFESIONALES <!--DEL INSTITUTO NACIONAL DE PATRIMONIO CULTURAL--> </b> </font>
			</td>
  </tr>
  <tr valign='middle'>
<!--			<td class='menubar'  align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="Javascript:"><img height='70%' src='image/home.png'><font size='+1'>INICIO</font></a>
			</td>-->
			<!--<td class='menubar'  align="center"  onClick="return _submit('cher','post1.php');"><a href="Javascript:" onClick="return _submit('cher','post1.php');"><!--<img  src='image/regcard.png'>Solicitar Registro en la Base de Datos</a>
			</td>-->
			<td width='25%'  class='menubar'  align="center"  onClick="cher.target='_self';return _submit('cher','browse-db-gui.php');"><a href="Javascript:" onClick="cher.target='_self';return _submit('cher','browse-db-gui.php');"><!--<img  src='image/browse.png'>--> Base de Datos de Profesionales</a>
			</td>
			<td width='25%'  class='menubar' align="center"  onClick="cher.target='_self';cher.tus.value='0';return _submit('cher','log-im.php');"><a href="Javascript:" onClick="cher.tus.value='0';return _submit('cher','log-im.php');"><!--<img  src='image/login.png'> -->Iniciar Sesi&oacute;n</a>
			</td>
	<!--</tr>
</table>
<table align="right"  border='1' style="border-style:none;" cellpadding='4' bordercolor='#0000ff'>
  <tr>-->
		<td width='25%' align="center" align='center' class='menubar' onClick="if(cher.vibl.value==0){expandit2('blegal',1);cher.vibl.value=1;}else{expandit2('blegal',0);cher.vibl.value=0};return false;">
			<a href="JavaScript:" onClick=""><!--<img  src='image/law.png'> -->Base Legal</a>
		</td>
		<td width='25%' align="center" align='center' class='menubar'>
			<a href="JavaScript:" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME'];?>/manual/MANUAL-USUARIO-EXTERNO.pdf','help',ancho,alto,0);return false;"><!--<img src='image/help.png'> -->Ayuda</a>
		</td>
  </tr>
</table>
<br>		<hr>
	<table align="center" border="0" cellspacing='0' width='90%'>
		<tr>
			<td >
				<table width="100%" align='left' border="0" cellpadding='2'>
					<tr>
						<td align='left' bgcolor='#ffffff' colspan='2' class='literatura'>
							<strong>Registro y Consulta de Profesionales </strong>
			    <p align='left' STYLE="  font-family: arial;  text-align:justify; margin-top:5; margin-right:5%; margin-bottom:5; margin-left:5%;">
			    El Servicio de Registro y Consulta de Profesionales en el Instituto Nacional de Patrimonio Cultural, tiene como objetivo regular el ejercicio 
			    profesional de: <strong>Arque&oacute;logos/as</strong>, <strong>Paleont&oacute;logos/as</strong>, y <strong>Restauradores/as de Bienes Culturales
			     Patrimoniales Muebles y Museos</strong>, que est&aacute;n facultados para trabajar en territorio ecuatoriano. Brindando a ciudadanos/as, instituciones, empresas 
			     p&uacute;blicas y privadas una Base de Datos de consulta.
			     <br><br>
			     El C&oacute;digo de Registro es &uacute;nico y no necesita renovaci&oacute;n.</p>
						</td>
					</tr>
					<tr>
						<td align='left'><br>
						</td>
					</tr>
				</table>
			</td>
	       </tr>
	</table>
	<table align='center' border='0' cellspacing='3' cellpadding='4' >
		<tr align='center'>
			<td nowrAP width='50%' colspan='2' class='elipse'  onClick="cher.TPI.value='1';return _submit('cher','post1.php');">
			<b><a href='JavaScript:'  onClick="cher.TPI.value='1';return _submit('cher','post1.php');">Solicitar Registro: Arque&oacute;logo(a) y Paleont&oacute;logo(a)</a></b>
			</td>
			<td nowrap width='50%' colspan='2' class='elipse' onClick="cher.TPI.value='2';return _submit('cher','post1.php');">
			<b><a href='JavaScript:' onClick="cher.TPI.value='2';return _submit('cher','post1.php');">Solicitar Registro: Restaurador(a) de Bienes Culturales Patrimoniales Muebles y Museos</a></b>
			</td>
		</tr>
		<tr><td colspan='4' align='center'>
			</div>
		</td></tr>		
		<tr align='center' >
			<td ><a title="Solicitar Registro: Arque&oacute;logo(a) y Paleont&oacute;logo(a)" href='JavaScript:'  onClick="cher.TPI.value='1';return _submit('cher','post1.php');"><img class="lar"  src='image/arqueo.png'></a></td>
			<td ><a title="Solicitar Registro: Arque&oacute;logo(a) y Paleont&oacute;logo(a)" href='JavaScript:'  onClick="cher.TPI.value='1';return _submit('cher','post1.php');"><img class="lar"  src='image/paleo.png'></a></td>
			<td ><a title="Solicitar Registro: Restaurador(a) de Bienes Culturales Patrimoniales y Museos" href='JavaScript:' onClick="cher.TPI.value='2';return _submit('cher','post1.php');"><img class="lar"  src='image/resta.png'></a></td>
			<td ><a  title="Solicitar Registro: Restaurador(a) de Bienes Culturales Patrimoniales y Museos" href='JavaScript:' onClick="cher.TPI.value='2';return _submit('cher','post1.php');"><img class="lar"  src='image/museog.png'></a></td>
		</tr>
	</table>
			<div id='blegal' style="DISPLAY:none; head: ;">
				<table border='0' width='50%' bordercolor='black' align='center' cellpadding='3'>
					<tr valign='middle'><th>
						<h1>BASE LEGAL	</h1>
					</th></tr>
					<tr valign='middle'><td>
						 <a style="font-weight:bold;" class='info' target='new' href="http://inpc.gob.ec/images/Descargas/2infolegal2014/marzo/normascreacion/leypc.pdf"><h1><img src='image/pdf-icon.png'> LEY DE PATRIMONIO CULTURAL	</h1></a>
					</td></tr>
					<tr valign='middle'><td nowrap >
						<a style="font-weight:bold;" class='info' target='new' href="http://inpc.gob.ec/images/Descargas/2infolegal2014/marzo/normascreacion/reglamentogeneraleypc.pdf"><h1><img src='image/pdf-icon.png'> REGLAMENTO GENERAL DE LA LEY DE PATRIMONIO CULTURAL	</h1></a>
					</td></tr>
					<tr valign='middle'><td >
						<a style="font-weight:bold;" class='info' target='new' href="http://mail.inpc.gob.ec/pdfs/Reglamentos-concesion-permisos-arq.pdf"><h1><img src='image/pdf-icon.png'>REGLAMENTO CONCESI&Oacute;N PERMISOS ARQUEOLOG&Iacute;A	</h1></a>
					</td></tr>
					<tr valign='middle'><td align='center'>
						Mayor informaci&oacute;n en la p&aacute;gina web del <a style="font-weight:bold;" class='info' target='new' href="http://inpc.gob.ec/component/content/article/727">INPC</a>
					</td></tr>
				</table><a id="blegala">&nbsp;</a>
			</div><script>expandit2('blegal',0)</script>
<?php include("footer.php");?><br>
<table border='0' align='center'>
<tr>
	<td>
		AVISO:esta aplicaci&oacute;n est&aacute; optimizada para trabajar con <a class="info" target='gc' href="http://www.google.com.ec/intl/es-419/chrome/"><img src="image/chrome.png"> Google Chrome</a>, 
		<a class="info"  target='mf' href="https://www.mozilla.org/es-ES/firefox/new/"><img src="image/firefox.png">Mozilla Firefox Version 22 o superior</a> y <a class="info" target='sa' href="https://www.apple.com/es/safari/"><img src="image/safari.png">Safari</a> de preferencia en sus versiones m&aacute;s actualizadas

	</td>
</tr>
</table>
</form>
</BODY>
</HTML>
