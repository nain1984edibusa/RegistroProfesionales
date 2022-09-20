<?php
#	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
#		header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
#		exit;
	};

?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
 	<SCRIPT LANGUAGE="JavaScript1.2">
 		var url;
 		var url_base="http://www.senescyt.gob.ec/web/guest/index.php/consultas";
		//var url_base="#";
	</SCRIPT>

 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90571230-1', 'auto');
  ga('send', 'pageview');

</script> 

<HTML>
<BODY>
	<form name="cher" action=" " method="post" >
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
		<input type="hidden" name="prof">
		<input type="hidden" name="topico">
		<input type='hidden' name='basecod'>
        </form>
<?php include("theader.php")?>

<table align="center" width="95%" border='0' style="border-style:solid; border: 1px solid lightgray;" cellspacing='0' bordercolor='#0000ff'>
<tr valign='middle'>
		<td colspan='5' align='center' class='literatura'><!--<img src='image/browse.png'>--><font size='+1'><b> BASE DE DATOS DE PROFESIONALES </b></font></td>
	</tr>
	<tr>
		<td  width='33%' class='menubar' width='10%' align="center"   onClick="cher.target='_self';cher.action='index.php';cher.submit()"><a href="http://<?php echo $_SERVER['SERVER_NAME'];?>/" ><!--<img src='image/home.png'>-->INICIO</a></td>
		<!--<td class='menubar' align="center"  onClick="return _submit('cher','post1.php');"><a href="JavaScript:" ><!--<img src='image/regcard.png'>Solicitar Certificaci&oacute;n de Registro</a></td>-->
		<!--<td  width='25%' class='menubar' align="center" onClick="cher.target='_self';cher.action='browse-db-gui.php';cher.submit();">
			<img src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'><br><a href="JavaScript:">Refrescar</a>
		</td>-->
		<td  width='33%' class='menubar' align="center"  onClick="cher.target='_self';cher.submit();return _submit('cher','log-im.php');"><a href="Javascript:" onClick="cher.target='_self';cher.submit();return _submit('cher','log-im.php');"><!--<img src='image/login.png'>-->Iniciar Sesi&oacute;n</a></td>
		<td  width='34%' align="center" align='center' class='menubar'>
			<a href="JavaScript:" onClick="abrir('','help',ancho*0.9,alto*0.85,0);cher.target='help';cher.topico.value='hbrowsedb';cher.action='ayuda-gui.php';cher.submit();cher.target='_self';return false;"><!--<img src='image/help.png'> -->Ayuda</a>
		</td>
	</tr>
</table>
<hr>
<!--	<strong>Elija un Registro : .... y haga click en &eacute;l para desplegar la Informaci&oacute;n</strong><br>-->
<?php
	$sql_us_maneja_ = $db->query("SELECT TipoProfesionalId FROM TipoProfesional" );
	$sql_us_maneja_->setFetchMode(PDO::FETCH_ASSOC);
	if($sql_us_maneja_->rowCount()>1){
		$twidth='60%';
		$tdwidth='30%';
	}else{
		$twidth='30%';
		$tdwidth='30%';
	};/*
?>
<TABLE border='0' cellspacing='0' cellpadding='2' width='<?php echo $twidth?>'>
	<tr>
<?php
	$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	foreach($_sql_us_maneja as $us_maneja) {
		$usm=$us_maneja['TipoProfesionalId']; 
?>
			<td class='cajita' width="<?php echo $tdwidth ?>" align='center' onClick="if(dbx<?php echo $usm;?>.vis.value==0){expandit2('ddbx<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=1;document.getElementById('dbx<?php echo $usm;?>').submit();return false;}else{expandit2('ddbx<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=0};return false;">
				&nbsp;<a href="JavaScript:" >
					<img name='xp_dbx<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
				&nbsp;<?php echo format_cont_db('TipoProfesionalId',$usm)?>: &nbsp;</a>
			</td>

<?php
	};
?>
</tr>
</table>
<?php */
	$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	foreach($_sql_us_maneja as $us_maneja) {
		$usm=$us_maneja['TipoProfesionalId']; 
?>
			<DIV id='ddbx<?php echo $usm;?>' style="DISPLAY:; head: ;" >
				<iframe name='idbx<?php echo $usm;?>' frameborder='1'  height='485' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbx<?php echo $usm;?>" target='idbx<?php echo $usm;?>' action="browse-db-data.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="<?php echo $usm;?>">
					<input type='hidden' name='pagina' value="0">
					<SCRIPT LANGUAGE="JavaScript1.2">dbx<?php echo $usm;?>.submit()</script>
				</form>
			</div>

<?php
	};
?>
			<DIV id='ddbx3' style="DISPLAY:; head: ;" >
				<iframe name='idbx3' frameborder='1'  height='485' width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbx3" target='idbx3' action="browse-db-data-r.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='us_maneja' value="2">
					<input type='hidden' name='pagina' value="0">
					<SCRIPT LANGUAGE="JavaScript1.2">dbx3.submit()</script>
				</form>
			</div>
<br>

<?php
	include ('footer.php');

$db=null;
exit;
?>
