<?php
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_valid.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
 	 	var url;
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/consultas/";
	</SCRIPT>

 <HTML>
<BODY>
	<form name="cher" action=" " method="post" >
		<input type="hidden" name="clos">
		<input type="hidden" name="subsys">
	</form>

<?php include("theader.php")?>
<table align="center" width="97%" border='0' style="border-style:solid; border: 1px solid lightgray;" cellspacing='0'>
	<tr>
		<td colspan='4' align='center' class='literatura'><font size='+1'> SERVICIO DE REGISTRO DE PROFESIONALES</font></td>
		<td nowrap align='center' class='userbox'><font size='-1'> Usuari@:&nbsp;<?php echo $_SESSION['user']?> &nbsp;<img src='image/ic_person.png'></font> </td>
	</tr>
	<tr>
		<td  title="Refrescar Contenidos" onClick="cher.target='_self';cher.action='postulante-gui.php';cher.submit();" class='menubar'  align="center" onMouseOver="swap('reloadwi.png','reloadw.png','rld');overTD(this,'#d9dbdd');" onMouseOut="swap('reloadw.png','reloadwi.png','rld');outTD(this,'');">
			<a href="Javascript:"><img name='rld' height='15' src='image/reloadw.png' alt='refrescar pantalla' title='Refrescar pantalla'><!--Refrescar--></a>
		</td>
		<td align="center" align='center' class='menubar' title="Manual del Usuario">
	<?php /*?>		<a href="JavaScript:" onClick="abrir('https://drive.google.com/open?id=1P_X6JOwSzOc4Vn1aDhvygh3U8HtuWDINvWDPPNs1Lmk&authuser=0','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual</a><?php */?>
			<a href="JavaScript:" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME'];?>/manual/MANUAL-USUARIO-EXTERNO.pdf','help',ancho,alto,0);return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual Profesional Solicitante</a>
		</td>
		<td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');">
			<H1>REGISTRO DEL PROFESIONAL <?php echo format_cont_db('username',$_SESSION['user']) ?> </H1> 
		<!--<center><img style="width: 50%;" src='image/proces2.png'></center>-->
		</td>
		<td align="center" align='center' class='menubar' title="Cambiar Constrase&ntilde;a">
			<a href="JavaScript:" onClick="abrir('','cpw',ancho,alto,0);cher.target='cpw';cher.action='chpwd.php';cher.submit();return false;"><img src="image/https_w_18dp.png">Cambiar Contrase&ntilde;a</a>
		</td>
		<td  title="Cerrar Sesi&oacute;n" onClick="if(confirm('Seguro que desea terminar la sesion?')){cher.target='_self';cher.action='session.php';cher.clos.value='1';cher.submit();}else{return false;};" class='menubar' width='15%' align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');"><a href="Javascript:" >Salir<img src='image/exit_18dp.png'></a></td>
	</tr>
</table>
<hr>
	<strong>Haga click en <img src='image/downa.png' border='0' height='13'> para desplegar el men&uacute;</strong><br>
<?php
	$sql_us_maneja_ = $db->query("SELECT idProfesiones, TipoProfesional_TipoProfesionalId FROM Profesiones WHERE Profesional_idProfesional ='".$_SESSION['user']."'" );
	$sql_us_maneja_->setFetchMode(PDO::FETCH_ASSOC);
	$tipospr=$db->query("SELECT TipoProfesionalId FROM TipoProfesional" );
	$tipospr2=$tipospr;
	$k=0;
	$al=0;
	$extras=array();
	$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	while($row = $tipospr->fetch(PDO::FETCH_ASSOC)){
		$tiene_post=0;
		foreach($_sql_us_maneja as $maneja) {
			if($maneja['TipoProfesional_TipoProfesionalId']==$row['TipoProfesionalId']){
				$tiene_post=1;
			};
		};
		if (!$tiene_post){
			$extras[$k]=$row['TipoProfesionalId'];
			$k++;
		};
	};

	if(($sql_us_maneja_->rowCount()>1) or count($extras)>0 ){
		$twidth='66%';
		$tdwidth='33%';
	}else{
		$twidth='33%';
		$tdwidth='33%';
	};
	

?>
<TABLE border='0' cellpadding='2' cellspacing='0' width='<?php echo $twidth?>'>
	<tr valign='top'>
