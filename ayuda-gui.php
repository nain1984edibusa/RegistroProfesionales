<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	switch ($_POST['topico']){
		case 'hindex':
			$items=array('hindex');
		break;
		case 'hpost':
			$items=array('hsolic-registro','hsolic-registro2');
		break;
		case 'hbrowsedb':
			$items=array('hbrowsedb');
		break;
		case 'poststat':
			$items=array('hpoststat');
		break;
	};
?>

	 <HTML>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>

<BODY style="background-color:#f3f1cd;">
				<form name="cher" action=" " method="post" >
				<input type="hidden" name="tus">
				<input type="hidden" name="subsys">
				<input type="hidden" name="topico">
				<input type="hidden" name="vibl" value='0'>
				</form>
<a name='begin'></a><!--
<b><table border='0' width='100%' align='center' style="background-attachment: fixed;background-repeat:no-repeat;" background='image/web2014.png'>
		<tr valign='top' class='menu_'>
			<td align='center'><!--<font size='+2'><div class='cajita'> SERVICIO DE REGISTRO  DE PROFESIONALES INPC </div> </font>
			</td>
		</tr>
	</table> </b>--><HR>

<table align="center" width="80%" border='1' style="border-style:none;" cellspacing='4' bordercolor='#0000ff'>
  <tr>
      <td align="center"   class='literatura' colspan='4'><font size='+2'> SERVICIO DE REGISTRO  DE PROFESIONALES INPC - AYUDA EN L&Iacute;NEA </font>
	</td>
  </tr>
  <tr>
      <td align="center" class='literatura' >
			<a class='info' href="JavaScript:" onClick="abrir('https://drive.google.com/open?id=1P_X6JOwSzOc4Vn1aDhvygh3U8HtuWDINvWDPPNs1Lmk&authuser=0','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual Profesional Solicitante</a>
	</td>
  </tr>
<?php
	foreach($items as $item){
?>
  <tr>
      <td align="center" class='literatura' colspan='4'>
			<img border='1' src='image/help/<?php echo $item?>.png'>
	</td>
  </tr>
<?php
	};
?>
</table>
<?php include("footer.php");?>
</div></BODY>
</HTML>