<?php
		//EN PROCESO DE MIGRACION
		$migrando_=0;
		$qregp_=$db->query("SELECT RegistroPActivo FROM RegistroP WHERE Profesional_idProfesional='".$_SESSION['user']."'");
		if ($qregp_->rowCount()>0){
			$regp_= $qregp_->fetch(PDO::FETCH_ASSOC);
			$reg_act_=$regp_['RegistroPActivo'];
			if(!$reg_act_ ){// TIENE REGISTRO Y NO ESTA ACTIVO, ESTA MIGRANDO, MOSTRAR FORMULARIO PARA ACTUALIZACION, SIN POSTULACION
				$migrando_=1;
			};
		};
	//EN PROCESO NORMAL SE BUSCA SI SOLICITUD EN PROCESO PARA OPORTUNIDAD DE EDITAR DATOS
	$edit_soli=1;
	//$_sql_us_maneja=$sql_us_maneja_->fetchAll();
	foreach($_sql_us_maneja as $us_maneja) {

		if ($edit_soli /*and !$migrando_*/){
			$post_in_proc = $db->query("SELECT idPostulacion FROM Postulacion WHERE Profesiones_idProfesiones ='".$us_maneja['idProfesiones']."' and PostulacionAsignado <> 0 and PostulacionFechaF is NULL");
			while($p_in_p = $post_in_proc->fetch(PDO::FETCH_ASSOC)) {
				$edit_soli=0;
				break;
			};
		};
	//FIN EN PROCESO NORMAL SE BUSCA SI SOLICITUD EN PROCESO PARA OPORTUNIDAD DE EDITAR DATOS
	
		$usm=$us_maneja['TipoProfesional_TipoProfesionalId'];

#        $sxval = $db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesional as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=0) and (t2.Profesional_idProfesional=t3.idProfesional and t3.TipoProfesional_TipoProfesionalId='".$usm."')");
#        $xval=$sxval->fetch(PDO::FETCH_ASSOC);
#		$xasb='';
#		if ($xval['tot']>0){
#			$xasb="<img src='image/ball_r.gif' alt='Acciones Pendientes!!'>";
#		};
?>
		<td class='menuitem' width="<?php echo $tdwidth ?>" align='center' onClick="if(dbx<?php echo $usm;?>.vis.value==0){op_act('td-dbx<?php echo $usm;?>','#FFFF99','bold');expandit2('ddbx<?php echo $usm;?>',1);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=1;document.getElementById('dbx<?php echo $usm;?>').submit();return false;}else{op_act('td-dbx<?php echo $usm;?>','#ffffff','normal');expandit2('ddbx<?php echo $usm;?>',0);swap('upa.png','downa.png','xp_dbx<?php echo $usm;?>');dbx<?php echo $usm;?>.vis.value=0};return false;">
			<a id='td-dbx<?php echo $usm;?>' href="JavaScript:" >
				<img name='xp_dbx<?php echo $usm;?>' src="image/downa.png" border='0' height='13' >
				&nbsp;<?php echo format_cont_db('TipoProfesionalId',$usm) ?>&nbsp;</a>
		</td>
<?php
	};
	if(!$migrando_){
		foreach($extras as $extra){
?>
			<td class='elipse' width="<?php echo $tdwidth ?>" align='center' onClick="if(confirm('Tenga en cuenta que la solicitud adicional se hace con la <?php echo utf8_decode('Información Personal y Académica ');?> actual\n\n<?php echo utf8_decode('Está Seguro?') ?>')){document.fnpx<?php echo $extra;?>.submit();};return false;">
				<a id='td-dbx<?php echo $extra;?>' href="JavaScript:" >
					<img name='add' src="image/add-18w.png" border='0' height='18px' >
				&nbsp;Solicitar postulaci&oacute;n adicional como:<br> <?php echo format_cont_db('TipoProfesionalId',$extra) ?>&nbsp;</a>
			</td>
<?php	
		};
	};
?>
	</tr>
</table>
<?php

#	$sql_us_manejas = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesiones WHERE user_username ='".$_SESSION['user']."'" );
#	while($us_manejas = $sql_us_maneja->fetch(PDO::FETCH_ASSOC)) {
	foreach($_sql_us_maneja as $us_maneja) {

		$usm=$us_maneja['TipoProfesional_TipoProfesionalId'];
		//EN PROCESO DE MIGRACION
		$migrando=0;
		$soli_mig=0;
		$script_post_stat='post_stat.php';
		$qregp=$db->query("SELECT RegistroPActivo FROM RegistroP WHERE Profesional_idProfesional='".$_SESSION['user']."' and RegistroPProfesionalID=".$usm."");
		if ($qregp->rowCount()>0){
			$regp= $qregp->fetch(PDO::FETCH_ASSOC);
			$reg_act=$regp['RegistroPActivo'];
			$post_in_proc_m = $db->query("SELECT idPostulacion FROM Postulacion WHERE Profesiones_idProfesiones ='".$us_maneja['idProfesiones']."'");
			while($p_in_p_m = $post_in_proc_m->fetch(PDO::FETCH_ASSOC)) {
				$soli_mig=1;
				break;
			};
#if($_SESSION['user']=='1706996418'){
#	 echo 'prueba '.$reg_act.' gggg '.$soli_mig;
#};

			if(!$reg_act and !$soli_mig ){// TIENE REGISTRO Y NO ESTA ACTIVO, ESTA MIGRANDO, MOSTRAR FORMULARIO PARA ACTUALIZACION, SIN POSTULACION
				$migrando=1;
				$script_post_stat='post_migra.php';
			};
		};
		if($migrando and $sql_us_maneja_->rowCount() > 1 and !$al){
		$al++;
		echo "<script>alert('Ud tiene pre-registro en ambas bases de datos, pero solo hace falta que actualice los datos en una, luego en la otra actualice sin hacer cambios para que sus datos sean validados por el INPC	para la otra base de datos')</script>";
		};
		//FIN EN PROCESO DE MIGRACION
?>
			<DIV id="ddbx<?php echo $usm;?>" style="DISPLAY: none;" ><br>
				<iframe id='IDB<?php echo $usm;?>' name='idbx<?php echo $usm;?>' frameborder='0'  width='100%' src="">
				  <p>Your browser does not support iframes.</p>
				</iframe>
				<form id="dbx<?php echo $usm;?>" name="fdbx<?php echo $usm;?>" target='idbx<?php echo $usm;?>' action="<?php echo $script_post_stat;?>" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='edit_soli' value="<?php echo $edit_soli?>">
					<input type='hidden' name='posts' value="<?php echo $us_maneja['idProfesiones'];?>">
					<input type='hidden' name='profes' value="<?php echo $us_maneja['TipoProfesional_TipoProfesionalId'];?>">
					<input type='hidden' name='ifid' value="IDB<?php echo $usm;?>">
					<input type='hidden' name='fifid' value="fdbx<?php echo $usm;?>">
				</form>
			</div>
			<script>expandit2("ddbx<?php echo $usm;?>",0)</script>
<br>
<br><br>

<?php
	};
	if(!$migrando){
		if( count($extras)>0 ){
			$datosp=$db->query("SELECT ProfesionalNombres, ProfesionalApellidos, ProfesionalMail, ProfesionalMail2 FROM  Profesional WHERE idProfesional='".$_SESSION['user']."'");
			$datosp->setFetchMode(PDO::FETCH_ASSOC);
			$pdatos=$datosp->fetchAll();
		};
		foreach($extras as $extra){
?>
			<DIV id="newp<?php echo $extra;?>" style="DISPLAY: none;" ><br>
				<form id="fnp<?php echo $extra;?>" name="fnpx<?php echo $extra;?>" target='_self' action="post2.php" method="post">
					<input type='hidden' name='vis' value='0'>
					<input type='hidden' name='newp' value="1">
					<input type='hidden' name='docid' value="<?php echo $_SESSION['user']?>">
					<input type='hidden' name='name' value="<?php echo $pdatos[0]['ProfesionalNombres']?>">
					<input type='hidden' name='lname' value="<?php echo $pdatos[0]['ProfesionalApellidos']?>">
					<input type='hidden' name='email' value="<?php echo $pdatos[0]['ProfesionalMail']?>">
					<input type='hidden' name='email2' value="<?php echo $pdatos[0]['ProfesionalMail2']?>">
					<input type='hidden' name='TipoProfesionalId' value="<?php echo $extra;?>">
					<input type='hidden' name='ifid' value="INP<?php echo $extra;?>">
				</form>
			</div>
<?php	
		};
	};
	include ('footer.php');

	$db=null;
exit;
?>
